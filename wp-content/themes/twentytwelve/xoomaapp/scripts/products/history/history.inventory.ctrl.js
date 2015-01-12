var InventoryChildView, ViewInventoryView,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

App.state('ViewInventory', {
  url: '/inventory/:id/view',
  parent: 'xooma'
});

InventoryChildView = (function(_super) {
  __extends(InventoryChildView, _super);

  function InventoryChildView() {
    return InventoryChildView.__super__.constructor.apply(this, arguments);
  }

  InventoryChildView.prototype.tagName = 'li';

  InventoryChildView.prototype.template = '<div><span>{{date}}</span></div><div><span>{{type}}</span></div><br/> <div><span>Stock updated(+):</span>{{stock}}</div><br/> <div><span>Samples to customer(-):</span>{{sales}}</div><br/> <div><span>Consumed(-) :</span>{{consumption}}</div><br/>';

  return InventoryChildView;

})(Marionette.CompositeView);

ViewInventoryView = (function(_super) {
  __extends(ViewInventoryView, _super);

  function ViewInventoryView() {
    return ViewInventoryView.__super__.constructor.apply(this, arguments);
  }

  ViewInventoryView.prototype["class"] = 'animated fadeIn';

  ViewInventoryView.prototype.template = '#view-inventory-template';

  ViewInventoryView.prototype.childView = InventoryChildView;

  ViewInventoryView.prototype.childViewContainer = 'ul.viewInventory';

  return ViewInventoryView;

})(Marionette.CompositeView);

App.ViewInventoryCtrl = (function(_super) {
  __extends(ViewInventoryCtrl, _super);

  function ViewInventoryCtrl() {
    this.successHandler = __bind(this.successHandler, this);
    return ViewInventoryCtrl.__super__.constructor.apply(this, arguments);
  }

  ViewInventoryCtrl.prototype.initialize = function(options) {
    var productId, productModel, products, productsColl;
    if (options == null) {
      options = {};
    }
    productId = this.getParams();
    products = [];
    App.UserProductsColl.each(function(val) {
      return $.each(val.get('products'), function(index, value) {
        return products.push(value);
      });
    });
    productsColl = new Backbone.Collection(products);
    productModel = productsColl.where({
      id: parseInt(productId[0])
    });
    return this._showView(productModel[0]);
  };

  ViewInventoryCtrl.prototype._showView = function(model) {
    var product;
    console.log(product = model.get('id'));
    return $.ajax({
      method: 'GET',
      url: "" + _SITEURL + "/wp-json/inventory/" + (App.currentUser.get('ID')) + "/products/" + product,
      success: this.successHandler,
      error: this.errorHandler
    });
  };

  ViewInventoryCtrl.prototype.successHandler = function(response, status, xhr) {
    var coll;
    coll = new Backbone.Collection(response);
    return this.show(new ViewInventoryView({
      collection: coll
    }));
  };

  return ViewInventoryCtrl;

})(Ajency.RegionController);
