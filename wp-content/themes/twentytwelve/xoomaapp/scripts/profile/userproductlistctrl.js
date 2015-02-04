// Generated by CoffeeScript 1.7.1
var EmptyView, ProductChildView, UserProductListView,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

ProductChildView = (function(_super) {
  __extends(ProductChildView, _super);

  function ProductChildView() {
    this.erroraHandler = __bind(this.erroraHandler, this);
    this.successHandler = __bind(this.successHandler, this);
    return ProductChildView.__super__.constructor.apply(this, arguments);
  }

  ProductChildView.prototype.tagName = 'div';

  ProductChildView.prototype.className = 'panel panel-default';

  ProductChildView.prototype.ui = {
    avail: '.avail',
    add: '.add',
    update: '.update',
    remove: '.remove',
    responseMessage: '.aj-response-message'
  };

  ProductChildView.prototype.initialize = function() {
    return this.$el.prop("id", 'cart' + this.model.get("id"));
  };

  ProductChildView.prototype.template = '<div class="panel-body "> <h5 class="margin-none mid-title "> {{name}} <i type="button" class="fa fa-ellipsis-v pull-right dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i> <ul class="dropdown-menu pull-right" role="menu"> <li class="add hidden"><a href="#/product/{{id}}/edit">Edit product</a></li> <li class="update hidden"><a href="#/inventory/{{id}}/edit">Inventory</a></li> <li class="update hidden"><a href="#/inventory/{{id}}/view">Inventory history</a></li> <li class="divider"></li> <li><a href="#" class="remove hidden">Remove the product</a></li> </ul> </h5> <ul class="list-inline   m-t-20"> <li class="col-md-7 col-xs-7 dotted-line"> <ul class="list-inline no-dotted "> {{#servings}} <li> <h3 class="bold margin-none"><div class="cap {{classname}}"></div>{{qty}}</h3> </li> {{/servings}} </ul> </li> <li class="col-md-1 col-xs-1"> <h4>    <i class="fa fa-random text-muted m-t-20"></i></h4> </li> <li class="col-md-4  col-xs-4 text-center"> <span clas="servings_text">{{servings_text}}</span> <i class="fa fa-frown-o {{frown}}"></i> <h2 class="margin-none bold {{newClass}} {{hidden}} avail">{{servingsleft}}</h2> <span class="{{hidden}}">{{containers}} container(s) ({{available}} {{product_type}}(s))</span> </li> </ul> </div> <div class="panel-footer"> <i id="bell{{id}}" class="fa fa-bell-slash no-remiander"></i> {{reminder}} </div>';

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
    var listview, products, region;
    if (xhr.status === 200) {
      products = App.currentUser.get('products');
      products = _.without(products, parseInt(response));
      App.currentUser.set('products', products);
      App.useProductColl.remove(parseInt(response));
      listview = new UserProductListView({
        collection: App.useProductColl
      });
      region = new Marionette.Region({
        el: '#xoomaproduct'
      });
      region.show(listview);
      if (parseInt(App.useProductColl.length) === 0) {
        $('.add1').hide();
        return $('.save_products').hide();
      }
    } else {
      this.ui.responseMessage.addClass('alert alert-danger').text("Sorry!Couldn't delete the product.");
      return $('html, body').animate({
        scrollTop: 0
      }, 'slow');
    }
  };

  ProductChildView.prototype.erroraHandler = function(response, status, xhr) {
    this.ui.responseMessage.addClass('alert alert-danger').text("Sorry!Couldn't delete the product.");
    return $('html, body').animate({
      scrollTop: 0
    }, 'slow');
  };

  ProductChildView.prototype.onShow = function() {
    var product, products, reminder;
    App.trigger('cordova:hide:splash:screen');
    reminder = this.model.get('reminder');
    if (reminder.length !== 0) {
      $('#bell' + this.model.get('id')).removeClass('fa-bell-slash no-remiander');
      $('#bell' + this.model.get('id')).addClass('fa-bell-o element-animation');
    }
    product = parseInt(this.model.get('id'));
    products = App.currentUser.get('products');
    if (parseInt($.inArray(product, products)) > -1) {
      this.ui.avail.removeClass('hidden');
      this.ui.add.removeClass('hidden');
      this.ui.update.removeClass('hidden');
      return this.ui.remove.removeClass('hidden');
    }
  };

  ProductChildView.prototype.serializeData = function() {
    var available, contacount, containers, data, name, product_type, qty, remind, reminder, reminderArr, servings, servingsleft, settings, timezone, total, totalservings, type;
    data = ProductChildView.__super__.serializeData.call(this);
    qty = this.model.get('qty');
    product_type = this.model.get('product_type');
    product_type = product_type.toLowerCase();
    settings = parseInt(this.model.get('settings')) * parseInt(qty.length);
    reminder = this.model.get('reminder');
    type = this.model.get('type');
    name = this.model.get('name');
    timezone = this.model.get('timezone');
    servings = [];
    reminderArr = [];
    $.each(qty, function(index, value) {
      var newClass, servingsqty;
      servingsqty = [];
      newClass = product_type + '_default_class';
      if (name.toUpperCase() === 'X2O') {
        newClass = 'x2o_default_class';
      }
      return servings.push({
        classname: newClass,
        qty: value.qty
      });
    });
    $.each(reminder, function(ind, val) {
      var time;
      time = moment(val.time + timezone, "HH:mm Z").format("h:ss A");
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

EmptyView = (function(_super) {
  __extends(EmptyView, _super);

  function EmptyView() {
    return EmptyView.__super__.constructor.apply(this, arguments);
  }

  EmptyView.prototype.template = '<div class="alert alert-danger">Go ahead and add your first product rigt away!</div>';

  return EmptyView;

})(Marionette.ItemView);

UserProductListView = (function(_super) {
  __extends(UserProductListView, _super);

  function UserProductListView() {
    this._errorHandler = __bind(this._errorHandler, this);
    this._successHandler = __bind(this._successHandler, this);
    return UserProductListView.__super__.constructor.apply(this, arguments);
  }

  UserProductListView.prototype["class"] = 'animated fadeIn';

  UserProductListView.prototype.template = '#produts-template';

  UserProductListView.prototype.childView = ProductChildView;

  UserProductListView.prototype.emptyView = EmptyView;

  UserProductListView.prototype.childViewContainer = '.userproducts';

  UserProductListView.prototype.ui = {
    saveProducts: '.save_products',
    responseMessage: '.aj-response-message',
    add1: '.add1'
  };

  UserProductListView.prototype.events = {
    'click @ui.saveProducts': function(e) {
      return $.ajax({
        method: 'POST',
        url: "" + APIURL + "/records/" + (App.currentUser.get('ID')),
        success: this._successHandler,
        error: this._errorHandler
      });
    }
  };

  UserProductListView.prototype.onRender = function() {
    if (App.currentUser.get('state') === '/home') {
      this.ui.saveProducts.hide();
      $('#product').parent().removeClass('done');
      $('#product').parent().addClass('selected');
      $('#product').parent().siblings().removeClass('selected');
      $('#product').parent().prevAll().addClass('done');
    }
    if (parseInt(App.useProductColl.length) === 0 || parseInt(App.useProductColl.length) < 10) {
      return this.ui.add1.hide();
    }
  };

  UserProductListView.prototype._successHandler = function(response, status, xhr) {
    var listview, region;
    console.log(xhr.status);
    if (xhr.status === 201) {
      App.currentUser.set('state', '/home');
      App.navigate('#/home', true);
      listview = new XoomaAppRootView;
      region = new Marionette.Region({
        el: '#xoomaapptemplate'
      });
      return region.show(listview);
    } else {
      this.ui.responseMessage.addClass('alert alert-danger').text("Sorry!Some error occurred.");
      return $('html, body').animate({
        scrollTop: 0
      }, 'slow');
    }
  };

  UserProductListView.prototype._errorHandler = function(response, status, xhr) {
    this.ui.responseMessage.addClass('alert alert-danger').text("Sorry!Some error occurred.");
    return $('html, body').animate({
      scrollTop: 0
    }, 'slow');
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
    this.show(this.parent().parent().getLLoadingView());
    if (App.useProductColl.length === 0) {
      return App.currentUser.getUserProducts().done(this._showView).fail(this.errorHandler);
    } else {
      return this.show(new UserProductListView({
        collection: App.useProductColl
      }));
    }
  };

  UserProductListCtrl.prototype._showView = function(collection) {
    var productcollection;
    collection = collection.response;
    productcollection = new Backbone.Collection(collection);
    return this.show(new UserProductListView({
      collection: productcollection
    }));
  };

  return UserProductListCtrl;

})(Ajency.RegionController);
