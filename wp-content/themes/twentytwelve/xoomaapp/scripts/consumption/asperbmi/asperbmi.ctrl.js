var AsperbmiView,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

App.state('Asperbmi', {
  url: '/products/:id/bmi',
  parent: 'xooma'
});

AsperbmiView = (function(_super) {
  __extends(AsperbmiView, _super);

  function AsperbmiView() {
    return AsperbmiView.__super__.constructor.apply(this, arguments);
  }

  AsperbmiView.prototype.template = '#asperbmi-template';

  return AsperbmiView;

})(Marionette.ItemView);

App.AsperbmiCtrl = (function(_super) {
  __extends(AsperbmiCtrl, _super);

  function AsperbmiCtrl() {
    return AsperbmiCtrl.__super__.constructor.apply(this, arguments);
  }

  AsperbmiCtrl.prototype.initialize = function(options) {
    var product, productId;
    if (options == null) {
      options = {};
    }
    productId = this.getParams();
    product = parseInt(productId[0]);
    return this._showView(product);
  };

  AsperbmiCtrl.prototype._showView = function(productModel) {
    console.log(productModel);
    return this.show(new AsperbmiView({
      model: productModel
    }));
  };

  return AsperbmiCtrl;

})(Ajency.RegionController);
