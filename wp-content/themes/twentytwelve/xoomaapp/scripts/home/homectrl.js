// Generated by CoffeeScript 1.7.1
var HomeOtherProductsView, HomeViewChildView, HomeX2OView, HomeX2OViewChild, ProductChildView,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

App.HomeCtrl = (function(_super) {
  __extends(HomeCtrl, _super);

  function HomeCtrl() {
    this._showView = __bind(this._showView, this);
    return HomeCtrl.__super__.constructor.apply(this, arguments);
  }

  HomeCtrl.prototype.initialize = function() {
    return App.currentUser.getHomeProducts().done(this._showView).fail(this.errorHandler);
  };

  HomeCtrl.prototype._showView = function(collection) {
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

  HomeX2OViewChild.prototype.template = '<a href="#/products/{{id}}/bmi" ><li class="col-md-4 col-xs-4"> <h5 class="text-center">Bonus</h5> <h4 class="text-center bold  text-primary" >{{bonus}}</h4> </li> <li class="col-md-4 col-xs-4"> <h5 class="text-center">Daily Target</h5> <h4 class="text-center bold text-primary margin-none" >{{remianing}}<sup class="text-muted">/ {{qty1}}</sup></h4> </li> <li class="col-md-4 col-xs-4"> <h5 class="text-center">Last Consume</h5> <h4 class="text-center bold text-primary" >{{time}}</small></h4> </li></a>';

  HomeX2OViewChild.prototype.serializeData = function() {
    var bonusArr, data, occurrenceArr, recent;
    data = HomeX2OViewChild.__super__.serializeData.call(this);
    occurrenceArr = [];
    bonusArr = 0;
    recent = '--';
    data.time = recent;
    data.bonus = 0;
    $.each(this.model.get('occurrence'), function(ind, val) {
      var date, expected, occurrence;
      occurrence = _.has(val, "occurrence");
      expected = _.has(val, "expected");
      if (occurrence === true) {
        date = val.occurrence;
        occurrenceArr.push(date);
      }
      if (occurrence === true && expected === false) {
        bonusArr++;
      }
      if (occurrenceArr.length !== 0) {
        recent = _.last(occurrenceArr);
        data.time = moment(recent).format("ddd, hA");
      }
      data.bonus = bonusArr;
      return data.occurr = occurrenceArr.length;
    });
    data.remianing = parseInt(this.model.get('qty1')) - parseInt(occurrenceArr.length);
    return data;
  };

  HomeX2OViewChild.prototype.onShow = function() {
    var bonusArr, consumed, ctx, doughnutData, occurrenceArr, target;
    occurrenceArr = [];
    bonusArr = 0;
    $.each(this.model.get('occurrence'), function(ind, val) {
      var date, expected, occurrence;
      occurrence = _.has(val, "occurrence");
      expected = _.has(val, "expected");
      if (occurrence === true) {
        date = val.occurrence;
        occurrenceArr.push(date);
      }
      if (occurrence === true && expected === false) {
        return bonusArr++;
      }
    });
    consumed = occurrenceArr.length;
    target = this.model.get('qty1');
    doughnutData = this.drawBottle(this.model.get('occurrence'));
    ctx = document.getElementById("chart-area").getContext("2d");
    return window.myDoughnut = new Chart(ctx).Doughnut(doughnutData, {
      responsive: true,
      percentageInnerCutout: 80
    });
  };

  HomeX2OViewChild.prototype.get_occurrence = function(data) {
    var arr, expected, meta_value, occurrence, value;
    console.log(data);
    console.log(occurrence = _.has(data, "occurrence"));
    console.log(expected = _.has(data, "expected"));
    console.log(meta_value = _.has(data, "meta_value"));
    value = 0;
    arr = [];
    $.each(meta_value, function(index, value) {
      return value += parseInt(value.qty);
    });
    if (occurrence === true && expected === true) {
      arr['color'] = "#6bbfff";
      arr['highlight'] = "#50abf1";
      arr['value'] = value;
    } else if (occurrence === false && expected === true) {
      arr['color'] = "#e3e3e3";
      arr['highlight'] = "#cdcdcd";
      arr['value'] = value;
    } else if (occurrence === true && expected === false) {
      arr['color'] = "#e3e3e3";
      arr['highlight'] = "#cdcdcd";
      arr['value'] = value;
    }
    return arr;
  };

  HomeX2OViewChild.prototype.drawBottle = function(data) {
    var doughnutData;
    doughnutData = [];
    $.each(data, function(ind, val) {
      var i, occurrence;
      occurrence = HomeX2OViewChild.prototype.get_occurrence(val);
      i = parseInt(ind) + 1;
      if (occurrence['value'] === 0) {
        occurrence['value'] = 1;
      }
      return doughnutData.push({
        value: occurrence['value'],
        color: occurrence['color'],
        highlight: occurrence['highlight'],
        label: "Bottle" + i
      });
    });
    return doughnutData;
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

  HomeX2OView.prototype.ui = {
    chartArea: '#chart-area',
    liquid: '.liquid'
  };

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
    console.log(App.useProductColl);
    return this._showView(App.useProductColl);
  };

  HomeX2OCtrl.prototype._showView = function(collection) {
    var model, modelColl, productcollection;
    productcollection = collection.clone();
    model = productcollection.shift();
    console.log(App.useProductColl);
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

  ProductChildView.prototype.template = '<div class="panel-body"> <h5 class="bold margin-none mid-title ">{{name}}<i type="button" class="fa fa-ellipsis-v pull-right dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i> <ul class="dropdown-menu pull-right" role="menu"> <li><a href="#">View</a></li> <li><a href="#">History</a></li> </ul> </h5> <ul class="list-inline text-center row dotted-line m-t-20 userProductList"> <li class="col-md-4  col-xs-4"> <a href="#/products/{{id}}/consume"><img src="assets/images/btn_03.png" width="100px"></a> <h6 class="text-center margin-none">Tap to consume</h6> </li> <li class="col-md-4  col-xs-4"> <h5 class="text-center">Daily Target</h5> <div class="row"> {{#shecule}} <div class="col-md-6  col-xs-6"> <h4 class="text-center bold text-primary margin-none" >{{occ}}<sup class="text-muted">/ {{qty}}</sup></h4> <h6 class="anytime">{{whendata}}</h6> </div> {{/shecule}} </div> </li> <li class="col-md-4  col-xs-4"> <h5 class="text-center">Status</h5> <i class="fa fa-smile-o"></i> <h6 class="text-center margin-none">Complete the last one</h6> </li> </ul> </div> </br> ';

  ProductChildView.prototype.ui = {
    anytime: '.anytime'
  };

  ProductChildView.prototype.serializeData = function() {
    var bonusArr, data, occurrenceArr, recent, shecule, whenar;
    data = ProductChildView.__super__.serializeData.call(this);
    recent = '--';
    data.occur = 0;
    data.time = recent;
    data.bonus = 0;
    occurrenceArr = [];
    bonusArr = 0;
    $.each(this.model.get('occurrence'), function(ind, val) {
      var date, expected, occurrence;
      occurrence = _.has(val, "occurrence");
      expected = _.has(val, "expected");
      if (occurrence === true && expected === true) {
        date = val.occurrence;
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
      data.bonus = bonusArr;
      return data.occurrArr = occurrenceArr;
    });
    shecule = [];
    whenar = ['', 'Morning Before meal', 'Morning After meal', 'Night Before Meal', 'Night After Meal'];
    $.each(this.model.get('qty'), function(ind, val) {
      var occu_data;
      console.log(occurrenceArr[ind]);
      occu_data = occurrenceArr.length;
      if (occurrenceArr[ind] === "" || occurrenceArr[ind] === void 0) {
        occu_data = 0;
      }
      return shecule.push({
        qty: val.qty,
        occ: occu_data,
        whendata: whenar[val.when]
      });
    });
    data.shecule = shecule;
    return data;
  };

  ProductChildView.prototype.onShow = function() {
    if (this.model.get('type') === 'Anytime') {
      return this.ui.anytime.hide();
    }
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
    console.log(App.useProductColl);
    return this._showView(App.useProductColl);
  };

  HomeOtherProductsCtrl.prototype._showView = function(collection) {
    var productcollection;
    productcollection = collection.clone();
    productcollection.shift();
    return this.show(new HomeOtherProductsView({
      collection: productcollection
    }));
  };

  return HomeOtherProductsCtrl;

})(Ajency.RegionController);
