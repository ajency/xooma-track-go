var ScheduleView,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

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
    'click .reset': function(e) {
      var qty;
      qty = $('#org_qty').val();
      this.ui.rangeSliders.val(parseInt(qty));
      this.ui.rangeSliders.parent().find("output").html(qty);
      $('#consume_time').val("");
      return $('.now').text('Now');
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
      $('.loadingconusme').html('<img src="' + _SITEURL + '/wp-content/themes/twentytwelve/xoomaapp/images/ajax-loader.gif" width="40px">');
      e.preventDefault();
      meta_id = $('#meta_id').val();
      qty = this.ui.qty.val();
      data = $('#schduleid').val();
      product = this.model.get('id');
      date = App.currentUser.get('homeDate');
      console.log(t = $('#consume_time').val());
      time = moment(t, "HH:mm a").format("HH:mm:ss");
      if (t === "") {
        time = moment().format("HH:mm:ss");
      }
      return $.ajax({
        method: 'POST',
        data: 'meta_id=' + meta_id + '&qty=' + qty + '&date=' + date + '&time=' + time,
        url: "" + _SITEURL + "/wp-json/intakes/" + (App.currentUser.get('ID')) + "/products/" + product,
        success: this.saveHandler,
        error: this.erroraHandler
      });
    },
    'click #skip': function(e) {
      var data, date, meta_id, product, qty, t, time;
      e.preventDefault();
      $('.loadingconusme').html('<img src="' + _SITEURL + '/wp-content/themes/twentytwelve/xoomaapp/images/ajax-loader.gif" width="40px">');
      meta_id = $('#meta_id').val();
      qty = 0;
      data = $('#schduleid').val();
      product = this.model.get('id');
      date = App.currentUser.get('homeDate');
      t = $('#consume_time').val();
      time = moment(t, "HH:mm a").format("HH:mm:ss");
      if (t === "") {
        time = moment().format("HH:mm:ss");
      }
      return $.ajax({
        method: 'POST',
        data: 'meta_id=' + meta_id + '&qty=' + qty + '&date=' + date + '&time=' + time,
        url: "" + _SITEURL + "/wp-json/intakes/" + (App.currentUser.get('ID')) + "/products/" + product,
        success: this.saveHandler,
        error: this.erroraHandler
      });
    }
  };

  ScheduleView.prototype.saveHandler = function(response, status, xhr) {
    var model;
    console.log(response);
    this.model.set('occurrence', response.occurrence[0].occurrence);
    model = new UserProductModel;
    model.set(response.occurrence[0]);
    App.useProductColl.add(model, {
      merge: true
    });
    return App.navigate("#/home", true);
  };

  ScheduleView.prototype.onShow = function() {
    var actual_time, current, currentime, d, date, hours, minutes, occurr, qty, s, temp, timezone, todays_date;
    timezone = App.currentUser.get('timezone');
    todays_date = moment().format('YYYY-MM-DD');
    currentime = moment(App.currentUser.get('today'), 'YYYY-MM-DD HH:mm:ss').format('HH:mm:ss');
    s = moment(todays_date + currentime, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
    d = new Date(s);
    actual_time = d.getTime();
    current = new Date(actual_time);
    console.log(hours = current.getHours());
    console.log(minutes = current.getMinutes());
    date = Marionette.getOption(this, 'date');
    occurr = this.model.get('occurrence');
    temp = [];
    qty = this.model.get('qty');
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
        return false;
      }
    });
    $('#date').val(date);
    $('.input-small').timepicker({
      maxTime: {
        hour: hours,
        minute: minutes
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
    var bonus, data, model, no_servings, occurr, product_type, qty, temp, whenarr;
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
    model = this.model;
    whenarr = [0, 'Morning Before meal', 'Morning After meal', 'Night Before meal', 'Night After meal'];
    $.each(temp, function(ind, val) {
      var expected, occurrence;
      occurrence = _.has(val, "occurrence");
      expected = _.has(val, "expected");
      if (occurrence === false && expected === true) {
        if (model.get('type') === 'Anytime') {
          data.serving = 'Serving ' + (parseInt(ind) + 1);
        } else {
          data.serving = whenarr[qty[ind].when];
        }
        data.qty = qty[ind].qty;
        return false;
      }
    });
    data.product_type = product_type;
    return data;
  };

  ScheduleView.prototype.create_occurrences = function(val) {
    $('#meta_id').val(0);
    $('#org_qty').val(val);
    return console.log($('#org_qty'));
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
    this.showView = __bind(this.showView, this);
    return ScheduleCtrl.__super__.constructor.apply(this, arguments);
  }

  ScheduleCtrl.prototype.initialize = function(options) {
    var date, locationurl, product, productModel, products, productsColl, url;
    if (options == null) {
      options = {};
    }
    url = window.location.hash.split('#');
    locationurl = url[1].split('/');
    product = parseInt(locationurl[2]);
    date = locationurl[4];
    products = [];
    App.useProductColl.each(function(val) {
      return products.push(val);
    });
    productsColl = new Backbone.Collection(products);
    productModel = productsColl.where({
      id: parseInt(product)
    });
    if (productModel.length === 0) {
      return App.currentUser.getHomeProducts().done(this.showView).fail(this.errorHandler);
    } else {
      return this._showView(productModel[0], date);
    }
  };

  ScheduleCtrl.prototype.showView = function(Collection) {
    var date, locationurl, product, productModel, url;
    url = window.location.hash.split('#');
    locationurl = url[1].split('/');
    product = parseInt(locationurl[2]);
    date = locationurl[4];
    productModel = App.useProductColl.where({
      id: parseInt(product)
    });
    return this._showView(productModel[0], date);
  };

  ScheduleCtrl.prototype._showView = function(productModel, date) {
    return this.show(new ScheduleView({
      model: productModel,
      date: date
    }));
  };

  return ScheduleCtrl;

})(Ajency.RegionController);
