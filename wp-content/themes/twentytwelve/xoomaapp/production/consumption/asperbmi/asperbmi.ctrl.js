var AsperbmiView,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

App.state('Asperbmi', {
  url: '/products/:id/bmi/:date',
  parent: 'xooma'
});

AsperbmiView = (function(_super) {
  __extends(AsperbmiView, _super);

  function AsperbmiView() {
    this.stopProgress = __bind(this.stopProgress, this);
    this.startProgress = __bind(this.startProgress, this);
    this.update_occurrences = __bind(this.update_occurrences, this);
    this.create_occurrences = __bind(this.create_occurrences, this);
    this.erroraHandler = __bind(this.erroraHandler, this);
    this.saveHandler = __bind(this.saveHandler, this);
    return AsperbmiView.__super__.constructor.apply(this, arguments);
  }

  AsperbmiView.prototype.template = '#asperbmi-template';

  AsperbmiView.prototype.ui = {
    responseMessage: '.aj-response-message'
  };

  AsperbmiView.prototype.events = {
    'click #confirm': function(e) {
      var currentime, date, meta_id, product, qty, s, t, time, todays_date;
      $('.loadingconusme').html('<img src="' + _SITEURL + '/wp-content/themes/twentytwelve/xoomaapp/images/ajax-loader.gif" width="40px">');
      e.preventDefault();
      meta_id = this.$el.find('#meta_id').val();
      qty = (this.originalBottleRemaining - this.bottleRemaining) / 100;
      if (qty === 0) {
        $('.loadingconusme').html("");
        window.removeMsg();
        this.ui.responseMessage.addClass('alert alert-danger').text("No change in the quantity!");
        $('html, body').animate({
          scrollTop: 0
        }, 'slow');
        return;
      }
      if (parseInt(this.model.get('available')) <= 0) {
        $('.loadingconusme').html("");
        window.removeMsg();
        this.ui.responseMessage.addClass('alert alert-danger').text("Produt out of stock!");
        $('html, body').animate({
          scrollTop: 0
        }, 'slow');
        return;
      }
      product = this.model.get('id');
      date = App.currentUser.get('homeDate');
      todays_date = moment().format('YYYY/MM/DD');
      currentime = moment(App.currentUser.get('today'), 'YYYY-MM-DD HH:mm:ss').format('HH:mm:ss');
      s = moment(todays_date + currentime, 'YYYY-MM-DD HH:mm:ss').format('hh:mm A');
      t = $('#consume_time').val();
      time = moment(t, "hh:mm A").format("HH:mm:ss");
      return $.ajax({
        method: 'POST',
        data: 'meta_id=' + meta_id + '&qty=' + qty + '&date=' + date + '&time=' + time,
        url: "" + _APIURL + "/intakes/" + (App.currentUser.get('ID')) + "/products/" + product,
        success: this.saveHandler,
        error: this.erroraHandler
      });
    },
    'click .reset-progress': function() {
      this.bottleRemaining = this.originalBottleRemaining;
      return this.bottle.setProgress(this.bottleRemaining);
    },
    'touchstart .bottle': 'startProgress',
    'mousedown .bottle': 'startProgress',
    'touchend .bottle': 'stopProgress',
    'mouseup .bottle': 'stopProgress',
    'mouseout .bottle': 'stopProgress'
  };

  AsperbmiView.prototype.saveHandler = function(response, status, xhr) {
    var cnt, count1, index, model, msg, occurResponse, tempColl;
    $('.loadingconusme').html("");
    count1 = 0;
    if (xhr.status === 201) {
      occurResponse = _.map(response.occurrence[0].occurrence, function(occurrence) {
        var expected, occur;
        occurrence.meta_id = parseInt(occurrence.meta_id);
        occur = _.has(occurrence, "occurrence");
        expected = _.has(occurrence, "expected");
        if (occur === true && expected === true) {
          count1++;
        }
        return occurrence;
      });
      console.log(response);
      this.model.set('occurrence', response.occurrence[0].occurrence);
      model = new UserProductModel;
      model.set(response.occurrence[0]);
      App.useProductColl.add(model, {
        merge: true
      });
      this.$el.find('#meta_id').val(response.meta_id);
      tempColl = new Backbone.Collection(occurResponse);
      model = tempColl.findWhere({
        meta_id: parseInt(response.meta_id)
      });
      index = tempColl.indexOf(model);
      index = parseInt(index) + 1;
      cnt = this.getCount(model.get('meta_value'));
      this.originalBottleRemaining = this.bottleRemaining;
      msg = this.showMessage(cnt);
      if (parseInt(count1) >= parseInt(response.occurrence[0].occurrence.length) && parseInt(cnt) === 1) {
        $('.bonus').text('(Bonus)');
      }
      $('.msg').html(msg);
      if (parseInt(cnt) === 1) {
        cnt = 0;
        this.create_occurrences(index);
      }
      $('.bottlecnt').text(cnt);
      window.removeMsg();
      this.ui.responseMessage.addClass('alert alert-success').text("Consumption saved!");
      return $('html, body').animate({
        scrollTop: 0
      }, 'slow');
    } else {
      return this.showErrorMsg();
    }
  };

  AsperbmiView.prototype.erroraHandler = function(response, status, xhr) {
    return this.showErrorMsg();
  };

  AsperbmiView.prototype.showErrorMsg = function() {
    window.removeMsg();
    this.ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be saved!");
    return $('html, body').animate({
      scrollTop: 0
    }, 'slow');
  };

  AsperbmiView.prototype.getCount = function(val) {
    var count;
    count = 0;
    if (!(_.isArray(val))) {
      count += parseFloat(val.qty);
    } else {
      $.each(val, function(ind, val1) {
        if (!(_.isArray(val1))) {
          return count += parseFloat(val1.qty);
        } else {
          return $.each(val1, function(ind, val2) {
            if (_.isArray(val2)) {
              return $.each(val2, function(ind, value) {
                return count += parseFloat(value.qty);
              });
            } else {
              return count += parseFloat(val2.qty);
            }
          });
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
    data.today = moment().format("MMMM Do YYYY");
    return data;
  };

  AsperbmiView.prototype.onShow = function() {
    var currentime, date, s, timezone, todays_date;
    timezone = App.currentUser.get('offset');
    todays_date = moment().format('YYYY-MM-DD');
    date = Marionette.getOption(this, 'date');
    currentime = moment.utc(App.currentUser.get('today'), 'YYYY-MM-DD HH:mm:ss').zone(timezone).format('HH:mm:ss');
    s = moment(todays_date + currentime, 'YYYY-MM-DD HH:mm:ss').format('hh:mm A');
    $('.input-small').val(s);
    $('#date').val(date);
    return this.generate(this.model.get('occurrence'));
  };

  AsperbmiView.prototype.generate = function(data) {
    var bonus, count, count1, ind, occur;
    occur = data;
    bonus = 0;
    count1 = 0;
    count = 0;
    console.log(this.model);
    console.log(this.model.get('occurrence').length);
    $.each(occur, (function(_this) {
      return function(ind, val) {
        var expected, meta_id, occurrence;
        occurrence = _.has(val, "occurrence");
        expected = _.has(val, "expected");
        meta_id = val.meta_id;
        count = _this.getCount(val.meta_value);
        if (occurrence === true && (expected === true || expected === false) && count === 1) {
          count1++;
          return true;
        } else if (occurrence === true && (expected === true || expected === false) && count !== 1) {
          _this.update_occurrences(val, ind, occur);
          return false;
        } else {
          _this.create_occurrences(ind);
          return false;
        }
      };
    })(this));
    if (parseInt(this.model.get('occurrence').length) === parseInt(count1)) {
      ind = 'bonus';
      return this.create_occurrences(ind);
    }
  };

  AsperbmiView.prototype.create_occurrences = function(ind) {
    var msg;
    console.log(this.model);
    if (ind === 'bonus') {
      $('.bonus').text('(Bonus)');
      ind = parseInt(this.model.get('occurrence').length);
    }
    $('#meta_id').val(0);
    $('.serving').text('Serving ' + (parseInt(ind) + 1));
    $('.bottlecnt').text('No Consumption');
    msg = this.showMessage(0);
    $('.msg').text(msg);
    this.originalBottleRemaining = 100;
    this.bottleRemaining = 100;
    return this.bottle = new EAProgressVertical(this.$el.find('.bottle'), this.bottleRemaining, 'empty', 10000, [25, 50, 75]);
  };

  AsperbmiView.prototype.update_occurrences = function(data, ind, occur) {
    var consumed, count, meta_value, msg;
    count = 0;
    meta_value = data.meta_value;
    count = this.getCount(data.meta_value);
    ind = ind + 1;
    consumed = 0;
    $.each(occur, (function(_this) {
      return function(ind, val) {
        var expected, occurrence;
        occurrence = _.has(val, "occurrence");
        expected = _.has(val, "expected");
        if (occurrence === true && expected === false) {
          return consumed++;
        }
      };
    })(this));
    if (parseInt(consumed) >= 1) {
      ind = 'bonus';
      $('.bonus').text('(Bonus)');
      ind = parseInt(occur.length);
    }
    $('#add').hide();
    $('.serving').text('Serving ' + (parseInt(ind)));
    $('#meta_id').val(parseInt(data.meta_id));
    $('.bottlecnt').text(count);
    msg = this.showMessage(count);
    $('.msg').html(msg);
    this.bottleRemaining = 100 - 100 * count;
    this.originalBottleRemaining = this.bottleRemaining;
    return this.bottle = new EAProgressVertical(this.$el.find('.bottle'), this.bottleRemaining, 'empty', 10000, [25, 50, 75]);
  };

  AsperbmiView.prototype.showMessage = function(count) {
    var msg, temp;
    console.log(count);
    temp = [0, 0.25, 0.5, 0.75, 1];
    msg = "";
    $.each(temp, function(ind, val) {
      if (parseFloat(count) === parseFloat(val)) {
        return console.log(msg = x2oMessages[val]);
      }
    });
    return msg;
  };

  AsperbmiView.prototype.startProgress = function() {
    return this.bottle.startProgress();
  };

  AsperbmiView.prototype.stopProgress = function() {
    var progress;
    progress = this.bottle.stopProgress(true);
    this.bottle.setProgress(progress);
    return this.bottleRemaining = progress;
  };

  return AsperbmiView;

})(Marionette.ItemView);

App.AsperbmiCtrl = (function(_super) {
  __extends(AsperbmiCtrl, _super);

  function AsperbmiCtrl() {
    this.showView = __bind(this.showView, this);
    return AsperbmiCtrl.__super__.constructor.apply(this, arguments);
  }

  AsperbmiCtrl.prototype.initialize = function(options) {
    if (options == null) {
      options = {};
    }
    this.show(this.parent().getLLoadingView());
    return App.currentUser.getHomeProducts().done(this.showView).fail(this.errorHandler);
  };

  AsperbmiCtrl.prototype.showView = function(Collection) {
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

  AsperbmiCtrl.prototype._showView = function(productModel, date) {
    return this.show(new AsperbmiView({
      model: productModel,
      date: date
    }));
  };

  return AsperbmiCtrl;

})(Ajency.RegionController);
