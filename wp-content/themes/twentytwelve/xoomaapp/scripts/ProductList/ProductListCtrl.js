var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

App.ProductListCtrl = (function(_super) {
  __extends(ProductListCtrl, _super);

  function ProductListCtrl() {
    this.successHandler = __bind(this.successHandler, this);
    this._showView = __bind(this._showView, this);
    return ProductListCtrl.__super__.constructor.apply(this, arguments);
  }

  ProductListCtrl.prototype.initialize = function(options) {
    var xhr;
    xhr = this._getProducts();
    return xhr.done(this._showView).fail(this._showView);
  };

  ProductListCtrl.prototype._showView = function(response) {
    var newProducts;
    newProducts = this._getNewProducts(response);
    return this.show(new ProductListView({
      collection: newProducts
    }));
  };

  ProductListCtrl.prototype._getProducts = function() {};

  ProductListCtrl.prototype.successHandler = function(response, status, responsecode) {
    if (responsecode.status === 200) {
      return App.productList = new Backbone.Collection(response);
    }
  };

  ProductListCtrl.prototype._getNewProducts = function(response) {
    var newProducts, productIds, userProducts;
    productIds = [];
    $.each(response, function(index, value) {
      return productIds.push(parseInt(value.id));
    });
    App.currentUser.set('userProducts', [142, 132]);
    userProducts = App.currentUser.get('userProducts');
    newProducts = _.difference(productIds, userProducts);
    return new Backbone.Collection(newProducts);
  };

  return ProductListCtrl;

})(Marionette.RegionController);
