// Generated by CoffeeScript 1.7.1
var ProductCollection, ProductModel,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

ProductModel = (function(_super) {
  __extends(ProductModel, _super);

  function ProductModel() {
    return ProductModel.__super__.constructor.apply(this, arguments);
  }

  ProductModel.prototype.defaults = function() {};

  return ProductModel;

})(Backbone.Model);

ProductCollection = (function(_super) {
  __extends(ProductCollection, _super);

  function ProductCollection() {
    return ProductCollection.__super__.constructor.apply(this, arguments);
  }

  ProductCollection.prototype.model = ProductModel;

  ProductCollection.prototype.url = function() {
    return "" + APIURL + "/products";
  };

  return ProductCollection;

})(Backbone.Collection);

App.productCollection = new ProductCollection();