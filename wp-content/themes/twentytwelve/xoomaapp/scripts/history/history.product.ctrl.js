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

  ProductHistoryChildView.prototype.template = '<div>{{qty}}</div><div>{{date}}</div>';

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
    var product;
    product = model;
    return $.ajax({
      method: 'GET',
      data: 'date=2015-01-13',
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
