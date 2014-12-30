var HomeView, HomeViewChildView, ProductChildView,
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

  ProductChildView.prototype.template = Handlebars.compile('<h5 class="bold text-primary">{{name}}</h5> <h6>{{servings}} times a day <b> {{qty}} {{product_type}} </b></h6>');

  return ProductChildView;

})(Marionette.ItemView);

HomeViewChildView = (function(_super) {
  __extends(HomeViewChildView, _super);

  function HomeViewChildView() {
    return HomeViewChildView.__super__.constructor.apply(this, arguments);
  }

  HomeViewChildView.prototype.tagName = 'li';

  HomeViewChildView.prototype.className = 'productlist';

  HomeViewChildView.prototype.template = Handlebars.compile('<b class="text-success">{{type}}</b>');

  HomeViewChildView.prototype.childView = ProductChildView;

  HomeViewChildView.prototype.initialize = function() {
    var products;
    products = this.model.get('products');
    return this.collection = new Backbone.Collection(products);
  };

  return HomeViewChildView;

})(Marionette.CompositeView);

HomeView = (function(_super) {
  __extends(HomeView, _super);

  function HomeView() {
    return HomeView.__super__.constructor.apply(this, arguments);
  }

  HomeView.prototype["class"] = 'animated fadeIn';

  HomeView.prototype.template = '#home-template';

  HomeView.prototype.childView = HomeViewChildView;

  HomeView.prototype.childViewContainer = 'ul.userProductList';

  return HomeView;

})(Marionette.CompositeView);

App.HomeCtrl = (function(_super) {
  __extends(HomeCtrl, _super);

  function HomeCtrl() {
    this._showView = __bind(this._showView, this);
    return HomeCtrl.__super__.constructor.apply(this, arguments);
  }

  HomeCtrl.prototype.initialize = function() {
    return App.currentUser.getHomeProducts().done(this._showView).fail(this.errorHandler);
  };

  HomeCtrl.prototype._showView = function(collection) {
    var productcollection;
    productcollection = new Backbone.Collection(collection);
    return this.show(new HomeView({
      collection: productcollection
    }));
  };

  return HomeCtrl;

})(Ajency.RegionController);
