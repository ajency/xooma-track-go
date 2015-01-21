var AsperbmiView,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

App.state('Asperbmi', {
  url: '/products/:id/bmi',
  parent: 'xooma'
});

AsperbmiView = (function(_super) {
  __extends(AsperbmiView, _super);

  function AsperbmiView() {
    this.saveHandler = __bind(this.saveHandler, this);
    return AsperbmiView.__super__.constructor.apply(this, arguments);
  }

  AsperbmiView.prototype.template = '#asperbmi-template';

  AsperbmiView.prototype.ui = {
    responseMessage: '.aj-response-message'
  };

  AsperbmiView.prototype.events = {
    'click #ssconfirm': function(e) {
      var count, meta_id, product, qty;
      e.preventDefault();
      console.log(count = $('#confirm').attr('data-count', count));
      if (parseInt(count) === 0) {
        this.ui.responseMessage.text("Consumption not updated!!!!");
        return false;
      }
      meta_id = $('#meta_id').val();
      qty = $('#percentage').val();
      product = this.model.get('id');
      return $.ajax({
        method: 'POST',
        data: 'meta_id=' + meta_id + '&qty=' + qty,
        url: "" + _SITEURL + "/wp-json/intakes/" + (App.currentUser.get('ID')) + "/products/" + product,
        success: this.saveHandler,
        error: this.erroraHandler
      });
    }
  };

  AsperbmiView.prototype.saveHandler = function(response, status, xhr) {
    var cnt, cntColl, model, temp, tempColl;
    $('#percentage').val(0);
    console.log(response);
    this.model.set('occurrence', response.occurrence);
    console.log($('#meta_id').val(response.meta_id));
    cntColl = new Backbone.Collection(response.occurrence);
    temp = cntColl.filter(function(model) {
      var meta_id;
      meta_id = model.get('meta_id');
      model.set('meta_id', parseInt(meta_id));
      return model;
    });
    console.log(tempColl = new Backbone.Collection(temp));
    console.log(model = tempColl.findWhere({
      meta_id: parseInt(response.meta_id)
    }));
    cnt = this.getCount(model.get('meta_value'));
    if (parseInt(cnt) === 1) {
      cnt = 0;
    }
    $('.bottlecnt').text(cnt);
    return this.generate(response.occurrence);
  };

  AsperbmiView.prototype.getCount = function(val) {
    var count;
    count = 0;
    if (!(_.isArray(val))) {
      count += parseFloat(val.qty);
    } else {
      $.each(val, function(ind, val1) {
        console.log(val1);
        if (_.isArray(val1)) {
          return $.each(val1, function(item, value) {
            return count += parseFloat(value.qty);
          });
        } else {
          return count += parseFloat(val1.qty);
        }
      });
    }
    return count;
  };

  AsperbmiView.prototype.serializeData = function() {
    var arr1, count, data;
    data = AsperbmiView.__super__.serializeData.call(this);
    arr1 = [];
    count = 0;
    data.day = moment().format("dddd");
    console.log(data.today = moment().format("MMMM Do YYYY"));
    return data;
  };

  AsperbmiView.prototype.onShow = function() {
    return this.generate(this.model.get('occurrence'));
  };

  AsperbmiView.prototype.generate = function(data) {
    var bonus, count1, occur;
    console.log(occur = data);
    bonus = 0;
    count1 = 0;
    console.log(this.model.get('occurrence').length);
    console.log(this.model.get('servings'));
    bonus = parseInt(this.model.get('occurrence').length) - parseInt(this.model.get('servings'));
    $('.bonus').text(bonus);
    $.each(occur, function(ind, val) {
      var count, expected, meta_id, occurrence;
      console.log(occurrence = _.has(val, "occurrence"));
      console.log(expected = _.has(val, "expected"));
      meta_id = val.meta_id;
      console.log(val.meta_value);
      count = AsperbmiView.prototype.getCount(val.meta_value);
      if (occurrence === true && (expected === true || expected === false) && count === 1) {
        count1++;
        return true;
      } else if (occurrence === true && (expected === true || expected === false) && count !== 1) {
        console.log(count);
        AsperbmiView.prototype.update_occurrences(val);
        return false;
      } else {
        AsperbmiView.prototype.create_occurrences();
        return false;
      }
    });
    if ((parseInt(this.model.get('occurrence').length)) === parseInt(count1)) {
      return AsperbmiView.prototype.create_occurrences();
    }
  };

  AsperbmiView.prototype.create_occurrences = function() {
    $('#meta_id').val(0);
    return $('.bottlecnt').text(0);
  };

  AsperbmiView.prototype.update_occurrences = function(data) {
    var confirm, count, meta_value;
    $('#add').hide();
    $('#meta_id').val(parseInt(data.meta_id));
    count = 0;
    meta_value = data.meta_value;
    count = this.getCount(data.meta_value);
    confirm = parseFloat(count) / 0.25;
    return $('.bottlecnt').text(count);
  };

  return AsperbmiView;

})(Marionette.ItemView);

App.AsperbmiCtrl = (function(_super) {
  __extends(AsperbmiCtrl, _super);

  function AsperbmiCtrl() {
    return AsperbmiCtrl.__super__.constructor.apply(this, arguments);
  }

  AsperbmiCtrl.prototype.initialize = function(options) {
    var product, productId, productModel, products, productsColl;
    if (options == null) {
      options = {};
    }
    productId = this.getParams();
    product = parseInt(productId[0]);
    products = [];
    App.useProductColl.each(function(val) {
      return products.push(val);
    });
    productsColl = new Backbone.Collection(products);
    productModel = productsColl.where({
      id: parseInt(productId[0])
    });
    return this._showView(productModel[0]);
  };

  AsperbmiCtrl.prototype._showView = function(productModel) {
    console.log(productModel);
    return this.show(new AsperbmiView({
      model: productModel
    }));
  };

  return AsperbmiCtrl;

})(Ajency.RegionController);
