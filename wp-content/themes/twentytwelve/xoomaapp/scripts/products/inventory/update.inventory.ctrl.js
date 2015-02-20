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
    this.errorSave = __bind(this.errorSave, this);
    this.successSave = __bind(this.successSave, this);
    this.valueOutput = __bind(this.valueOutput, this);
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
    container_label: '#container_label',
    newsum: '.newsum',
    ntotal: '.ntotal',
    ncon: '.ncon',
    nequalto: '.nequalto',
    rangeSliders: '[data-rangeslider]',
    navail: '.navail',
    nadd: '.nadd',
    nsub: '.nsub',
    finaladd: '.finaladd',
    eqa: '.eqa',
    entry: '.entry',
    record: 'input[name="record"]'
  };

  EditInventoryView.prototype.events = {
    'click @ui.entry': function(e) {
      this.ui.entry.removeClass('btn-primary');
      $(e.target).removeClass('btn-default');
      $(e.target).addClass('btn-primary');
      $('#subtract').val($(e.target).val());
      this.ui.rangeSliders.val(0);
      this.ui.rangeSliders.parent().find("output").html(0);
      this.ui.save.hide();
      if ($(e.target).val() === 'adjust') {
        $('.record_new').hide();
        $('.record').hide();
        this.adjustValue();
        this.ui.containers.val();
        $('#slider').removeAttr('disabled');
        return $('.rangeslider').removeClass('rangeslider--disabled');
      } else {
        $('.record_new').show();
        $('.record').show();
        this.ui.containers.val(0);
        return $(this.ui.containers).trigger("change");
      }
    },
    'change @ui.rangeSliders': function(e) {
      this.valueOutput(e.currentTarget);
      if ($('#subtract').val() === 'adjust') {
        return this.adjustValue();
      } else {
        return $(this.ui.containers).trigger("change");
      }
    },
    'change @ui.containers': function(e) {
      var available, contacount, containers, count, eqt, equalto, total;
      if (parseInt($(e.target).val()) !== 0) {
        $('#slider').removeAttr('disabled');
        $('.rangeslider').removeClass('rangeslider--disabled');
        this.ui.save.show();
      } else {
        this.ui.rangeSliders.val(0);
        this.ui.rangeSliders.parent().find("output").html($(e.target).val());
        $('#slider').attr('disabled', true);
        $('.rangeslider').addClass('rangeslider--disabled');
        this.ui.save.hide();
      }
      available = this.model.get('available');
      total = this.model.get('total');
      this.ui.ntotal.text(total);
      containers = parseInt(available) / parseInt(total);
      contacount = Math.ceil(containers);
      count = parseInt($(e.target).val()) + parseInt(contacount);
      this.ui.ncon.text($(e.target).val());
      equalto = parseInt($(e.target).val()) * parseInt(total);
      this.ui.nequalto.text(equalto);
      this.ui.navail.text(available);
      this.ui.nadd.text(equalto);
      if (this.ui.rangeSliders.val() < 0) {
        $('.sign').text(' - ');
        eqt = parseInt(available) + parseInt(equalto) - parseInt(Math.abs(this.ui.rangeSliders.val()));
      } else {
        $('.sign').text(' + ');
        eqt = parseInt(available) + parseInt(equalto) + parseInt(Math.abs(this.ui.rangeSliders.val()));
      }
      this.ui.nsub.text(Math.abs(this.ui.rangeSliders.val()));
      this.ui.eqa.text(eqt);
      this.ui.newsum.show();
      return this.ui.finaladd.show();
    },
    'keypress @ui.subtract': function(e) {
      return e.charCode >= 48 && e.charCode <= 57 || e.charCode === 44;
    },
    'click @ui.save': function(e) {
      var data, product;
      e.preventDefault();
      data = this.ui.form.serialize();
      product = this.model.get('id');
      return $.ajax({
        method: 'POST',
        url: "" + _SITEURL + "/wp-json/inventory/" + (App.currentUser.get('ID')) + "/products/" + product,
        data: data,
        success: this.successSave,
        error: this.errorSave
      });
    }
  };

  EditInventoryView.prototype.serializeData = function() {
    var data;
    data = EditInventoryView.__super__.serializeData.call(this);
    data.producttype = this.model.get('product_type');
    data.product_type = this.model.get('product_type').toLowerCase();
    return data;
  };

  EditInventoryView.prototype.adjustValue = function() {
    var available, eqt, total;
    available = this.model.get('available');
    total = this.model.get('total');
    this.ui.navail.text(available);
    if (parseInt(this.ui.rangeSliders.val()) === 0) {
      $('.sign').text(' - ');
      this.ui.save.hide();
      eqt = parseInt(available) - parseInt(Math.abs(this.ui.rangeSliders.val()));
    }
    if (this.ui.rangeSliders.val() < 0) {
      $('.sign').text(' - ');
      eqt = parseInt(available) - parseInt(Math.abs(this.ui.rangeSliders.val()));
      this.ui.save.show();
    } else if (this.ui.rangeSliders.val() > 0) {
      $('.sign').text(' + ');
      eqt = parseInt(available) + parseInt(Math.abs(this.ui.rangeSliders.val()));
      this.ui.save.show();
    }
    this.ui.nsub.text(Math.abs(this.ui.rangeSliders.val()));
    this.ui.eqa.text(eqt);
    return this.ui.finaladd.show();
  };

  EditInventoryView.prototype.valueOutput = function(element) {
    return $(element).parent().find("output").html($(element).val());
  };

  EditInventoryView.prototype.onShow = function() {
    var available, contacount, containers, total;
    this.ui.save.hide();
    $('#subtract').val('record');
    $('#record').addClass('btn-primary');
    this.ui.rangeSliders.each((function(_this) {
      return function(index, ele) {
        return _this.valueOutput(ele);
      };
    })(this));
    this.ui.rangeSliders.rangeslider({
      polyfill: false
    });
    this.ui.newsum.hide();
    this.ui.finaladd.hide();
    available = this.model.get('available');
    total = this.model.get('total');
    containers = parseInt(available) / parseInt(total);
    contacount = Math.ceil(containers);
    return this.ui.container_label.text(contacount);
  };

  EditInventoryView.prototype.successSave = function(response, status, xhr) {
    var model;
    if (xhr.status === 201) {
      model = new UserProductModel;
      model.set(response[0]);
      App.useProductColl.add(model, {
        merge: true
      });
      return App.navigate("#/profile/my-products", true);
    } else {
      return this.errorMsg();
    }
  };

  EditInventoryView.prototype.errorSave = function(response, status, xhr) {
    return this.errorMsg();
  };

  EditInventoryView.prototype.errorMsg = function() {
    window.removeMsg();
    this.ui.responseMessage.addClass('alert alert-danger').text("Inventory couldn't be updated!");
    return $('html, body').animate({
      scrollTop: 0
    }, 'slow');
  };

  return EditInventoryView;

})(Marionette.ItemView);

App.EditInventoryCtrl = (function(_super) {
  __extends(EditInventoryCtrl, _super);

  function EditInventoryCtrl() {
    this._showView = __bind(this._showView, this);
    return EditInventoryCtrl.__super__.constructor.apply(this, arguments);
  }

  EditInventoryCtrl.prototype.initialize = function(options) {
    var product, productId, productModel, products;
    if (options == null) {
      options = {};
    }
    this.show(this.parent().getLLoadingView());
    productId = this.getParams();
    products = [];
    console.log(productModel = App.useProductColl.where({
      id: parseInt(productId[0])
    }));
    product = productId[0];
    if (productModel === void 0 || productModel.length === 0) {
      return App.currentUser.getUserProducts().done(this._showView).fail(this.errorHandler);
    } else {
      return this.show(new EditInventoryView({
        model: productModel[0]
      }));
    }
  };

  EditInventoryCtrl.prototype._showView = function(collection) {
    var productId, productModel;
    productId = this.getParams();
    productModel = App.useProductColl.where({
      id: parseInt(productId[0])
    });
    return this.show(new EditInventoryView({
      model: productModel[0]
    }));
  };

  return EditInventoryCtrl;

})(Ajency.RegionController);
