var ProductCollection, ProductModel, UserProductCollection, UserProductModel,
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

UserProductModel = (function(_super) {
  __extends(UserProductModel, _super);

  function UserProductModel() {
    return UserProductModel.__super__.constructor.apply(this, arguments);
  }

  UserProductModel.prototype.defaults = function() {};

  return UserProductModel;

})(Backbone.Model);

UserProductCollection = (function(_super) {
  __extends(UserProductCollection, _super);

  function UserProductCollection() {
    return UserProductCollection.__super__.constructor.apply(this, arguments);
  }

  UserProductCollection.prototype.model = UserProductModel;

  return UserProductCollection;

})(Backbone.Collection);

App.useProductColl = new UserProductCollection();
