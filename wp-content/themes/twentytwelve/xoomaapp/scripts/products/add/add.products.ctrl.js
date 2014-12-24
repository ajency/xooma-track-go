var AddProductsView, NoProductsChildView, ProductChildView,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

ProductChildView = (function(_super) {
  __extends(ProductChildView, _super);

  function ProductChildView() {
    return ProductChildView.__super__.constructor.apply(this, arguments);
  }

  ProductChildView.prototype.tagName = 'li';

  ProductChildView.prototype.template = '<span>{{name}}</span><button data-del="{{id}}" class="btn btn-primary btn-lg add-product">Add Product</button>';

  ProductChildView.prototype.ui = {
    addProduct: '.add-product'
  };

  ProductChildView.prototype.events = {
    'click @ui.addProduct': function(e) {
      console.log(this);
      return console.log($('#' + e.target.id).attr('data-del'));
    }
  };

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
    this._showProducts = __bind(this._showProducts, this);
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
    return this.show(new AddProductsView({
      collection: App.productCollection
    }));
  };

  return AddProductsCtrl;

})(Ajency.RegionController);
