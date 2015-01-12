var EditInventoryView,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

App.state('EditInventory', {
  url: '/inventory/:id/edit',
  parent: 'xooma'
});

EditInventoryView = (function(_super) {
  __extends(EditInventoryView, _super);

  function EditInventoryView() {
    this.successSave = __bind(this.successSave, this);
    return EditInventoryView.__super__.constructor.apply(this, arguments);
  }

  EditInventoryView.prototype["class"] = 'animated fadeIn';

  EditInventoryView.prototype.template = '#update-inventory-template';

  EditInventoryView.prototype.ui = {
    containers: '#containers',
    save: '.save',
    subtract: 'input[name="subtract"]',
    responseMessage: '.aj-response-message',
    form: '#inventory',
    view: '.view',
    container_label: '#container_label'
  };

  EditInventoryView.prototype.events = {
    'change @ui.containers': function(e) {
      var available, contacount, containers, count, total;
      available = this.model.get('available');
      total = this.model.get('total');
      containers = parseInt(available) / parseInt(total);
      console.log(contacount = Math.ceil(containers));
      console.log(count = parseInt($(e.target).val()) + parseInt(contacount));
      return this.ui.container_label.text(count);
    },
    'keypress @ui.subtract': function(e) {
      return e.charCode >= 48 && e.charCode <= 57 || e.charCode === 44;
    },
    'click @ui.save': function(e) {
      var data, product, sub;
      e.preventDefault();
      sub = this.ui.subtract.val();
      if (sub === "") {
        sub = 0;
        this.ui.subtract.val(0);
      }
      if (parseInt(this.model.get('available')) > parseInt(sub)) {
        data = this.ui.form.serialize();
        product = this.model.get('id');
        return $.ajax({
          method: 'POST',
          url: "" + _SITEURL + "/wp-json/inventory/" + (App.currentUser.get('ID')) + "/products/" + product,
          data: data,
          success: this.successSave,
          error: this.errorSave
        });
      } else {
        return this.errorMsg();
      }
    },
    'click @ui.view': function(e) {
      var product;
      e.preventDefault();
      product = this.model.get('id');
      return $.ajax({
        method: 'GET',
        url: "" + _SITEURL + "/wp-json/inventory/" + (App.currentUser.get('ID')) + "/products/" + product,
        success: this.successHandler,
        error: this.errorHandler
      });
    }
  };

  EditInventoryView.prototype.onShow = function() {
    var available, contacount, containers, total;
    available = this.model.get('available');
    total = this.model.get('total');
    containers = parseInt(available) / parseInt(total);
    console.log(contacount = Math.ceil(containers));
    return this.ui.container_label.text(contacount);
  };

  EditInventoryView.prototype.successSave = function(response, status, xhr) {
    if (xhr.status === 201) {
      return App.navigate('#/profile/my-products', true);
    } else {
      return this.errorMsg();
    }
  };

  EditInventoryView.prototype.errorMsg = function() {
    this.ui.responseMessage.text("Value entered shoule be less than available count");
    return $('html, body').animate({
      scrollTop: 0
    }, 'slow');
  };

  return EditInventoryView;

})(Marionette.ItemView);

App.EditInventoryCtrl = (function(_super) {
  __extends(EditInventoryCtrl, _super);

  function EditInventoryCtrl() {
    return EditInventoryCtrl.__super__.constructor.apply(this, arguments);
  }

  EditInventoryCtrl.prototype.initialize = function(options) {
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
    return this.show(new EditInventoryView({
      model: productModel[0]
    }));
  };

  return EditInventoryCtrl;

})(Ajency.RegionController);
