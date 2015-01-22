var ProductHistoryChildView, ViewProductHistoryView,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

App.state('ViewProductHistory', {
  url: '/product/:id/history',
  parent: 'xooma'
});

ProductHistoryChildView = (function(_super) {
  __extends(ProductHistoryChildView, _super);

  function ProductHistoryChildView() {
    return ProductHistoryChildView.__super__.constructor.apply(this, arguments);
  }

  ProductHistoryChildView.prototype.tagName = 'li';

  ProductHistoryChildView.prototype.className = '.class';

  ProductHistoryChildView.prototype.template = '<input class="radio" id ="work{{meta_id}}" name="works" type="radio" checked> <div class="relative"> <label class="labels" for="work{{meta_id}}">{{product_type}}</label> <span class="date">{{date}}</span> <span class="circle"></span> </div> <div class="content"> <p> Consumed : <b>{{qty}}</b><br> Time : <b>{{time}}</b><br> </p> </div>';

  ProductHistoryChildView.prototype.serializeData = function() {
    var data, meta_value, timezone;
    data = ProductHistoryChildView.__super__.serializeData.call(this);
    meta_value = this.model.get('meta_value');
    timezone = App.currentUser.get('timezone');
    data.time = moment(meta_value.date + timezone, "HH:mm Z").format("hA");
    data.qty = meta_value.qty;
    return data;
  };

  return ProductHistoryChildView;

})(Marionette.ItemView);

ViewProductHistoryView = (function(_super) {
  __extends(ViewProductHistoryView, _super);

  function ViewProductHistoryView() {
    return ViewProductHistoryView.__super__.constructor.apply(this, arguments);
  }

  ViewProductHistoryView.prototype.template = '#view-history-template';

  ViewProductHistoryView.prototype.childView = ProductHistoryChildView;

  ViewProductHistoryView.prototype.childViewContainer = 'ul.viewHistory';

  return ViewProductHistoryView;

})(Marionette.CompositeView);

App.ViewProductHistoryCtrl = (function(_super) {
  __extends(ViewProductHistoryCtrl, _super);

  function ViewProductHistoryCtrl() {
    this.successHandler = __bind(this.successHandler, this);
    return ViewProductHistoryCtrl.__super__.constructor.apply(this, arguments);
  }

  ViewProductHistoryCtrl.prototype.initialize = function(options) {
    var productId, products;
    if (options == null) {
      options = {};
    }
    productId = this.getParams();
    products = [];
    return this._showView(productId[0]);
  };

  ViewProductHistoryCtrl.prototype._showView = function(model) {
    var date, product;
    product = model;
    date = moment().format("YYYY-MM-DD");
    return $.ajax({
      method: 'GET',
      data: 'date=' + date,
      url: "" + _SITEURL + "/wp-json/history/" + (App.currentUser.get('ID')) + "/products/" + product,
      success: this.successHandler,
      error: this.errorHandler
    });
  };

  ViewProductHistoryCtrl.prototype.successHandler = function(response, status, xhr) {
    var coll;
    coll = new Backbone.Collection(response);
    return this.show(new ViewProductHistoryView({
      collection: coll
    }));
  };

  return ViewProductHistoryCtrl;

})(Ajency.RegionController);
