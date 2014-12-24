var AddProductsView, NoProductsChildView, ProductChildView,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

ProductChildView = (function(_super) {
  __extends(ProductChildView, _super);

  function ProductChildView() {
    return ProductChildView.__super__.constructor.apply(this, arguments);
  }

  ProductChildView.prototype.template = 'Single product view here';

  return ProductChildView;

})(Marionette.ItemView);

NoProductsChildView = (function(_super) {
  __extends(NoProductsChildView, _super);

  function NoProductsChildView() {
    return NoProductsChildView.__super__.constructor.apply(this, arguments);
  }

  NoProductsChildView.prototype.template = 'Awesome. You have added all products. Have fun';

  return NoProductsChildView;

})(Marionette.ItemView);

AddProductsView = (function(_super) {
  __extends(AddProductsView, _super);

  function AddProductsView() {
    return AddProductsView.__super__.constructor.apply(this, arguments);
  }

  AddProductsView.prototype["class"] = 'animated fadeIn';

  AddProductsView.prototype.template = '<ul class="products-list"></ul>';

  AddProductsView.prototype.childView = ProductChildView;

  AddProductsView.prototype.childViewContainer = 'ul.products-list';

  AddProductsView.prototype.emptyView = NoProductsChildView;

  return AddProductsView;

})(Marionette.CompositeView);

App.AddProductsCtrl = (function(_super) {
  __extends(AddProductsCtrl, _super);

  function AddProductsCtrl() {
    return AddProductsCtrl.__super__.constructor.apply(this, arguments);
  }

  AddProductsCtrl.prototype.initialize = function(options) {
    if (options == null) {
      options = {};
    }
    if (App.productCollection.length === 0) {
      return App.productCollection.fetch().done(this._showProducts);
    } else {
      return this._showProducts();
    }
  };

  AddProductsCtrl.prototype._showProducts = function() {
    var c, filteredCollection, userProducts;
    userProducts = App.currentUser.get('products');
    filteredCollection = new Backbone.Collection;
    c = App.productCollection.without(userProducts);
    console.log(c);
    return this.show(new AddProductsView({
      collection: App.productCollection
    }));
  };

  return AddProductsCtrl;

})(Marionette.RegionController);
