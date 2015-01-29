var ScheduleView,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

App.state('Schedule', {
  url: '/products/:id/consume',
  parent: 'xooma'
});

ScheduleView = (function(_super) {
  __extends(ScheduleView, _super);

  function ScheduleView() {
    this.saveHandler = __bind(this.saveHandler, this);
    return ScheduleView.__super__.constructor.apply(this, arguments);
  }

  ScheduleView.prototype.template = '#schedule-template';

  ScheduleView.prototype.ui = {
    intake: '.intake',
    update: '.update',
    form: '#consume',
    scheduleid: 'input[name="scheduleid"]',
    servings: '.servings',
    original: '.original',
    responseMessage: '.aj-response-message',
    cancel: '.cancel'
  };

  ScheduleView.prototype.events = {
    'click @ui.servings': function(e) {
      var meta_id, qty;
      e.preventDefault();
      console.log(meta_id = $(e.target).parent().attr('data-value'));
      console.log(qty = $(e.target).parent().attr('data-qty'));
      if (meta_id !== "") {
        $('#intake').removeClass("intake");
        $('#intake').addClass("update");
        $('#mydataModal').removeClass("hidden");
      }
      return ScheduleView.prototype.update_occurrences(meta_id, qty);
    },
    'click @ui.original': function(e) {
      var first, qty, temp;
      e.preventDefault();
      $('#meta_id').val(0);
      $('#qty').val("");
      $('#intake').addClass("intake");
      $('#intake').removeClass("update");
      $('#mydataModal').removeClass("hidden");
      temp = [];
      qty = this.model.get('qty');
      $.each(this.model.get('occurrence'), function(ind, val) {
        var expected, occurrence;
        occurrence = _.has(val, "occurrence");
        expected = _.has(val, "expected");
        if (occurrence === false && expected === true && qty[ind] !== void 0) {
          return temp.push(qty[ind]);
        }
      });
      first = temp[0];
      return ScheduleView.prototype.create_occurrences(first);
    },
    'click .intake': function(e) {
      var data, date, meta_id, product, qty;
      e.preventDefault();
      meta_id = $('#meta_id').val();
      qty = $('#qty').val();
      console.log(data = $('#schduleid').val());
      product = this.model.get('id');
      date = moment().format("YYYY-MM-DD");
      return $.ajax({
        method: 'POST',
        data: 'meta_id=' + meta_id + '&qty=' + qty + '&date=' + date,
        url: "" + _SITEURL + "/wp-json/intakes/" + (App.currentUser.get('ID')) + "/products/" + product,
        success: this.saveHandler,
        error: this.erroraHandler
      });
    },
    'click @ui.cancel': function(e) {
      $('#qty').val("");
      return $('#mydataModal').addClass("hidden");
    },
    'click .update': function(e) {
      var data, meta_id, product, qty;
      e.preventDefault();
      meta_id = $('#meta_id').val();
      qty = $('#qty').val();
      console.log(data = $('#schduleid').val());
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

  ScheduleView.prototype.saveHandler = function(response, status, xhr) {
    this.model.set('occurrence', response.occurrence);
    this.ui.responseMessage.text("Servings are updated!!!!");
    $('#mydataModal').addClass("hidden");
    return $('#xoomaproduct').html(listview.render().el);
  };

  ScheduleView.prototype.serializeData = function() {
    var bonus, data, no_servings, occurr, product_type, qty, temp;
    data = ScheduleView.__super__.serializeData.call(this);
    data.day = moment().format("dddd");
    data.today = moment().format("MMMM Do YYYY");
    qty = this.model.get('qty');
    occurr = this.model.get('occurrence');
    product_type = this.model.get('product_type');
    product_type = product_type.toLowerCase();
    no_servings = [];
    temp = [];
    bonus = parseInt(this.model.get('occurrence').length) - parseInt(qty.length);
    $.each(occurr, function(ind, val) {
      if (qty[ind] !== void 0) {
        return temp.push(val);
      }
    });
    $.each(temp, function(ind, val) {
      var expected, i, newClass, occurrence, servings;
      occurrence = _.has(val, "occurrence");
      expected = _.has(val, "expected");
      if (occurrence === true && expected === true) {
        newClass = product_type + '_occurred_class';
      } else if (occurrence === false && expected === true) {
        newClass = product_type + '_expected_class';
      } else if (occurrence === true && expected === false) {
        newClass = product_type + '_bonus_class';
      }
      i = 0;
      servings = [];
      while (i < qty[ind].qty) {
        servings.push({
          newClass: newClass
        });
        i++;
      }
      no_servings.push({
        servings: servings,
        schedule: val.schedule_id,
        meta_id: val.meta_id,
        qty: qty[ind].qty
      });
      return data.no_servings = no_servings;
    });
    data.original = product_type + '_expected_class';
    data.bonus = bonus;
    return data;
  };

  ScheduleView.prototype.create_occurrences = function(val) {
    console.log(val.qty);
    $('#meta_id').val(0);
    return $('#qty').val(val.qty);
  };

  ScheduleView.prototype.update_occurrences = function(meta_id, qty) {
    if (meta_id === "") {
      meta_id = 0;
    }
    $('#meta_id').val(parseInt(meta_id));
    return $('#qty').val(qty);
  };

  return ScheduleView;

})(Marionette.ItemView);

App.ScheduleCtrl = (function(_super) {
  __extends(ScheduleCtrl, _super);

  function ScheduleCtrl() {
    this.successHandler = __bind(this.successHandler, this);
    return ScheduleCtrl.__super__.constructor.apply(this, arguments);
  }

  ScheduleCtrl.prototype.initialize = function(options) {
    var product, productId, productModel, products, productsColl;
    if (options == null) {
      options = {};
    }
    this.show(this.parent().getLLoadingView());
    productId = this.getParams();
    product = parseInt(productId[0]);
    products = [];
    console.log(App.useProductColl);
    App.useProductColl.each(function(val) {
      return products.push(val);
    });
    productsColl = new Backbone.Collection(products);
    productModel = productsColl.where({
      id: parseInt(productId[0])
    });
    return this._showView(productModel[0]);
  };

  ScheduleCtrl.prototype.successHandler = function(response, status, xhr) {
    var model;
    model = new Backbone.Model(response);
    return this._showView(model);
  };

  ScheduleCtrl.prototype._showView = function(productModel) {
    console.log(productModel);
    return this.show(new ScheduleView({
      model: productModel
    }));
  };

  return ScheduleCtrl;

})(Ajency.RegionController);
