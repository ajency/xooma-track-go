// Generated by CoffeeScript 1.9.0
var ScheduleView,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  __hasProp = {}.hasOwnProperty;

App.state('Schedule', {
  url: '/products/:id/consume/:date',
  parent: 'xooma'
});

ScheduleView = (function(_super) {
  __extends(ScheduleView, _super);

  function ScheduleView() {
    this.valueOutput = __bind(this.valueOutput, this);
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
    cancel: '.cancel',
    rangeSliders: '[data-rangeslider]',
    consume_time: 'input[name="consume_time"]',
    qty: 'input[name="qty"]'
  };

  ScheduleView.prototype.events = {
    'change @ui.rangeSliders': function(e) {
      return this.valueOutput(e.currentTarget);
    },
    'click @ui.servings': function(e) {
      var meta_id, qty;
      e.preventDefault();
      meta_id = $(e.target).parent().attr('data-value');
      qty = $(e.target).parent().attr('data-qty');
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
      var data, date, meta_id, product, qty, t, time;
      e.preventDefault();
      meta_id = $('#meta_id').val();
      qty = this.ui.qty.val();
      data = $('#schduleid').val();
      product = this.model.get('id');
      date = $('#date').val();
      console.log(t = $('#consume_time').val());
      time = moment(t).format("HH:mm:ss");
      if (t === "") {
        time = moment().format("HH:mm:ss");
      }
      return $.ajax({
        method: 'POST',
        data: 'meta_id=' + meta_id + '&qty=' + qty + '&date=' + date + '&time=' + time,
        url: _SITEURL + "/wp-json/intakes/" + (App.currentUser.get('ID')) + "/products/" + product,
        success: this.saveHandler,
        error: this.erroraHandler
      });
    },
    'click .update': function(e) {
      var data, meta_id, product, qty;
      e.preventDefault();
      meta_id = $('#meta_id').val();
      qty = $('#qty').val();
      data = $('#schduleid').val();
      product = this.model.get('id');
      return $.ajax({
        method: 'POST',
        data: 'meta_id=' + meta_id + '&qty=' + qty,
        url: _SITEURL + "/wp-json/intakes/" + (App.currentUser.get('ID')) + "/products/" + product,
        success: this.saveHandler,
        error: this.erroraHandler
      });
    }
  };

  ScheduleView.prototype.saveHandler = function(response, status, xhr) {
    return this.model.set('occurrence', response.occurrence);
  };

  ScheduleView.prototype.onShow = function() {
    var date;
    date = Marionette.getOption(this, 'date');
    $('#date').val(date);
    $('.js__timepicker').pickatime({
      interval: 15,
      onSet: function(context) {
        return $('.now').text($('#consume_time').val());
      }
    });
    this.ui.rangeSliders.each((function(_this) {
      return function(index, ele) {
        return _this.valueOutput(ele);
      };
    })(this));
    return this.ui.rangeSliders.rangeslider({
      polyfill: false
    });
  };

  ScheduleView.prototype.valueOutput = function(element) {
    return $(element).parent().find("output").html($(element).val());
  };

  ScheduleView.prototype.serializeData = function() {
    var bonus, data, no_servings, occurr, product_type, qty, temp;
    console.log(this.model);
    data = ScheduleView.__super__.serializeData.call(this);
    data.day = moment().format("dddd");
    data.today = moment().format("MMMM Do YYYY");
    qty = this.model.get('qty');
    occurr = this.model.get('occurrence');
    product_type = this.model.get('product_type');
    product_type = product_type.toLowerCase();
    data.classname = product_type + '_default_class';
    no_servings = [];
    temp = [];
    bonus = parseInt(this.model.get('occurrence').length) - parseInt(qty.length);
    $.each(occurr, function(ind, val) {
      if (qty[ind] !== void 0) {
        return temp.push(val);
      }
    });
    $.each(temp, function(ind, val) {
      var expected, occurrence;
      occurrence = _.has(val, "occurrence");
      expected = _.has(val, "expected");
      if (occurrence === false && expected === true) {
        console.log(qty[ind].qty);
        ScheduleView.prototype.create_occurrences(qty[ind].qty);
        data.qty = qty[ind].qty;
        return false;
      }
    });
    data.product_type = product_type;
    return data;
  };

  ScheduleView.prototype.create_occurrences = function(val) {
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
    var date, product, productId, productModel, products, productsColl;
    if (options == null) {
      options = {};
    }
    console.log(productId = this.getParams());
    product = 3;
    date = '2015-02-02';
    products = [];
    App.useProductColl.each(function(val) {
      return products.push(val);
    });
    productsColl = new Backbone.Collection(products);
    productModel = productsColl.where({
      id: parseInt(product)
    });
    return this._showView(productModel[0], date);
  };

  ScheduleCtrl.prototype.successHandler = function(response, status, xhr) {
    var model;
    model = new Backbone.Model(response);
    return this._showView(model);
  };

  ScheduleCtrl.prototype._showView = function(productModel, date) {
    return this.show(new ScheduleView({
      model: productModel,
      date: date
    }));
  };

  return ScheduleCtrl;

})(Ajency.RegionController);
