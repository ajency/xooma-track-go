// Generated by CoffeeScript 1.7.1
var HomeLayoutView, HomeOtherProductsView, HomeX2OView, ProductChildView,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

App.state('home', {
  url: '/home',
  parent: 'xooma',
  sections: {
    'x2o': {
      ctrl: 'HomeX2OCtrl'
    },
    'other-products': {
      ctrl: 'HomeOtherProductsCtrl'
    }
  }
});

HomeLayoutView = (function(_super) {
  __extends(HomeLayoutView, _super);

  function HomeLayoutView() {
    this._errorHandler = __bind(this._errorHandler, this);
    this._successHandler = __bind(this._successHandler, this);
    this.onFormSubmit = __bind(this.onFormSubmit, this);
    return HomeLayoutView.__super__.constructor.apply(this, arguments);
  }

  HomeLayoutView.prototype.template = '#home-template';

  HomeLayoutView.prototype.behaviors = {
    FormBehavior: {
      behaviorClass: Ajency.FormBehavior
    }
  };

  HomeLayoutView.prototype.ui = {
    time_period: '.time_period',
    start_date: '#start_date',
    end_date: '#end_date',
    generate: 'input[name="generate"]',
    form: '#generate_graph',
    param: 'input[name="param"]',
    history: '.history',
    update: '.update',
    responseMessage: '.aj-response-message',
    param: '#param'
  };

  HomeLayoutView.prototype.events = {
    'change @ui.param': function(e) {
      if ($(e.target).val() === 'bmi') {
        return this.ui.time_period.hide();
      } else {
        return this.ui.time_period.show();
      }
    },
    'click @ui.history': function(e) {
      e.preventDefault();
      return App.navigate('#/measurements/' + App.currentUser.get('ID') + '/history', true);
    },
    'click @ui.update': function(e) {
      e.preventDefault();
      return App.navigate('#/profile/measurements', true);
    },
    'change @ui.time_period': function(e) {
      var date, id, previous, reg_date, today;
      id = $(e.target).val();
      date = moment().subtract(id, 'days');
      previous = date.format('YYYY-MM-DD');
      today = moment().format('YYYY-MM-DD');
      this.ui.start_date.val(previous);
      if (id === 'all') {
        reg_date = App.graph.get('reg_date');
        this.ui.start_date.val(reg_date);
      }
      return this.ui.end_date.val(today);
    }
  };

  HomeLayoutView.prototype.onFormSubmit = function(_formData) {
    return $.ajax({
      method: 'GET',
      data: _formData,
      url: "" + APIURL + "/graphs/" + (App.currentUser.get('ID')),
      success: this._successHandler,
      error: this._errorHandler
    });
  };

  HomeLayoutView.prototype._successHandler = function(response, status, xhr) {
    var dates;
    dates = _.has(response, "dates");
    if (dates === true && xhr.status === 200) {
      App.graph.set('dates', response.dates);
      App.graph.set('param', response.param);
      return this.generateGraph();
    } else if (dates === false && xhr.status === 200) {
      return this.generateBMIGraph(response);
    } else {
      return this.showErrorMsg();
    }
  };

  HomeLayoutView.prototype._errorHandler = function(response, status, xhr) {
    return this.showErrorMsg();
  };

  HomeLayoutView.prototype.showErrorMsg = function() {
    this.ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be loaded!");
    return $('html, body').animate({
      scrollTop: 0
    }, 'slow');
  };

  HomeLayoutView.prototype.onShow = function() {
    if (parseInt(App.useProductColl.length) === 0) {
      this.ui.responseMessage.addClass('alert alert-danger').text("No products added by the user!");
      $('html, body').animate({
        scrollTop: 0
      }, 'slow');
    }
    return this.generateGraph();
  };

  HomeLayoutView.prototype.generateBMIGraph = function(response) {
    var bmi_end, bmi_end_ht, bmi_start, bmi_start_ht, ctdx, dates, et_square, lineChartData, st_square;
    dates = [response['st_date'], response['et_date']];
    bmi_start_ht = parseFloat(response['st_height']) * 12;
    bmi_end_ht = parseFloat(response['et_height']) * 12;
    st_square = parseFloat(bmi_start_ht) * parseFloat(bmi_start_ht);
    et_square = parseFloat(bmi_end_ht) * parseFloat(bmi_end_ht);
    bmi_start = (parseFloat(response['st_weight']) / parseFloat(st_square)) * 703;
    bmi_end = (parseFloat(response['et_weight']) / parseFloat(et_square)) * 703;
    lineChartData = {
      labels: dates,
      datasets: [
        {
          label: "My Second dataset",
          fillColor: "rgba(151,187,205,0.2)",
          strokeColor: "rgba(151,187,205,1)",
          pointColor: "rgba(151,187,205,1)",
          pointStrokeColor: "#fff",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(151,187,205,1)",
          data: [bmi_start, bmi_end]
        }
      ]
    };
    ctdx = document.getElementById("canvas").getContext("2d");
    return window.myLine = new Chart(ctdx).Line(lineChartData, {
      responsive: true
    });
  };

  HomeLayoutView.prototype.generateGraph = function() {
    var ctdx, dates, lineChartData, param;
    dates = App.graph.get('dates');
    param = App.graph.get('param');
    lineChartData = {
      labels: dates,
      datasets: [
        {
          label: "My Second dataset",
          fillColor: "rgba(151,187,205,0.2)",
          strokeColor: "rgba(151,187,205,1)",
          pointColor: "rgba(151,187,205,1)",
          pointStrokeColor: "#fff",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(151,187,205,1)",
          data: param
        }
      ]
    };
    ctdx = document.getElementById("canvas").getContext("2d");
    return window.myLine = new Chart(ctdx).Line(lineChartData, {
      responsive: true
    });
  };

  return HomeLayoutView;

})(Marionette.LayoutView);

App.HomeCtrl = (function(_super) {
  __extends(HomeCtrl, _super);

  function HomeCtrl() {
    this.errorHandler = __bind(this.errorHandler, this);
    this._showView = __bind(this._showView, this);
    return HomeCtrl.__super__.constructor.apply(this, arguments);
  }

  HomeCtrl.prototype.initialize = function() {
    var state;
    console.log(state = App.currentUser.get('state'));
    if (App.useProductColl.length === 0 && state === '/home') {
      return App.currentUser.getHomeProducts().done(this._showView).fail(this.errorHandler);
    } else {
      if (state !== '/home') {
        return new workflow;
      } else {
        return this.show(new HomeLayoutView);
      }
    }
  };

  HomeCtrl.prototype._showView = function(collection) {
    var response, state;
    this.show(this.parent().getLLoadingView());
    response = collection.response;
    App.useProductColl.reset(response);
    state = App.currentUser.get('state');
    return this.show(new HomeLayoutView);
  };

  HomeCtrl.prototype.errorHandler = function() {
    $('.aj-response-message').addClass('alert alert-danger').text("Data couldn't be loaded!");
    return $('html, body').animate({
      scrollTop: 0
    }, 'slow');
  };

  return HomeCtrl;

})(Ajency.RegionController);

HomeX2OView = (function(_super) {
  __extends(HomeX2OView, _super);

  function HomeX2OView() {
    return HomeX2OView.__super__.constructor.apply(this, arguments);
  }

  HomeX2OView.prototype.template = '<div class="row"> <div class="col-md-4 col-xs-4"></div> <div class="col-md-4 col-xs-4"> <h4 class="text-center">TODAY </h4></div> <div class="col-md-4 col-xs-4"> <h5 class="text-center">HISTORY <i class="fa fa-angle-right"></i></h5> </div> </div> <div class="panel panel-default"> <div class="panel-body"> <h5 class="margin-none mid-title ">{{name}}<i type="button" class="fa fa-ellipsis-v pull-right dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i> <ul class="dropdown-menu pull-right" role="menu"> <li><a href="#/product/{{id}}/history">Consumption History</a></li> </ul> </h5> <div class="row"> <div class="col-md-12"> <div class="fill-bottle"> <div class="glass"> <span class="liquid" style="height: 100%"></span> </div> </div> <div id="canvas-holder"> <canvas id="chart-area" width="500" height="500"/> </div> </div> </div><ul class="list-inline text-center row row-line x2oList"> <a href="#/products/{{id}}/bmi" ><li class="col-md-4 col-xs-4"> <h5 class="text-center">Daily Target</h5> <h4 class="text-center bold  text-primary" >{{qty}}</h4> </li> <li class="col-md-4 col-xs-4"> <h5 class="text-center">Consumed</h5> <h4 class="text-center bold text-primary margin-none" >{{remianing}}</h4> </li> <li class="col-md-4 col-xs-4"> <h5 class="text-center">Last consumed at</h5> <h4 class="text-center bold text-primary" >{{time}}</small></h4> </li></a> </ul></div></div>';

  HomeX2OView.prototype.ui = {
    liquid: '.liquid'
  };

  HomeX2OView.prototype.serializeData = function() {
    var bonusArr, data, occurrenceArr, recent;
    data = HomeX2OView.__super__.serializeData.call(this);
    occurrenceArr = [];
    bonusArr = 0;
    recent = '--';
    data.time = recent;
    data.bonus = 0;
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
      }
      data.bonus = bonusArr;
      return data.occurr = occurrenceArr.length;
    });
    data.remianing = occurrenceArr.length;
    data.qty = this.model.get('qty').length;
    return data;
  };

  HomeX2OView.prototype.onShow = function() {
    var bonusArr, consumed, ctx, doughnutData, occurrenceArr, target;
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
        return bonusArr++;
      }
    });
    consumed = occurrenceArr.length;
    target = this.model.get('qty1');
    doughnutData = this.drawBottle(this.model.get('occurrence'));
    ctx = document.getElementById("chart-area").getContext("2d");
    window.myDoughnut = new Chart(ctx).Doughnut(doughnutData, {
      responsive: true,
      percentageInnerCutout: 80,
      animateRotate: false
    });
    return this.ui.liquid.each(function(e) {
      return $(e.target).data("origHeight", $(e.target).height()).height(0).animate({
        height: $(this).data("origHeight")
      }, 3000);
    });
  };

  HomeX2OView.prototype.getCount = function(val) {
    var count;
    count = 0;
    if (!(_.isArray(val))) {
      count += parseFloat(val.qty);
    } else {
      $.each(val, function(ind, val1) {
        if (!(_.isArray(val1))) {
          return count += parseFloat(val1.qty);
        } else {
          return $.each(val1, function(ind, val2) {
            if (_.isArray(val2)) {
              return $.each(val2, function(ind, value) {
                return count += parseFloat(value.qty);
              });
            } else {
              return count += parseFloat(val2.qty);
            }
          });
        }
      });
    }
    return count;
  };

  HomeX2OView.prototype.get_occurrence = function(data) {
    var arr, expected, meta_value, occurrence, qty, value;
    occurrence = _.has(data, "occurrence");
    expected = _.has(data, "expected");
    meta_value = data.meta_value;
    value = 0;
    arr = [];
    qty = 0;
    qty = HomeX2OView.prototype.getCount(data.meta_value);
    if (occurrence === true && expected === true) {
      arr['color'] = "#6bbfff";
      arr['highlight'] = "#50abf1";
      arr['value'] = qty;
    } else if (occurrence === false && expected === true) {
      arr['color'] = "#e3e3e3";
      arr['highlight'] = "#cdcdcd";
      arr['value'] = qty;
    } else if (occurrence === true && expected === false) {
      arr['color'] = "#ffaa06";
      arr['highlight'] = "#cdcdcd";
      arr['value'] = qty;
    }
    return arr;
  };

  HomeX2OView.prototype.drawBottle = function(data) {
    var doughnutData;
    doughnutData = [];
    $.each(data, function(ind, val) {
      var i, occurrence;
      occurrence = HomeX2OView.prototype.get_occurrence(val);
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

  return HomeX2OView;

})(Marionette.ItemView);

App.HomeX2OCtrl = (function(_super) {
  __extends(HomeX2OCtrl, _super);

  function HomeX2OCtrl() {
    this._showView = __bind(this._showView, this);
    return HomeX2OCtrl.__super__.constructor.apply(this, arguments);
  }

  HomeX2OCtrl.prototype.initialize = function() {
    return this._showView(App.useProductColl);
  };

  HomeX2OCtrl.prototype._showView = function(collection) {
    var model, modelColl, productcollection;
    productcollection = collection.clone();
    model = productcollection.findWhere({
      name: 'X2O'
    });
    if (model !== void 0) {
      if (model.get('name').toUpperCase() === 'X2O') {
        modelColl = model;
        return this.show(new HomeX2OView({
          model: modelColl
        }));
      }
    }
  };

  return HomeX2OCtrl;

})(Ajency.RegionController);

ProductChildView = (function(_super) {
  __extends(ProductChildView, _super);

  function ProductChildView() {
    this.saveHandler = __bind(this.saveHandler, this);
    return ProductChildView.__super__.constructor.apply(this, arguments);
  }

  ProductChildView.prototype.className = 'panel panel-default';

  ProductChildView.prototype.template = '<div class="panel-body"> <h5 class="margin-none mid-title ">{{name}}<span>( {{serving_size}}  Serving/ Day )</span><i type="button" class="fa fa-ellipsis-v pull-right dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i> <ul class="dropdown-menu pull-right" role="menu"> <li><a href="#/product/{{id}}/history">Consumption History</a></li> </ul> </h5> <input type="hidden" name="qty{{id}}"  id="qty{{id}}" value="" /> <input type="hidden" name="meta_id{{id}}"  id="meta_id{{id}}" value="" /> <ul class="list-inline dotted-line  text-center row m-t-20"> <li class="col-md-8 col-xs-8"> <ul class="list-inline no-dotted"> {{#no_servings}} {{{servings}}} {{/no_servings}} </ul> </li> <li class="col-md-4 col-xs-4"> <h5 class="text-center">Status</h5> <i class="fa fa-smile-o"></i> <h6 class="text-center margin-none">Complete the last one</h6> </li> </ul> </div> </br> ';

  ProductChildView.prototype.ui = {
    anytime: '.anytime'
  };

  ProductChildView.prototype.saveHandler = function(response, status, xhr) {
    var home, model, productcollection, region;
    this.model.set('occurrence', response.occurrence);
    productcollection = App.useProductColl.clone();
    model = productcollection.findWhere({
      name: 'X2O'
    });
    if (model !== void 0) {
      if (model.get('name').toUpperCase() === 'X2O') {
        productcollection.remove(model);
        productcollection.reset(productcollection.toArray());
      }
    }
    home = new HomeOtherProductsView({
      collection: productcollection
    });
    region = new Marionette.Region({
      el: '#otherproducts'
    });
    return region.show(home);
  };

  ProductChildView.prototype.serializeData = function() {
    var bonusArr, count, data, model, no_servings, occurrenceArr, product_type, qty, recent, reponse, temp;
    data = ProductChildView.__super__.serializeData.call(this);
    recent = '--';
    data.occur = 0;
    data.time = recent;
    data.bonus = 0;
    occurrenceArr = [];
    no_servings = [];
    bonusArr = 0;
    qty = this.model.get('qty');
    product_type = this.model.get('product_type');
    product_type = product_type.toLowerCase();
    temp = [];
    $.each(this.model.get('occurrence'), function(ind, val) {
      if (qty[ind] !== void 0) {
        return temp.push(val);
      }
    });
    reponse = "";
    count = 0;
    model = this.model;
    $.each(temp, function(ind, val) {
      var expected, occurrence, response;
      occurrence = _.has(val, "occurrence");
      expected = _.has(val, "expected");
      if (occurrence === true && expected === true) {
        reponse = ProductChildView.prototype.occurredfunc(val, ind, model);
      } else if (occurrence === false && expected === true) {
        reponse = ProductChildView.prototype.expectedfunc(val, ind, count, model);
        count++;
      }
      response = reponse[0];
      no_servings.push({
        servings: response.html,
        schedule: response.schedule_id,
        meta_id: response.meta_id,
        qty: response.qty
      });
      data.no_servings = no_servings;
      return data.serving_size = temp.length;
    });
    return data;
  };

  ProductChildView.prototype.expectedfunc = function(val, key, count, model) {
    var classname, date, html, i, increment, meta_id, newClass, product, product_type, qty, reminders, schedule_id, temp, tempcnt, time;
    temp = [];
    i = 0;
    html = "";
    product_type = model.get('product_type');
    product_type = product_type.toLowerCase();
    qty = model.get('qty');
    reminders = model.get('reminder');
    classname = "hidden";
    time = "";
    tempcnt = 0;
    increment = parseInt(key) + 1;
    product = model.get('id');
    date = moment().format('YYYY-MM-DD');
    if (parseInt(reminders.length) !== 0) {
      classname = '';
      time = reminders[key].time;
    }
    newClass = product_type + '_expected_class';
    if (parseInt(count) === 0) {
      html += '<li><a href="#/products/' + product + '/consume/' + date + '" id="original"><img src="' + _SITEURL + '/wp-content/themes/twentytwelve/xoomaapp/images/btn_03.png" width="70px"></a> <h6 class="text-center margin-none">Tap to take </h6> <h6 class="text-center text-primary ' + classname + '">' + time + '</h6></li>';
    } else {
      html += '<li><a > <h3 class="bold"><div class="cap ' + newClass + '"></div>' + qty[key].qty + '</h3> </a>';
      html += '<i class="fa fa-clock-o center-block status"></i> <h6 class="text-center text-primary">Serving ' + increment + '</h6></li>';
    }
    qty = qty[key].qty;
    $('#qty' + model.get('id')).val(qty);
    schedule_id = val.schedule_id;
    meta_id = 0;
    temp.push({
      html: html,
      schedule_id: schedule_id,
      qty: qty,
      meta_id: meta_id
    });
    return temp;
  };

  ProductChildView.prototype.occurredfunc = function(val, key, model) {
    var html, i, meta_id, newClass, product_type, qty, schedule_id, temp, time, timezone;
    temp = [];
    i = 0;
    timezone = App.currentUser.get('timezone');
    time = moment(val.occurrence + timezone, "HH:mm Z").format("hA");
    product_type = model.get('product_type');
    product_type = product_type.toLowerCase();
    qty = model.get('qty');
    html = "";
    newClass = product_type + '_occurred_class';
    html += '<li><a ><h3 class="bold"><div class="cap ' + newClass + '"></div>' + qty[key].qty + '</h3></a>';
    html += '<i class="fa fa-check center-block status"></i><h6 class="text-center text-primary">' + time + '</h6></li>';
    qty = qty[key].qty;
    schedule_id = val.schedule_id;
    meta_id = 0;
    temp.push({
      html: html,
      schedule_id: schedule_id,
      qty: qty,
      meta_id: meta_id
    });
    return temp;
  };

  return ProductChildView;

})(Marionette.ItemView);

HomeOtherProductsView = (function(_super) {
  __extends(HomeOtherProductsView, _super);

  function HomeOtherProductsView() {
    return HomeOtherProductsView.__super__.constructor.apply(this, arguments);
  }

  HomeOtherProductsView.prototype.template = '<span></span>';

  HomeOtherProductsView.prototype.childView = ProductChildView;

  return HomeOtherProductsView;

})(Marionette.CompositeView);

App.HomeOtherProductsCtrl = (function(_super) {
  __extends(HomeOtherProductsCtrl, _super);

  function HomeOtherProductsCtrl() {
    this._showView = __bind(this._showView, this);
    return HomeOtherProductsCtrl.__super__.constructor.apply(this, arguments);
  }

  HomeOtherProductsCtrl.prototype.initialize = function() {
    return this._showView(App.useProductColl);
  };

  HomeOtherProductsCtrl.prototype._showView = function(collection) {
    var model, productcollection;
    productcollection = collection.clone();
    model = productcollection.findWhere({
      name: 'X2O'
    });
    if (model !== void 0) {
      if (model.get('name').toUpperCase() === 'X2O') {
        productcollection.remove(model);
        productcollection.reset(productcollection.toArray());
      }
    }
    return this.show(new HomeOtherProductsView({
      collection: productcollection
    }));
  };

  return HomeOtherProductsCtrl;

})(Ajency.RegionController);
