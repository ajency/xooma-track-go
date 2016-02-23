var AddProductsView, NoProductsChildView, ProductChildView,
  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  hasProp = {}.hasOwnProperty,
  bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

App.state('AddProducts', {
  url: '/signIn',
  parent: 'xooma'
});

ProductChildView = (function(superClass) {
  extend(ProductChildView, superClass);

  function ProductChildView() {
    return ProductChildView.__super__.constructor.apply(this, arguments);
  }

  ProductChildView.prototype.tagName = 'li';

  ProductChildView.prototype.template = '<div class="cbp-vm-image" ><img src="{{image}}"></div> <h3 class="cbp-vm-title">{{name}}</h3> <div class="cbp-vm-details"> {{description}} </div> <a id="{{id}}"  class="cbp-vm-icon cbp-vm-add add-product" href="#/product/{{id}}/edit">Add</a>';

  ProductChildView.prototype.ui = {
    addProduct: '.add-product'
  };

  ProductChildView.prototype.initialize = function() {
    return this.$el.prop("id", 'product' + this.model.get("id"));
  };

  return ProductChildView;

})(Marionette.ItemView);

NoProductsChildView = (function(superClass) {
  extend(NoProductsChildView, superClass);

  function NoProductsChildView() {
    return NoProductsChildView.__super__.constructor.apply(this, arguments);
  }

  NoProductsChildView.prototype.template = 'Awesome. You have added all products. Have fun';

  return NoProductsChildView;

})(Marionette.ItemView);

AddProductsView = (function(superClass) {
  extend(AddProductsView, superClass);

  function AddProductsView() {
    return AddProductsView.__super__.constructor.apply(this, arguments);
  }

  AddProductsView.prototype["class"] = 'animated fadeIn';

  AddProductsView.prototype.template = '#add-product-template';

  AddProductsView.prototype.childView = ProductChildView;

  AddProductsView.prototype.childViewContainer = 'ul.products-list';

  AddProductsView.prototype.emptyView = NoProductsChildView;

  AddProductsView.prototype.events = {
    'click .grid': function(e) {
      return e.preventDefault();
    }
  };

  AddProductsView.prototype.onShow = function() {
    this.trigger("remove:loader");
    return $.getScript(_SITEURL + "/html/html/assets/js/cbpViewModeSwitch.js", function(item) {});
  };

  return AddProductsView;

})(Marionette.CompositeView);

App.AddProductsCtrl = (function(superClass) {
  extend(AddProductsCtrl, superClass);

  function AddProductsCtrl() {
    this._showProducts = bind(this._showProducts, this);
    this.removeLoader = bind(this.removeLoader, this);
    return AddProductsCtrl.__super__.constructor.apply(this, arguments);
  }

  AddProductsCtrl.prototype.initialize = function(options) {
    var computed_url, url;
    if (options == null) {
      options = {};
    }
    this.listenTo(this, "remove:loader", this.removeLoader);
    url = '#' + App.currentUser.get('state');
    computed_url = '#' + window.location.hash.split('#')[1];
    if (url !== '#/profile/my-products' && url !== '#/home') {
      return this.show(new workflow);
    } else {
      if (App.productCollection.length === 0) {
        return App.productCollection.fetch().done(this._showProducts).fail(this.errorHandler);
      } else {
        return this._showProducts();
      }
    }
  };

  AddProductsCtrl.prototype.removeLoader = function() {
    return this.show(this.parent().getLLoadingView());
  };

  AddProductsCtrl.prototype._showProducts = function() {
    var collectionArr, filteredCollection, temp, userProducts;
    userProducts = App.currentUser.get('products');
    collectionArr = App.productCollection.where({
      active_value: '1'
    });
    temp = [];
    $.each(collectionArr, function(ind, val) {
      if ($.inArray(parseInt(val.get('id')), userProducts) === -1) {
        return temp.push(val);
      }
    });
    filteredCollection = App.productCollection.clone();
    filteredCollection.reset(temp);
    return this.show(new AddProductsView({
      collection: filteredCollection
    }));
  };

  return AddProductsCtrl;

})(Ajency.RegionController);
