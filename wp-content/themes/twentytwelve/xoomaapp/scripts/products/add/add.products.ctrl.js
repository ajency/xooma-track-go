var AddProductsView, NoProductsChildView, ProductChildView,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

ProductChildView = (function(_super) {
  __extends(ProductChildView, _super);

  function ProductChildView() {
    this.successHandler = __bind(this.successHandler, this);
    return ProductChildView.__super__.constructor.apply(this, arguments);
  }

  ProductChildView.prototype.tagName = 'li';

  ProductChildView.prototype.template = '<a class="cbp-vm-image" href="#"><img src="{{image}}"></a> <h3 class="cbp-vm-title">{{name}}</h3> <div class="cbp-vm-details"> {{description}} </div> <a id="{{id}}"  class="cbp-vm-icon cbp-vm-add add-product" href="#">Add Product</a>';

  ProductChildView.prototype.ui = {
    addProduct: '.add-product'
  };

  ProductChildView.prototype.initialize = function() {
    return this.$el.prop("id", 'product' + this.model.get("id"));
  };

  ProductChildView.prototype.events = {
    'click @ui.addProduct': function(e) {
      var id;
      e.preventDefault();
      id = e.target.id;
      return App.currentUser.addProduct(id).done(this.successHandler).fail(this.errorHandler);
    }
  };

  ProductChildView.prototype.successHandler = function(response, status, xhr) {
    console.log(status);
    if (xhr.status === 201) {
      return $('#product' + response).hide();
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

  AddProductsView.prototype.template = '#add-product-template';

  AddProductsView.prototype.childView = ProductChildView;

  AddProductsView.prototype.childViewContainer = 'ul.products-list';

  AddProductsView.prototype.emptyView = NoProductsChildView;

  AddProductsView.prototype.onShow = function() {
    return $.getScript(_SITEURL + "/html/html/assets/js/cbpViewModeSwitch.js");
  };

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
    filteredCollection = App.productCollection.clone();
    c = filteredCollection.remove(userProducts);
    return this.show(new AddProductsView({
      collection: filteredCollection
    }));
  };

  return AddProductsCtrl;

})(Ajency.RegionController);
