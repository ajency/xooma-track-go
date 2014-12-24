var ProductChildView, UserProductChildView, UserProductListView,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

ProductChildView = (function(_super) {
  __extends(ProductChildView, _super);

  function ProductChildView() {
    return ProductChildView.__super__.constructor.apply(this, arguments);
  }

  ProductChildView.prototype.tagName = 'div';

  ProductChildView.prototype.className = 'list-title';

  ProductChildView.prototype.template = '<h5 class="bold text-primary">{{name}}</h5> <h6>{{servings}} times a day <b> {{qty}} {{product_type}} </b></h6>';

  return ProductChildView;

})(Marionette.ItemView);

UserProductChildView = (function(_super) {
  __extends(UserProductChildView, _super);

  function UserProductChildView() {
    return UserProductChildView.__super__.constructor.apply(this, arguments);
  }

  UserProductChildView.prototype.tagName = 'li';

  UserProductChildView.prototype.className = 'productlist';

  UserProductChildView.prototype.template = '<b class="text-success">{{type}}</b>';

  UserProductChildView.prototype.childView = ProductChildView;

  UserProductChildView.prototype.initialize = function() {
    var products;
    products = this.model.get('products');
    return this.collection = new Backbone.Collection(products);
  };

  return UserProductChildView;

})(Marionette.CompositeView);

UserProductListView = (function(_super) {
  __extends(UserProductListView, _super);

  function UserProductListView() {
    return UserProductListView.__super__.constructor.apply(this, arguments);
  }

  UserProductListView.prototype["class"] = 'animated fadeIn';

  UserProductListView.prototype.template = '#produts-template';

  UserProductListView.prototype.childView = UserProductChildView;

  UserProductListView.prototype.childViewContainer = 'ul.userProductList';

  return UserProductListView;

})(Marionette.CompositeView);

App.UserProductListCtrl = (function(_super) {
  __extends(UserProductListCtrl, _super);

  function UserProductListCtrl() {
    this._showView = __bind(this._showView, this);
    return UserProductListCtrl.__super__.constructor.apply(this, arguments);
  }

  UserProductListCtrl.prototype.initialize = function() {
    return App.currentUser.getUserProducts().done(this._showView).fail(this.errorHandler);
  };

  UserProductListCtrl.prototype._showView = function(collection) {
    var productcollection;
    productcollection = new Backbone.Collection(collection);
    return this.show(new UserProductListView({
      collection: productcollection
    }));
  };

  return UserProductListCtrl;

})(Marionette.RegionController);
