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
    this._showView = __bind(this._showView, this);
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
      var d, date, id, previous, reg_date, timestamp, timezone, today, tt;
      window.param = $(e.target).val();
      if ($('.time_period').val() === '' || $('.time_period').val() === 'all') {
        reg_date = App.graph.get('reg_date');
        this.ui.start_date.val(reg_date);
      } else {
        id = this.ui.time_period.val();
        date = moment().subtract(id, 'days');
        previous = date.format('YYYY-MM-DD');
        this.ui.start_date.val(previous);
      }
      timezone = App.currentUser.get('timezone');
      tt = moment().format('YYYY-MM-DD HH:mm:ss');
      d = new Date();
      timestamp = d.getTime();
      today = moment(timestamp).zone(timezone).format('YYYY-MM-DD');
      this.ui.end_date.val(today);
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
      var d, date, id, previous, reg_date, timestamp, timezone, today, tt;
      window.time_period = $(e.target).val();
      id = $(e.target).val();
      date = moment().subtract(id, 'days');
      previous = date.format('YYYY-MM-DD');
      timezone = App.currentUser.get('timezone');
      tt = moment().format('YYYY-MM-DD HH:mm:ss');
      d = new Date();
      timestamp = d.getTime();
      today = moment(timestamp).zone(timezone).format('YYYY-MM-DD');
      this.ui.start_date.val(previous);
      if (id === 'all') {
        reg_date = App.graph.get('reg_date');
        this.ui.start_date.val(reg_date);
      }
      return this.ui.end_date.val(today);
    },
    'click #showHome': function(e) {
      if (!window.isWebView()) {
        $('.loading').html('Loading data<img src="' + _SITEURL + '/wp-content/themes/twentytwelve/xoomaapp/images/lodaing.GIF" width="70px">');
      }
      if (window.isWebView()) {
        $('.loading').html('Loading data<img src="./images/lodaing.GIF" width="70px">');
      }
      return App.currentUser.getHomeProducts().done(this._showView).fail(this.errorHandler);
    }
  };

  HomeLayoutView.prototype._showView = function(collection) {
    var listview, listview1, model, modelColl, productcollection, region, response;
    $('.loading').html("");
    response = collection.response;
    App.useProductColl.reset(response);
    productcollection = App.useProductColl.clone();
    model = productcollection.findWhere({
      name: 'X2O'
    });
    if (model !== void 0) {
      if (model.get('name').toUpperCase() === 'X2O') {
        modelColl = model;
        listview = new HomeX2OView({
          model: modelColl
        });
        region = new Marionette.Region({
          el: '#x2oregion'
        });
        region.show(listview);
        productcollection.remove(model);
        productcollection.reset(productcollection.toArray());
      }
    }
    listview1 = new HomeOtherProductsView({
      collection: productcollection
    });
    region = new Marionette.Region({
      el: '#otherproducts'
    });
    return region.show(listview1);
  };

  HomeLayoutView.prototype.onFormSubmit = function(_formData) {
    if (!window.isWebView()) {
      $('.loadinggraph').html('Loading data<img src="' + _SITEURL + '/wp-content/themes/twentytwelve/xoomaapp/images/lodaing.GIF" width="70px">');
    }
    if (window.isWebView()) {
      $('.loadinggraph').html('Loading data<img src="./images/lodaing.GIF" width="70px">');
    }
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
    $('.loadinggraph').html("");
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
    window.removeMsg();
    this.ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be loaded!");
    return $('html, body').animate({
      scrollTop: 0
    }, 'slow');
  };

  HomeLayoutView.prototype.onShow = function() {
    var actual_time, current, currentime, d, dateObj, day_night, reg_date, s, timezone, todays_date;
    $('#param option[value="' + window.param + '"]').prop("selected", true);
    $('.time_period option[value="' + window.time_period + '"]').prop("selected", true);
    $('#param').trigger("change");
    $('.time_period').trigger("change");
    todays_date = moment().format('YYYY-MM-DD');
    $('#showHome').hide();
    App.trigger('cordova:hide:splash:screen');
    App.trigger('cordova:register:push:notification');
    timezone = App.currentUser.get('offset');
    currentime = moment.utc(App.currentUser.get('today'), 'YYYY-MM-DD HH:mm:ss').zone(timezone).format('HH:mm:ss');
    s = moment(todays_date + currentime, 'YYYY-MM-DD HH:mm:ss').format('YYYY/MM/DD HH:mm:ss');
    d = new Date(s);
    actual_time = d.getTime();
    current = new Date(actual_time);
    day_night = current.getHours();
    if (parseInt(day_night) <= 12) {
      $('.daynightclass').attr('src', _SITEURL + '/wp-content/themes/twentytwelve/images/morning.gif');
    } else {
      $('.daynightclass').attr('src', _SITEURL + '/wp-content/themes/twentytwelve/images/night.gif');
    }
    $('#update').val(App.currentUser.get('homeDate'));
    reg_date = moment(App.currentUser.get('user_registered')).format('YYYY-MM-DD');
    if (todays_date === App.currentUser.get('homeDate')) {
      $('#update').val('TODAY');
    }
    if (!window.isWebView()) {
      $('#update').datepicker({
        dateFormat: 'yy-mm-dd',
        changeYear: true,
        changeMonth: true,
        maxDate: new Date(todays_date),
        minDate: new Date(reg_date),
        onSelect: function(dateText, inst) {
          $('#showHome').show();
          App.currentUser.set('homeDate', dateText);
          if (todays_date === App.currentUser.get('homeDate')) {
            return $('#update').val('TODAY');
          }
        }
      });
    }
    if (window.isWebView()) {
      dateObj = new Date();
      $('#update').prop('readonly', true).click(function() {
        var maxDate, minDate, options;
        minDate = CordovaApp.isPlatformIOS() ? new Date(reg_date) : (new Date(reg_date)).valueOf();
        maxDate = CordovaApp.isPlatformIOS() ? new Date(todays_date) : (new Date(todays_date)).valueOf();
        options = {
          mode: 'date',
          date: dateObj,
          minDate: minDate,
          maxDate: maxDate
        };
        return datePicker.show(options, function(date) {
          var dateText;
          if (!_.isUndefined(date)) {
            dateObj = date;
            dateText = moment(dateObj).format('YYYY-MM-DD');
            $('#update').val(dateText);
            App.currentUser.set('homeDate', dateText);
            if (todays_date === App.currentUser.get('homeDate')) {
              return $('#update').val('TODAY');
            } else {
              return $('#showHome').show();
            }
          }
        });
      });
    }
    $('.history').attr('href', '#/measurements/' + App.currentUser.get('ID') + '/history');
    $('.update').attr('href', '#/profile/measurements');
    if (parseInt(App.useProductColl.length) === 0) {
      window.removeMsg();
      this.ui.responseMessage.addClass('alert alert-danger').text("No products added by the user!");
      $('html, body').animate({
        scrollTop: 0
      }, 'slow');
    }
    if (window.param === 'bmi') {
      window.param = 'weight';
      window.time_period = 'all';
      this.ui.time_period.show();
      $('#param option[value="' + window.param + '"]').prop("selected", true);
      $('.time_period option[value="' + window.time_period + '"]').prop("selected", true);
      return this.generateGraph();
    } else {
      return this.generateGraph();
    }
  };

  HomeLayoutView.prototype.generateBMIGraph = function(response) {
    var bmi_end, bmi_end_ht, bmi_start, bmi_start_ht, ctdx, dates, et_square, lineChartData, st_square;
    $('#bmi').show();
    this.reset();
    $('#y-axis').text('BMI Ratio');
    $('#canvasregion').show();
    dates = [response['st_date'], response['et_date']];
    bmi_start_ht = parseFloat(response['st_height']) * 12;
    bmi_end_ht = parseFloat(response['et_height']) * 12;
    st_square = parseFloat(bmi_start_ht) * parseFloat(bmi_start_ht);
    et_square = parseFloat(bmi_end_ht) * parseFloat(bmi_end_ht);
    bmi_start = (parseFloat(response['st_weight']) / parseFloat(st_square)) * 703;
    bmi_start = bmi_start.toFixed(2);
    bmi_end = (parseFloat(response['et_weight']) / parseFloat(et_square)) * 703;
    bmi_end = bmi_end.toFixed(2);
    lineChartData = {
      labels: dates,
      datasets: [
        {
          label: "My Second dataset",
          fillColor: "rgba(255, 255, 255, 0.0)",
          strokeColor: "rgba(151,187,205,1)",
          pointColor: "rgba(151,187,205,1)",
          pointStrokeColor: "#fff",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(151,187,205,1)",
          data: [bmi_start, bmi_end]
        }, {
          label: "My First dataset",
          fillColor: "rgba(48, 153, 234, 0.27)",
          strokeColor: "#000000",
          pointColor: "rgba(151,187,205,1)",
          pointStrokeColor: "#fff",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          datasetFill: false,
          data: [24.9, 24.9]
        }, {
          label: "My Second dataset",
          fillColor: "rgba(255, 255, 255, 0.76)",
          strokeColor: "#000000",
          pointColor: "rgba(151,187,205,1)",
          pointStrokeColor: "#fff",
          pointHighlightFill: "#fff",
          datasetFill: false,
          pointHighlightStroke: "rgba(151,187,205,1)",
          data: [18.5, 18.5]
        }
      ]
    };
    ctdx = document.getElementById("canvas").getContext("2d");
    return window.myLine = new Chart(ctdx).Line(lineChartData, {
      responsive: true
    });
  };

  HomeLayoutView.prototype.reset = function() {
    var canvas, ctx;
    $('#canvas').remove();
    $('#graph-container').append('<canvas id="canvas"><canvas>');
    canvas = document.querySelector('#canvas');
    ctx = canvas.getContext('2d');
    ctx.canvas.width = "600";
    return ctx.canvas.height = "450";
  };

  HomeLayoutView.prototype.generateGraph = function() {
    var ctdx, dates, lineChartData, param, size, units;
    $('#bmi').hide();
    this.reset();
    units = 'inches';
    size = 'Size';
    if ($('#param').val() === 'weight') {
      units = 'pounds';
      size = 'Weight';
    }
    $('#y-axis').text(size + ' (' + units + ')');
    $('#canvasregion').show();
    dates = App.graph.get('dates');
    param = App.graph.get('param');
    if (dates.length === 0 && param.length === 0) {
      $('.loadinggraph').html("<li>No data found</li>");
      $('#canvasregion').hide();
      return false;
    }
    lineChartData = {
      labels: dates,
      datasets: [
        {
          label: "My Second dataset",
          fillColor: "#ffffff",
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
    state = App.currentUser.get('state');
    if (state !== '/home') {
      this.show(new workflow);
      return false;
    }
    if (App.useProductColl.length === 0 || App.currentUser.hasChanged('timezone')) {
      window.param = 'weight';
      window.time_period = 'all';
      App.currentUser.set('homeDate', "");
      return App.currentUser.getHomeProducts().done(this._showView).fail(this.errorHandler);
    } else {
      return this.show(new HomeLayoutView);
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
    window.removeMsg();
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

  HomeX2OView.prototype.template = '<div class="row"> <div class="col-md-4 col-xs-4"></div> </div> <div class="panel panel-default"> <div class="panel-body"> <h5 class=" mid-title margin-none"><div> {{name}}</div> <i type="button" class="fa fa-bars pull-right dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i> <ul class="dropdown-menu pull-right" role="menu"> <li><a href="#/product/{{id}}/history">Consumption History</a></li> <li><a href="#/product/{{id}}/edit">Edit product</a></li> </ul> </h5> <div class="row"> <div class="fill-bottle"> <a id="original" href="#/products/{{id}}/bmi/{{dateval}}" > <h6 class="text-center">Hydrate!</h6> <img src="' + _SITEURL + '/wp-content/themes/twentytwelve/images/xooma-bottle.gif"/> <h6 class="text-center texmsg">{{texmsg}}</h6> </a> </div><div id="rays"></div> <div id="canvas-holder"> <canvas id="chart-area" width="500" height="500"/> </div> </div> </div><h6 class="text-primary text-center"><i class="fa fa-clock-o "></i> Last consumed at {{time}}</h6> <br/></div></div>';

  HomeX2OView.prototype.ui = {
    liquid: '.liquid'
  };

  HomeX2OView.prototype.events = {
    'click #original': function(e) {
      var available;
      available = this.model.get('available');
      if (parseInt(available) <= 0) {
        e.preventDefault();
        window.removeMsg();
        $('.aj-response-message').addClass('alert alert-danger').text("Product out of stock!");
        $('html, body').animate({
          scrollTop: 0
        }, 'slow');
        return false;
      } else {
        return true;
      }
    }
  };

  HomeX2OView.prototype.serializeData = function() {
    var bonusArr, consumed, d, data, howmuch, howmuchqty, occurrenceArr, offset, qtyarr, qtyconsumed, recent, texmsg, timestamp, timezone, todays_date, totalservings;
    data = HomeX2OView.__super__.serializeData.call(this);
    texmsg = "";
    timezone = App.currentUser.get('offset');
    occurrenceArr = [];
    bonusArr = 0;
    recent = '--';
    data.time = recent;
    consumed = 0;
    qtyarr = 0;
    qtyconsumed = [];
    totalservings = 0;
    $.each(this.model.get('occurrence'), function(ind, val) {
      var expected, occurrence, q;
      occurrence = _.has(val, "occurrence");
      expected = _.has(val, "expected");
      if (occurrence === true && (expected === true || expected === false)) {
        qtyconsumed = HomeX2OView.prototype.getCount(val.meta_value);
        occurrenceArr.push(qtyconsumed[1]);
      }
      if (occurrence === true && expected === false) {
        consumed++;
      }
      if (occurrence === true && expected === true) {
        qtyconsumed = HomeX2OView.prototype.getCount(val.meta_value);
        qtyarr = parseFloat(qtyconsumed[0]) * 100;
        q = parseInt(qtyarr) / 25;
        return totalservings += q;
      }
    });
    if (occurrenceArr.length !== 0) {
      recent = _.last(occurrenceArr);
      offset = App.currentUser.get('offset');
      console.log(d = new Date(recent));
      timestamp = d.getTime();
      data.time = moment.utc(recent).zone(offset).format("ddd, h:mm A");
      data.occurr = occurrenceArr.length;
    }
    howmuchqty = parseInt(this.model.get('occurrence').length) * 4;
    howmuch = parseInt(totalservings) / parseInt(howmuchqty);
    todays_date = moment().format('YYYY-MM-DD');
    texmsg = "The day has passed by";
    if (todays_date === App.currentUser.get('homeDate')) {
      texmsg = this.generateStatus(consumed, howmuch);
    }
    data.texmsg = texmsg;
    data.remianing = occurrenceArr.length;
    data.dateval = App.currentUser.get('homeDate');
    data.qty = this.model.get('qty').length;
    return data;
  };

  HomeX2OView.prototype.generateStatus = function(consumed, howmuch) {
    var currentime, d, how, per, per1, s, sw, texmsg, time, timearr, timearray, timearry, timeslot, timestamp, timezone;
    timezone = App.currentUser.get('offset');
    texmsg = "";
    timeslot = "";
    timearray = [];
    d = new Date();
    timestamp = d.getTime();
    s = moment(App.currentUser.get('today'), 'YYYY-MM-DD HH:mm:ss').format('YYYY/MM/DD');
    currentime = moment.utc(App.currentUser.get('today'), 'YYYY-MM-DD HH:mm:ss').zone(timezone).format('HH:mm:ss');
    sw = moment(s + currentime, 'YYYY-MM-DD HH:mm:ss').format('YYYY/MM/DD hh:mm A');
    time = new Date(Date.parse(sw)).getTime();
    per = [0, 25, 50, 75, 100, 'bonus'];
    per1 = ['0_25', '25_50', '50_75', '75_100'];
    timearr = ["12AM-11AM", "11AM-4PM", "4PM-9PM", "9PM-12AM"];
    timearry = ["12:00:00 AM-10:59:59 AM", "11:00:00 AM-3:59:59 PM", "4:00:00 PM-8:59:59 PM", "9:00:00 PM-11:59:59 PM"];
    how = howmuch.toFixed(2) * 100;
    if (parseInt(consumed) >= 1) {
      how = 'bonus';
    }
    $.each(timearry, function(ind, val) {
      var d0, d1, temp, timestamp0, timestamp1, v;
      v = timearr[ind];
      temp = val.split('-');
      d0 = new Date(s + ' ' + temp[0]);
      timestamp0 = d0.getTime();
      d1 = new Date(s + ' ' + temp[1]);
      timestamp1 = d1.getTime();
      if (parseInt(timestamp0) <= parseInt(time) && parseInt(timestamp1) >= parseInt(time)) {
        return timeslot = x2oMessages[v];
      }
    });
    $.each(per, function(ind, val) {
      if (val === how) {
        return texmsg = x2oMessages[val + '_' + timeslot];
      }
    });
    $.each(per1, function(ind, val) {
      var temp;
      temp = val.split('_');
      if (parseInt(temp[0]) < parseInt(how) && parseInt(temp[1]) > parseInt(how)) {
        return texmsg = x2oMessages[val + '_' + timeslot];
      }
    });
    return texmsg;
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
    var count, lasttime, time;
    count = 0;
    time = [];
    if (!(_.isArray(val))) {
      count += parseFloat(val.qty);
      time.push(val.date);
    } else {
      $.each(val, function(ind, val1) {
        if (!(_.isArray(val1))) {
          count += parseFloat(val1.qty);
          return time.push(val1.date);
        } else {
          return $.each(val1, function(ind, val2) {
            if (_.isArray(val2)) {
              return $.each(val2, function(ind, value) {
                count += parseFloat(value.qty);
                return time.push(value.date);
              });
            } else {
              count += parseFloat(val2.qty);
              return time.push(val2.date);
            }
          });
        }
      });
    }
    lasttime = _.last(time);
    return [count, lasttime];
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
    if (qty[1] === void 0) {
      qty[1] = [];
    }
    if (occurrence === true && expected === true) {
      arr['color'] = "#6bbfff";
      arr['value'] = qty[0];
      arr['time'] = qty[1];
    }
    if (occurrence === false && expected === true) {
      arr['color'] = "#e3e3e3";
      arr['value'] = qty[0];
      arr['time'] = qty[1];
    }
    if (occurrence === true && expected === false) {
      arr['color'] = "#ffaa06";
      arr['value'] = qty[0];
      arr['time'] = qty[1];
    }
    return arr;
  };

  HomeX2OView.prototype.drawBottle = function(data) {
    var doughnutData, timezone;
    data.sort(function(a, b) {
      return parseInt(a.meta_id) - parseInt(b.meta_id);
    });
    timezone = App.currentUser.get('offset');
    doughnutData = [];
    $.each(data, function(ind, val) {
      var i, msg, occurrence, time;
      occurrence = HomeX2OView.prototype.get_occurrence(val);
      i = parseInt(ind) + 1;
      if (occurrence['value'] === 0) {
        msg = "Pending ";
        occurrence['value'] = 1;
      }
      if (occurrence['time'].length !== 0) {
        time = moment.utc(occurrence['time']).zone(timezone).format('h:mm A');
        msg = "(%) of Bottle " + i + ' consumed ';
      }
      return doughnutData.push({
        value: parseFloat(occurrence['value']) * 100,
        color: occurrence['color'],
        label: msg
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

  ProductChildView.prototype.template = '<div class="panel-body"> <h5 class=" mid-title margin-none"><div> {{name}}<span>( {{serving_size}}  Serving/ Day )</span></div><i type="button" class="fa fa-bars pull-right dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i> <ul class="dropdown-menu pull-right" role="menu"> <li><a href="#/product/{{id}}/history">Consumption History</a></li> <li><a href="#/product/{{id}}/edit">Edit product</a></li> </ul> </h5> <input type="hidden" name="qty{{id}}"  id="qty{{id}}" value="" /> <input type="hidden" name="meta_id{{id}}"  id="meta_id{{id}}" value="" /> <ul class="list-inline dotted-line  text-center row m-t-20 panel-product"> <li class="col-md-8 col-xs-12 col-sm-8"> <ul class="list-inline no-dotted"> {{#no_servings}} {{{servings}}} {{/no_servings}} </ul> </li> <li class="col-md-4 col-xs-12 col-sm-4 mobile-status"> <h5 class="text-center hidden-xs">Status</h5> <i class="fa fa-smile-o"></i> <h6 class="text-center margin-none status">{{texmsg}}</h6> </li> </ul> </div> <div class="panel-footer hidden"><i id="bell{{id}}" class="{{remindermsg}}"></i> Hey {{username}}! {{msg}}</div>';

  ProductChildView.prototype.ui = {
    anytime: '.anytime'
  };

  ProductChildView.prototype.events = {
    'click #original': function(e) {
      var available;
      available = this.model.get('available');
      if (parseInt(available) <= 0) {
        e.preventDefault();
        window.removeMsg();
        $('.aj-response-message').addClass('alert alert-danger').text("Product out of stock!");
        $('html, body').animate({
          scrollTop: 0
        }, 'slow');
        return false;
      } else {
        return true;
      }
    }
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
    var bonusArr, consumed, count, data, howmuch, model, msg, no_servings, occurrenceArr, product_type, qty, recent, reponse, skip, temp, texmsg, time, timeslot, timezone, todays_date;
    data = ProductChildView.__super__.serializeData.call(this);
    occurrenceArr = [];
    no_servings = [];
    bonusArr = 0;
    consumed = 0;
    qty = this.model.get('qty');
    product_type = this.model.get('product_type');
    product_type = product_type.toLowerCase();
    temp = [];
    texmsg = "";
    timeslot = "";
    time = "";
    timezone = App.currentUser.get('offset');
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
        occurrenceArr.push(val);
        reponse = ProductChildView.prototype.occurredfunc(val, ind, model);
        if (parseInt(val.meta_value.qty) !== 0) {
          consumed++;
        }
      } else if (occurrence === false && expected === true) {
        reponse = ProductChildView.prototype.expectedfunc(val, ind, count, model);
        count++;
      }
      response = reponse[0];
      return no_servings.push({
        servings: response.html,
        schedule: response.schedule_id,
        meta_id: response.meta_id,
        qty: response.qty
      });
    });
    data.no_servings = no_servings;
    data.serving_size = temp.length;
    skip = this.checkSkip(temp);
    todays_date = moment().format('YYYY-MM-DD');
    texmsg = "The day has passed by";
    if (skip[0].length !== 0 && todays_date === App.currentUser.get('homeDate')) {
      texmsg = skip[1];
    } else if (skip[0].length === 0 && todays_date === App.currentUser.get('homeDate')) {
      howmuch = parseFloat(parseInt(consumed) / parseInt(temp.length)) * 100;
      texmsg = this.checkStatus(howmuch);
    }
    msg = "Time set for reminders has already elapsed";
    if (parseInt(model.get('reminder').length) === 0) {
      msg = "No reminders set";
    }
    data.remindermsg = 'fa fa-bell-slash no-remiander';
    recent = _.last(occurrenceArr);
    data.texmsg = texmsg;
    data.username = App.currentUser.get('display_name');
    data.msg = msg;
    return data;
  };

  ProductChildView.prototype.checkSkip = function(temp) {
    var msg, skip_arr;
    skip_arr = [];
    $.each(temp, function(ind, val) {
      var expected, occurrence, qty;
      occurrence = _.has(val, "occurrence");
      expected = _.has(val, "expected");
      if (occurrence === true && expected === true) {
        qty = val.meta_value.qty;
        if (parseInt(qty) === 0) {
          return skip_arr.push(qty);
        } else {
          return skip_arr = [];
        }
      }
    });
    msg = 'Oops! Not good! Try not to repeat';
    if (skip_arr.length === temp.length) {
      msg = 'Aww! Thats bad..';
    }
    return [skip_arr, msg];
  };

  ProductChildView.prototype.checkStatus = function(howmuch) {
    var currentime, per, per1, s, sw, texmsg, time, timearr, timearry, timeslot, timezone;
    timezone = App.currentUser.get('offset');
    timeslot = "";
    texmsg = "";
    s = moment(App.currentUser.get('today'), 'YYYY-MM-DD HH:mm:ss').format('YYYY/MM/DD');
    currentime = moment.utc(App.currentUser.get('today'), 'YYYY-MM-DD HH:mm:ss').zone(timezone).format('HH:mm:ss');
    sw = moment(s + currentime, 'YYYY-MM-DD HH:mm:ss').format('YYYY/MM/DD hh:mm A');
    time = new Date(Date.parse(sw)).getTime();
    per = [0, 25, 50, 75, 100, 'bonus'];
    per1 = ['0_25', '25_50', '50_75', '75_100'];
    timearr = ["12AM-11AM", "11AM-4PM", "4PM-9PM", "9PM-12AM"];
    timearry = ["12:00:00 AM-10:59:59 AM", "11:00:00 AM-3:59:59 PM", "4:00:00 PM-8:59:59 PM", "9:00:00 PM-11:59:59 PM"];
    $.each(timearry, function(ind, val) {
      var d0, d1, temp, timestamp0, timestamp1, v;
      v = timearr[ind];
      temp = val.split('-');
      d0 = new Date(s + ' ' + temp[0]);
      timestamp0 = d0.getTime();
      d1 = new Date(s + ' ' + temp[1]);
      timestamp1 = d1.getTime();
      if (parseInt(timestamp0) <= parseInt(time) && parseInt(timestamp1) >= parseInt(time)) {
        return timeslot = Messages[v];
      }
    });
    $.each(per, function(ind, val) {
      if (parseInt(val) === parseInt(howmuch)) {
        return texmsg = Messages[val + '_' + timeslot];
      }
    });
    $.each(per1, function(ind, val) {
      var temp;
      temp = val.split('_');
      if (parseInt(temp[0]) < parseInt(howmuch) && parseInt(temp[1]) > parseInt(howmuch)) {
        return texmsg = Messages[val + '_' + timeslot];
      }
    });
    return texmsg;
  };

  ProductChildView.prototype.expectedfunc = function(val, key, count, model) {
    var classname, d, date, html, i, increment, meta_id, newClass, product, product_type, qty, reminders, schedule_id, serving_text, temp, tempcnt, time, timestamp, timezone, whenarr;
    temp = [];
    i = 0;
    html = "";
    timezone = App.currentUser.get('offset');
    product_type = model.get('product_type');
    product_type = product_type.toLowerCase();
    qty = model.get('qty');
    reminders = model.get('reminder');
    classname = "hidden";
    time = "";
    tempcnt = 0;
    increment = parseInt(key) + 1;
    product = model.get('id');
    date = App.currentUser.get('homeDate');
    whenarr = [0, 'Morning Before meal', 'Morning After meal', 'Night Before meal', 'Night After meal'];
    if (model.get('type') === "Anytime") {
      serving_text = 'Serving ' + increment;
    } else {
      serving_text = whenarr[qty[key].when];
    }
    if (parseInt(reminders.length) !== 0) {
      classname = '';
      time = reminders[key].time;
      d = new Date(time);
      timestamp = d.getTime();
      time = moment.utc(reminders[key].time).zone(timezone).format("h:mm A");
      serving_text = time;
    }
    newClass = product_type + '_expected_class';
    if (parseInt(count) === 0) {
      html += '<li><a href="#/products/' + product + '/consume/' + date + '" id="original"><span class="circle-btn"><img src="' + _SITEURL + '/wp-content/themes/twentytwelve/xoomaapp/images/btn_03.png" width="70px"></span></a> <h6 class="text-center margin-none">Tap to take </h6> <h6 class="text-center text-primary ' + classname + '">' + time + '</h6></li>';
    } else {
      html += '<li><a > <h3 ><div class="cap ' + newClass + '"></div>' + qty[key].qty + '</h3> </a>';
      html += '<i class="fa fa-clock-o center-block status"></i> <h6 class="text-center text-primary">' + serving_text + '</h6></li>';
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
    timezone = App.currentUser.get('offset');
    time = moment.utc(val.meta_value.date).zone(timezone).format("h:mm A");
    product_type = model.get('product_type');
    product_type = product_type.toLowerCase();
    qty = val.meta_value.qty;
    if (parseInt(qty) === 0) {
      time = "Skipped";
    }
    html = "";
    newClass = product_type + '_occurred_class';
    html += '<li><a><h3><div class="cap ' + newClass + '"></div>' + qty + '</h3></a>';
    html += '<i class="fa fa-check center-block status"></i><h6 class="text-center text-primary">' + time + '</h6></li>';
    qty = val.meta_value.qty;
    schedule_id = val.schedule_id;
    meta_id = val.meta_id;
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
