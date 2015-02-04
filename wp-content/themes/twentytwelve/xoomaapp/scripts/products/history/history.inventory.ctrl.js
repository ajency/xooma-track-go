// Generated by CoffeeScript 1.7.1
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

  InventoryChildView.prototype.className = '.class';

  InventoryChildView.prototype.template = '<input class="radio" id ="work{{id}}" name="works" type="radio" checked> <div class="relative"> <label class="labels" for="work{{id}}">{{product_type}}</label> <span class="date">{{date}}</span> <span class="circle"></span> </div> <div class="content"> <p> Stock updated(+) : <b>{{stock}}</b><br> Samples to customer(-) :<b>{{sales}}</b><br> Consumed(-) : <b>{{consumption}}</b><br> </p> </div>';

  return InventoryChildView;

})(Marionette.ItemView);

ViewInventoryView = (function(_super) {
  __extends(ViewInventoryView, _super);

  function ViewInventoryView() {
    return ViewInventoryView.__super__.constructor.apply(this, arguments);
  }

  ViewInventoryView.prototype["class"] = 'animated fadeIn';

  ViewInventoryView.prototype.template = '#view-inventory-template';

  ViewInventoryView.prototype.childView = InventoryChildView;

  ViewInventoryView.prototype.childViewContainer = 'ul.viewInventory';

  ViewInventoryView.prototype.onShow = function() {
    var ID, model;
    ID = Marionette.getOption(this, 'ID');
    model = App.useProductColl.findWhere({
      id: parseInt(ID)
    });
    return $('.product_name').text(model.get('name'));
  };

  return ViewInventoryView;

})(Marionette.CompositeView);

App.ViewInventoryCtrl = (function(_super) {
  __extends(ViewInventoryCtrl, _super);

  function ViewInventoryCtrl() {
    this.errorHandler = __bind(this.errorHandler, this);
    this.successHandler = __bind(this.successHandler, this);
    return ViewInventoryCtrl.__super__.constructor.apply(this, arguments);
  }

  ViewInventoryCtrl.prototype.initialize = function(options) {
    var productId, productModel, products;
    if (options == null) {
      options = {};
    }
    this.show(this.parent().getLLoadingView());
    productId = this.getParams();
    products = [];
    productModel = App.useProductColl.where({
      id: parseInt(productId[0])
    });
    return this._showView(productModel[0]);
  };

  ViewInventoryCtrl.prototype._showView = function(model) {
    var product;
    product = model.get('id');
    return $.ajax({
      method: 'GET',
      url: "" + _SITEURL + "/wp-json/inventory/" + (App.currentUser.get('ID')) + "/products/" + product,
      success: this.successHandler,
      error: this.errorHandler
    });
  };

  ViewInventoryCtrl.prototype.successHandler = function(response, status, xhr) {
    var coll;
    if (xhr.status === 200) {
      coll = new Backbone.Collection(response.response);
      return this.show(new ViewInventoryView({
        collection: coll,
        ID: response.ID
      }));
    } else {
      $('.aj-response-message').addClass('alert alert-danger').text("Details could not be loaded!");
      return $('html, body').animate({
        scrollTop: 0
      }, 'slow');
    }
  };

  ViewInventoryCtrl.prototype.errorHandler = function(response, status, xhr) {
    $('.aj-response-message').addClass('alert alert-danger').text("Details could not be loaded!");
    return $('html, body').animate({
      scrollTop: 0
    }, 'slow');
  };

  return ViewInventoryCtrl;

})(Ajency.RegionController);
