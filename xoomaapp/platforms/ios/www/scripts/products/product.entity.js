var ProductCollection, ProductModel, UserProductCollection, UserProductModel,
  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  hasProp = {}.hasOwnProperty;

ProductModel = (function(superClass) {
  extend(ProductModel, superClass);

  function ProductModel() {
    return ProductModel.__super__.constructor.apply(this, arguments);
  }

  ProductModel.prototype.defaults = function() {};

  return ProductModel;

})(Backbone.Model);

ProductCollection = (function(superClass) {
  extend(ProductCollection, superClass);

  function ProductCollection() {
    return ProductCollection.__super__.constructor.apply(this, arguments);
  }

  ProductCollection.prototype.model = ProductModel;

  ProductCollection.prototype.url = function() {
    return APIURL + "/products";
  };

  return ProductCollection;

})(Backbone.Collection);

App.productCollection = new ProductCollection();

UserProductModel = (function(superClass) {
  extend(UserProductModel, superClass);

  function UserProductModel() {
    return UserProductModel.__super__.constructor.apply(this, arguments);
  }

  UserProductModel.prototype.defaults = function() {};

  return UserProductModel;

})(Backbone.Model);

UserProductCollection = (function(superClass) {
  extend(UserProductCollection, superClass);

  function UserProductCollection() {
    return UserProductCollection.__super__.constructor.apply(this, arguments);
  }

  UserProductCollection.prototype.model = UserProductModel;

  return UserProductCollection;

})(Backbone.Collection);

App.useProductColl = new UserProductCollection();