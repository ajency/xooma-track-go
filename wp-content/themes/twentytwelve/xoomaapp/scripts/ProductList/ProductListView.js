var ProductItemView, ProductListView,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

ProductItemView = (function(_super) {
  __extends(ProductItemView, _super);

  function ProductItemView() {
    return ProductItemView.__super__.constructor.apply(this, arguments);
  }

  ProductItemView.prototype.template = '<span>product1</span><button class="btn btn-primary btn-lg addProduct">Add Prodcut</button>';

  ProductItemView.prototype.initialize = function() {
    return console.log(this.model.get('id'));
  };

  ProductItemView.prototype.ui = {
    addProduct: '.addProduct'
  };

  ProductItemView.prototype.events = {
    'click @ui.addProduct': function(e) {}
  };

  return ProductItemView;

})(Marionette.ItemView);

ProductListView = (function(_super) {
  __extends(ProductListView, _super);

  function ProductListView() {
    return ProductListView.__super__.constructor.apply(this, arguments);
  }

  ProductListView.prototype.template = '<ul class="productList"><ul>';

  ProductListView.prototype.childView = ProductItemView;

  ProductListView.prototype.childViewContainer = '.productList';

  return ProductListView;

})(Marionette.CompositeView);
