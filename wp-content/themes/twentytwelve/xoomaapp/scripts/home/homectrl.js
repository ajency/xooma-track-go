var HomeOtherProductsView, HomeViewChildView, HomeX2OView, HomeX2OViewChild, ProductChildView,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

App.HomeCtrl = (function(_super) {
  __extends(HomeCtrl, _super);

  function HomeCtrl() {
    return HomeCtrl.__super__.constructor.apply(this, arguments);
  }

  HomeCtrl.prototype.initialize = function() {
    return this.show(new Marionette.LayoutView({
      template: '#home-template'
    }));
  };

  return HomeCtrl;

})(Ajency.RegionController);

HomeX2OViewChild = (function(_super) {
  __extends(HomeX2OViewChild, _super);

  function HomeX2OViewChild() {
    return HomeX2OViewChild.__super__.constructor.apply(this, arguments);
  }

  HomeX2OViewChild.prototype.template = '<li class="col-md-4 col-xs-4"> <h5 class="text-center">Bonus</h5> <h4 class="text-center bold  text-primary" >{{bonus}}<small class="text-muted">({{name}})</small></h4> </li> <li class="col-md-4 col-xs-4"> <h5 class="text-center">Target</h5> <h4 class="text-center bold text-primary" >{{qty1}}<small class="text-muted">({{name}})</small></h4> </li> <li class="col-md-4 col-xs-4"> <h5 class="text-center">Last Consume</h5> <h4 class="text-center bold text-primary" >{{time}}</small></h4> </li>';

  HomeX2OViewChild.prototype.serializeData = function() {
    var data;
    data = HomeX2OViewChild.__super__.serializeData.call(this);
    $.each(this.model.get('occurrence'), function(ind, val) {
      var bonusArr, date, expected, occurrence, occurrenceArr, recent;
      occurrence = _.has(val, "occurrence");
      expected = _.has(val, "expected");
      recent = '--';
      data.time = recent;
      data.bonus = 0;
      occurrenceArr = [];
      bonusArr = 0;
      if (occurrence === true) {
        date = val.expected;
        occurrenceArr.push(date);
      }
      if (occurrence === true && expected === false) {
        bonusArr++;
      }
      if (occurrenceArr.length !== 0) {
        recent = _.last(occurrenceArr);
        data.time = moment(recent).format("ddd, hA");
      }
      return data.bonus = bonusArr;
    });
    return data;
  };

  return HomeX2OViewChild;

})(Marionette.ItemView);

HomeX2OView = (function(_super) {
  __extends(HomeX2OView, _super);

  function HomeX2OView() {
    return HomeX2OView.__super__.constructor.apply(this, arguments);
  }

  HomeX2OView.prototype.template = '<ul class="list-inline text-center row row-line x2oList"> </ul>';

  HomeX2OView.prototype.childView = HomeX2OViewChild;

  HomeX2OView.prototype.childViewContainer = 'ul.x2oList';

  return HomeX2OView;

})(Marionette.CompositeView);

App.HomeX2OCtrl = (function(_super) {
  __extends(HomeX2OCtrl, _super);

  function HomeX2OCtrl() {
    this._showView = __bind(this._showView, this);
    return HomeX2OCtrl.__super__.constructor.apply(this, arguments);
  }

  HomeX2OCtrl.prototype.initialize = function() {
    var x2oColl;
    if (App.currentUser.has('x2o')) {
      console.log(x2oColl = new Backbone.Collection(App.currentUser.get('x2o')));
      return this.show(new HomeX2OView({
        collection: x2oColl
      }));
    } else {
      return App.currentUser.getHomeProducts().done(this._showView).fail(this.errorHandler);
    }
  };

  HomeX2OCtrl.prototype._showView = function(collection) {
    var model, modelColl, productcollection;
    productcollection = new Backbone.Collection(collection);
    model = productcollection.shift();
    modelColl = new Backbone.Collection(model.get('products'));
    return this.show(new HomeX2OView({
      collection: modelColl
    }));
  };

  return HomeX2OCtrl;

})(Ajency.RegionController);

ProductChildView = (function(_super) {
  __extends(ProductChildView, _super);

  function ProductChildView() {
    return ProductChildView.__super__.constructor.apply(this, arguments);
  }

  ProductChildView.prototype.className = 'panel panel-default';

  ProductChildView.prototype.template = '<div class="panel-body"> <h5 class="bold margin-none mid-title ">{{name}}<i type="button" class="fa fa-ellipsis-v pull-right dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i> <ul class="dropdown-menu pull-right" role="menu"> <li><a href="#">View</a></li> <li><a href="#">Another action</a></li> <li><a href="#">Something else here</a></li> <li class="divider"></li> <li><a href="#">Delete</a></li> </ul> </h5> <ul class="list-inline text-center row dotted-line m-t-20 userProductList"> <li class="col-md-4  col-xs-4"> <a ><img src="assets/images/btn_03.png" width="100px"></a> <h6 class="text-center margin-none">Tap to consume</h6> </li> <li class="col-md-4  col-xs-4"> <h5 class="text-center">Daily Target</h5> <div class="row"> {{#qty}} <div class="col-md-6  col-xs-6"> <h4 class="text-center bold text-primary margin-none" >5 <sup class="text-muted">/ {{qty}}</sup></h4> <h6 >{{when}}</h6> </div> {{/qty}} </div> </li> <li class="col-md-4  col-xs-4"> <h5 class="text-center">Status</h5> <i class="fa fa-smile-o"></i> <h6 class="text-center margin-none">Complete the last one</h6> </li> </ul> </div> </br> ';

  ProductChildView.prototype.serializeData = function() {
    var data;
    data = ProductChildView.__super__.serializeData.call(this);
    $.each(this.model.get('occurrence'), function(ind, val) {
      var bonusArr, date, expected, occurrence, occurrenceArr, recent;
      occurrence = _.has(val, "occurrence");
      expected = _.has(val, "expected");
      recent = '--';
      data.occur = 0;
      data.time = recent;
      data.bonus = 0;
      occurrenceArr = [];
      bonusArr = 0;
      if (occurrence === true) {
        date = val.expected;
        occurrenceArr.push(date);
      }
      if (occurrence === true && expected === false) {
        bonusArr++;
      }
      if (occurrenceArr.length !== 0) {
        recent = _.last(occurrenceArr);
        data.time = moment(recent).format("ddd, hA");
        data.occur = occurrenceArr.length;
      }
      return data.bonus = bonusArr;
    });
    return data;
  };

  return ProductChildView;

})(Marionette.ItemView);

HomeViewChildView = (function(_super) {
  __extends(HomeViewChildView, _super);

  function HomeViewChildView() {
    return HomeViewChildView.__super__.constructor.apply(this, arguments);
  }

  HomeViewChildView.prototype.template = '<div></div>';

  HomeViewChildView.prototype.childView = ProductChildView;

  HomeViewChildView.prototype.initialize = function() {
    var products;
    products = this.model.get('products');
    return this.collection = new Backbone.Collection(products);
  };

  return HomeViewChildView;

})(Marionette.CompositeView);

HomeOtherProductsView = (function(_super) {
  __extends(HomeOtherProductsView, _super);

  function HomeOtherProductsView() {
    return HomeOtherProductsView.__super__.constructor.apply(this, arguments);
  }

  HomeOtherProductsView.prototype.template = '<span></span>';

  HomeOtherProductsView.prototype.childView = HomeViewChildView;

  return HomeOtherProductsView;

})(Marionette.CompositeView);

App.HomeOtherProductsCtrl = (function(_super) {
  __extends(HomeOtherProductsCtrl, _super);

  function HomeOtherProductsCtrl() {
    this._showView = __bind(this._showView, this);
    return HomeOtherProductsCtrl.__super__.constructor.apply(this, arguments);
  }

  HomeOtherProductsCtrl.prototype.initialize = function() {
    return App.currentUser.getHomeProducts().done(this._showView).fail(this.errorHandler);
  };

  HomeOtherProductsCtrl.prototype._showView = function(collection) {
    var productcollection;
    productcollection = new Backbone.Collection(collection);
    productcollection.shift();
    return this.show(new HomeOtherProductsView({
      collection: productcollection
    }));
  };

  return HomeOtherProductsCtrl;

})(Ajency.RegionController);
