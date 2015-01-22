var ProductChildView, UserProductListView,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

ProductChildView = (function(_super) {
  __extends(ProductChildView, _super);

  function ProductChildView() {
    this.successHandler = __bind(this.successHandler, this);
    return ProductChildView.__super__.constructor.apply(this, arguments);
  }

  ProductChildView.prototype.tagName = 'div';

  ProductChildView.prototype.className = 'panel panel-default';

  ProductChildView.prototype.ui = {
    avail: '.avail',
    add: '.add',
    update: '.update',
    remove: '.remove'
  };

  ProductChildView.prototype.events = {
    'click .remove': function(e) {
      var product, products;
      e.preventDefault();
      product = parseInt(this.model.get('id'));
      products = App.currentUser.get('products');
      return $.ajax({
        method: 'DELETE',
        url: "" + _SITEURL + "/wp-json/trackers/" + (App.currentUser.get('ID')) + "/products/" + product,
        success: this.successHandler,
        error: this.erroraHandler
      });
    }
  };

  ProductChildView.prototype.successHandler = function(response, status, xhr) {
    var products;
    products = App.currentUser.get('products');
    products = _.without(products, parseInt(response));
    App.currentUser.set('products', products);
    console.log(App.useProductColl.remove(parseInt(response)));
    return console.log(App.useProductColl);
  };

  ProductChildView.prototype.template = '<div class="panel-body "> <h5 class="bold margin-none mid-title "> {{name}} <i type="button" class="fa fa-ellipsis-v pull-right dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i> <ul class="dropdown-menu pull-right" role="menu"> <li class="add hidden"><a href="#/products/{{id}}/edit">Edit product</a></li> <li class="update hidden"><a href="#/inventory/{{id}}/edit">Inventory</a></li> <li class="update hidden"><a href="#/inventory/{{id}}/view">View History</a></li> <li class="divider"></li> <li><a href="#" class="remove hidden">Remove the product</a></li> </ul> </h5> <ul class="list-inline   m-t-20"> <li class="col-md-7 col-xs-7"> <div class="row"> {{#servings}} <div class="col-md-6 text-left"> {{#serving}} <div class="{{classname}}"></div> {{/serving}} </div> {{/servings}} </div> </li> <li class="col-md-1 col-xs-1"> <h4>    <i class="fa fa-random text-muted m-t-20"></i></h4> </li> <li class="col-md-4  col-xs-4 text-center"> <span clas="servings_text">{{servings_text}}</span> <i class="fa fa-frown-o {{frown}}"></i> <h2 class="margin-none bold {{newClass}} {{hidden}} avail">{{servingsleft}}</h2> <span class="{{hidden}}">{{containers}} container(s) ({{available}} {{product_type}}(s))</span> </li> </ul> </div> <div class="panel-footer"> <i id="bell" class="fa fa-bell-slash no-remiander"></i> {{reminder}} </div>';

  ProductChildView.prototype.onShow = function() {
    var product, products;
    product = parseInt(this.model.get('id'));
    products = App.currentUser.get('products');
    if ($.inArray(product, products) > -1) {
      this.ui.avail.removeClass('hidden');
      this.ui.add.removeClass('hidden');
      this.ui.update.removeClass('hidden');
      return this.ui.remove.removeClass('hidden');
    }
  };

  ProductChildView.prototype.serializeData = function() {
    var available, contacount, containers, data, product_type, qty, remind, reminder, reminderArr, servings, servingsleft, settings, timezone, total, totalservings, type;
    data = ProductChildView.__super__.serializeData.call(this);
    qty = this.model.get('qty');
    product_type = this.model.get('product_type');
    product_type = product_type.toLowerCase();
    settings = parseInt(this.model.get('settings')) * parseInt(qty.length);
    reminder = this.model.get('reminder');
    type = this.model.get('type');
    timezone = this.model.get('timezone');
    servings = [];
    reminderArr = [];
    $.each(qty, function(index, value) {
      var i, newClass, servingsqty;
      i = 0;
      servingsqty = [];
      while (i < value.qty) {
        newClass = product_type + '_default_class';
        if (type === 'asperbmi') {
          newClass = 'x2o_default_class';
        }
        servingsqty.push({
          classname: newClass
        });
        i++;
      }
      return servings.push({
        serving: servingsqty
      });
    });
    $.each(reminder, function(ind, val) {
      var time;
      time = moment(val.time + timezone, "HH:mm Z").format("hA");
      return reminderArr.push(time);
    });
    remind = reminderArr.join(',');
    if (parseInt(reminder.length) === 0) {
      remind = 'No Reminder is set';
    }
    available = this.model.get('available');
    total = this.model.get('total');
    containers = parseInt(available) / parseInt(total);
    contacount = Math.ceil(containers);
    servingsleft = parseInt(available) / parseInt(qty.length);
    totalservings = parseInt(servingsleft) / 2;
    data.servings_text = 'Servings left';
    data.hidden = '';
    data.frown = 'hidden';
    if (parseInt(servingsleft) <= parseInt(settings) && parseInt(servingsleft) !== 0) {
      data.newClass = 'text-danger';
    } else if (parseInt(servingsleft) === 0) {
      data.newClass = 'text-muted';
      data.servings_text = 'Serivngs out of stock';
      data.hidden = 'hidden';
      data.frown = '';
    } else if (parseInt(servingsleft) <= parseInt(totalservings) && parseInt(servingsleft) !== 0) {
      data.newClass = 'text-warning';
    } else if (parseInt(servingsleft) >= parseInt(totalservings) && parseInt(servingsleft) !== 0) {
      data.newClass = 'text-success';
    }
    data.servings = servings;
    data.reminder = remind;
    data.containers = contacount;
    data.servingsleft = parseInt(servingsleft);
    return data;
  };

  return ProductChildView;

})(Marionette.ItemView);

UserProductListView = (function(_super) {
  __extends(UserProductListView, _super);

  function UserProductListView() {
    this._successHandler = __bind(this._successHandler, this);
    return UserProductListView.__super__.constructor.apply(this, arguments);
  }

  UserProductListView.prototype["class"] = 'animated fadeIn';

  UserProductListView.prototype.template = '#produts-template';

  UserProductListView.prototype.childView = ProductChildView;

  UserProductListView.prototype.childViewContainer = '.userproducts';

  UserProductListView.prototype.ui = {
    saveProducts: '.save_products',
    responseMessage: '.aj-response-message'
  };

  UserProductListView.prototype.events = {
    'click @ui.saveProducts': function(e) {
      return $.ajax({
        method: 'POST',
        url: "" + APIURL + "/records/" + (App.currentUser.get('ID')),
        success: this._successHandler
      });
    },
    'click .add': function(e) {
      console.log("aaaaaaaaaa");
      return App.navigate('#/products', true);
    }
  };

  UserProductListView.prototype.onShow = function() {
    if (App.currentUser.get('state') === '/home') {
      return this.ui.saveProducts.hide();
    }
  };

  UserProductListView.prototype._successHandler = function(response, status, xhr) {
    if (xhr.status === 201) {
      console.log(response);
      return App.navigate('#/home', true);
    } else {
      return this.ui.responseMessage.text("Something went wrong");
    }
  };

  return UserProductListView;

})(Marionette.CompositeView);

App.UserProductListCtrl = (function(_super) {
  __extends(UserProductListCtrl, _super);

  function UserProductListCtrl() {
    this._showView = __bind(this._showView, this);
    return UserProductListCtrl.__super__.constructor.apply(this, arguments);
  }

  UserProductListCtrl.prototype.initialize = function() {
    return App.currentUser.getUserProducts().done(this._showView).fail(this.errorHandler);
  };

  UserProductListCtrl.prototype._showView = function(collection) {
    var productcollection;
    collection = collection.response;
    console.log(App.UserProductsColl = new Backbone.Collection(collection));
    productcollection = new Backbone.Collection(collection);
    return this.show(new UserProductListView({
      collection: productcollection
    }));
  };

  return UserProductListCtrl;

})(Ajency.RegionController);
