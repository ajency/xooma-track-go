var ViewProductHistoryView,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

App.state('ViewProductHistory', {
  url: '/product/:id/history',
  parent: 'xooma'
});

ViewProductHistoryView = (function(_super) {
  __extends(ViewProductHistoryView, _super);

  function ViewProductHistoryView() {
    this.getCount = __bind(this.getCount, this);
    this.errorHandler = __bind(this.errorHandler, this);
    this.successHandler = __bind(this.successHandler, this);
    this.loadData = __bind(this.loadData, this);
    this.showView = __bind(this.showView, this);
    return ViewProductHistoryView.__super__.constructor.apply(this, arguments);
  }

  ViewProductHistoryView.prototype.template = '#view-history-template';

  ViewProductHistoryView.prototype.ui = {
    responseMessage: '.aj-response-message'
  };

  ViewProductHistoryView.prototype.events = {
    'click #show': function() {
      var product;
      product = Marionette.getOption(this, 'id');
      return this.loadData(product);
    },
    'click .consume': function(e) {
      var date, model, product;
      e.preventDefault();
      product = Marionette.getOption(this, 'id');
      product = Marionette.getOption(this, 'id');
      date = moment($('#picker_inline_fixed').val()).format("YYYY-MM-DD");
      if ($('#picker_inline_fixed').val() === "") {
        date = moment().format("YYYY-MM-DD");
      }
      model = App.useProductColl.findWhere({
        id: parseInt(product)
      });
      if (model.get('name').toUpperCase() === 'X2O') {
        return App.navigate("#products/" + product + '/bmi/' + date, true);
      } else {
        return App.navigate("#products/" + product + '/consume/' + date, true);
      }
    }
  };

  ViewProductHistoryView.prototype.onShow = function() {
    var model, product;
    product = Marionette.getOption(this, 'id');
    model = App.useProductColl.findWhere({
      id: parseInt(product)
    });
    if (model === void 0) {
      return App.currentUser.getUserProducts().done(this.showView).fail(this.errorHandler);
    } else {
      return this.loadView();
    }
  };

  ViewProductHistoryView.prototype.showView = function(collection) {
    return this.loadView();
  };

  ViewProductHistoryView.prototype.loadView = function() {
    var date, model, product;
    product = Marionette.getOption(this, 'id');
    date = moment($('#picker_inline_fixed').val()).format("YYYY-MM-DD");
    if ($('#picker_inline_fixed').val() === "") {
      date = moment().format("YYYY-MM-DD");
    }
    model = App.useProductColl.findWhere({
      id: parseInt(product)
    });
    if (model.get('name').toUpperCase() === 'X2O') {
      $('.consume').attr('href', "#products/" + product + '/bmi/' + date);
    } else {
      $('.consume').attr('href', "#products/" + product + '/consume/' + date);
    }
    this.loadData(product);
    return $('#picker_inline_fixed').datepicker({
      inline: true,
      dateFormat: 'yy-mm-dd',
      changeYear: true,
      changeMonth: true,
      maxDate: new Date(),
      onChangeMonthYear: function(y, m, i) {
        var d;
        d = i.selectedDay;
        return $('#picker_inline_fixed').datepicker('setDate', new Date(y, m - 1, d));
      }
    });
  };

  ViewProductHistoryView.prototype.loadData = function(id) {
    var date, product;
    product = id;
    date = moment($('#picker_inline_fixed').val()).format("YYYY-MM-DD");
    if ($('#picker_inline_fixed').val() === "") {
      date = moment().format("YYYY-MM-DD");
    }
    if (!window.isWebView()) {
      $('.viewHistory').html('<li>Loading data<img src="' + _SITEURL + '/wp-content/themes/twentytwelve/xoomaapp/images/lodaing.GIF" width="70px"></li>');
    }
    if (window.isWebView()) {
      $('.viewHistory').html('<li>Loading data<img src="./images/lodaing.GIF" width="70px"></li>');
    }
    return $.ajax({
      method: 'GET',
      data: 'date=' + date,
      url: "" + _SITEURL + "/wp-json/history/" + (App.currentUser.get('ID')) + "/products/" + product,
      success: this.successHandler,
      error: this.errorHandler
    });
  };

  ViewProductHistoryView.prototype.successHandler = function(response, status, xhr) {
    if (xhr.status === 200) {
      return this.showData(response);
    } else {
      return this.showErrorMsg();
    }
  };

  ViewProductHistoryView.prototype.errorHandler = function(response, status, xhr) {
    return this.showErrorMsg();
  };

  ViewProductHistoryView.prototype.showErrorMsg = function() {
    window.removeMsg();
    this.ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be loaded!");
    return $('html, body').animate({
      scrollTop: 0
    }, 'slow');
  };

  ViewProductHistoryView.prototype.showData = function(response) {
    var arr, coll, d, html, n, timezone;
    coll = new Backbone.Collection(response.response);
    $('.name').text(response.name.toUpperCase());
    html = "";
    arr = 0;
    d = new Date();
    n = -(d.getTimezoneOffset());
    timezone = n;
    if (App.currentUser.get('timezone') !== null) {
      timezone = App.currentUser.get('timezone');
    }
    coll.each(function(index) {
      var data, fromnow, i, meta_id, meta_value, qty, time, time1, timestamp;
      if (index.get('meta_value').length !== 0 && response.name.toUpperCase() !== 'X2O') {
        meta_value = index.get('meta_value');
        meta_id = index.get('meta_value');
        d = new Date(meta_value.date);
        timestamp = d.getTime();
        time = moment(timestamp).zone(timezone).format("h:mm A");
        time1 = moment(timestamp).zone(timezone).format("x");
        fromnow = moment(time1).fromNow();
        qty = meta_value.qty;
        arr++;
        return html += '<li class="work' + meta_id + '"><div class="relative"> <label class="labels" class="m-t-20" for="work' + meta_id + '">' + qty + ' CONSUMED</label> <span class="date"><i class="fa fa-clock-o"></i> ' + time + ' <small class=""></small></span> <span class="circle"></span> </div><li>';
      } else {
        i = 0;
        data = ViewProductHistoryView.prototype.getCount(index.get('meta_value'));
        return $.each(data, function(ind, val) {
          i++;
          d = new Date(val.date);
          timestamp = d.getTime();
          time = moment(timestamp).zone(timezone).format("h:mm A");
          time1 = moment(timestamp).zone(timezone).format("x");
          fromnow = moment(time1).fromNow();
          qty = val.qty;
          meta_id = parseInt(index.get('meta_id')) + parseInt(i);
          arr++;
          return html += '<li class="work' + meta_id + '"><div class="relative"> <label class="labels" class="m-t-20" for="work' + meta_id + '">' + qty + ' CONSUMED</label> <span class="date"><i class="fa fa-clock-o"></i> ' + time + ' <small class=""></small></span> <span class="circle"></span> </div><li>';
        });
      }
    });
    if (arr === 0) {
      html = '<li>No consumption found for the selected date.<li>';
    }
    return $('.viewHistory').html(html);
  };

  ViewProductHistoryView.prototype.getCount = function(val) {
    var count;
    count = [];
    if (!_.isArray(val)) {
      count.push({
        date: val.date,
        qty: val.qty
      });
    } else {
      $.each(val, function(ind, val1) {
        if (!(_.isArray(val1))) {
          return count.push({
            date: val1.date,
            qty: val1.qty
          });
        } else {
          return $.each(val1, function(ind, val2) {
            if (_.isArray(val2)) {
              return $.each(val2, function(ind, val3) {
                return count.push({
                  date: val3.date,
                  qty: val3.qty
                });
              });
            } else {
              return count.push({
                date: val2.date,
                qty: val2.qty
              });
            }
          });
        }
      });
    }
    return count;
  };

  ViewProductHistoryView.prototype.scrollPageTo = function($node) {
    $('html, body').animate({
      scrollTop: ~~$node.offset().top - 60
    }, 150);
    return $('body').css('overflow', 'auto');
  };

  return ViewProductHistoryView;

})(Marionette.ItemView);

App.ViewProductHistoryCtrl = (function(_super) {
  __extends(ViewProductHistoryCtrl, _super);

  function ViewProductHistoryCtrl() {
    return ViewProductHistoryCtrl.__super__.constructor.apply(this, arguments);
  }

  ViewProductHistoryCtrl.prototype.initialize = function(options) {
    var productId, products;
    if (options == null) {
      options = {};
    }
    this.show(this.parent().getLLoadingView());
    productId = this.getParams();
    products = [];
    return this._showView(productId[0]);
  };

  ViewProductHistoryCtrl.prototype._showView = function(model) {
    return this.show(new ViewProductHistoryView({
      id: model
    }));
  };

  return ViewProductHistoryCtrl;

})(Ajency.RegionController);
