var MeasurementHistoryView,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

App.state('ViewMeasurementHistory', {
  url: '/measurements/:id/history',
  parent: 'xooma'
});

MeasurementHistoryView = (function(_super) {
  __extends(MeasurementHistoryView, _super);

  function MeasurementHistoryView() {
    this.errorHandler = __bind(this.errorHandler, this);
    this.successHandler = __bind(this.successHandler, this);
    return MeasurementHistoryView.__super__.constructor.apply(this, arguments);
  }

  MeasurementHistoryView.prototype.template = '#measurement-history-template';

  MeasurementHistoryView.prototype.ui = {
    responseMessage: '.aj-response-message'
  };

  MeasurementHistoryView.prototype.events = {
    'click #show': function() {
      var product;
      product = Marionette.getOption(this, 'id');
      return this.loadData(product);
    }
  };

  MeasurementHistoryView.prototype.onShow = function() {
    var product;
    product = Marionette.getOption(this, 'id');
    this.loadData(product);
    return $('#picker_inline_fixed').datepicker({
      inline: true,
      dateFormat: 'yy-mm-dd',
      changeYear: true,
      changeMonth: true,
      maxDate: new Date()
    });
  };

  MeasurementHistoryView.prototype.loadData = function(id) {
    var date, product;
    product = id;
    date = moment($('#picker_inline_fixed').val()).format("YYYY-MM-DD");
    if ($('#picker_inline_fixed').val() === "") {
      date = moment().format("YYYY-MM-DD");
    }
    $('.viewHistory').html('<li>Loading data<img src="' + _SITEURL + '/wp-content/themes/twentytwelve/xoomaapp/images/lodaing.GIF" width="70px"></li>');
    return $.ajax({
      method: 'GET',
      data: 'date=' + date,
      url: "" + _SITEURL + "/wp-json/measurements/" + (App.currentUser.get('ID')) + "/history",
      success: this.successHandler,
      error: this.errorHandler
    });
  };

  MeasurementHistoryView.prototype.successHandler = function(response, status, xhr) {
    if (xhr.status === 200) {
      return this.showData(response);
    } else {
      return this.showErrorMsg();
    }
  };

  MeasurementHistoryView.prototype.errorHandler = function(response, status, xhr) {
    return this.showErrorMsg();
  };

  MeasurementHistoryView.prototype.showErrorMsg = function() {
    this.ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be loaded!");
    return $('html, body').animate({
      scrollTop: 0
    }, 'slow');
  };

  MeasurementHistoryView.prototype.showData = function(response) {
    var classarr, coll, html;
    if (response.length !== 0) {
      coll = response.response;
      classarr = [];
      $.each(coll, function(ind, val) {
        classarr[ind] = "";
        if (coll[ind] === "") {
          coll[ind] = 'No data available';
          return classarr[ind] = 'hidden';
        }
      });
      html = "";
      html += '<li><span class="circle"></span><span>Height : </span>' + coll.height + '<span class="' + classarr['height'] + '"> inches</span>';
      html += '<li><span class="circle"></span><span>Weight : </span>' + coll.weight + '<span class="' + classarr['weight'] + '"> lb</span></span>';
      html += '<li><span class="circle"></span><span>Neck : </span>' + coll.neck + '<span class="' + classarr['neck'] + '"> inches</span>';
      html += '<li><span class="circle"></span><span>Chest : </span>' + coll.chest + '<span class="' + classarr['chest'] + '"> inches</span>';
      html += '<li><span class="circle"></span><span>Arm : </span>' + coll.arm + '<span class="' + classarr['arm'] + '"> inches</span>';
      html += '<li><span class="circle"></span><span>Abdomen : </span>' + coll.abdomen + '<span class="' + classarr['abdomen'] + '"> inches</span>';
      html += '<li><span class="circle"></span><span>Waist : </span>' + coll.waist + '<span class="' + classarr['waist'] + '"> inches</span>';
      html += '<li><span class="circle"></span><span>Hips : </span>' + coll.hips + '<span class="' + classarr['hips'] + '"> inches</span>';
      html += '<li><span class="circle"></span><span>Thigh : </span>' + coll.thigh + '<span class="' + classarr['thigh'] + '"> inches</span>';
      html += '<li><span class="circle"></span><span>MidCalf : </span>' + coll.midcalf + '<span class="' + classarr['midcalf'] + '"> inches</span>';
    } else {
      html = '<li><span>No data available.Please go to settings and update your Progress Chart.</span></li>';
    }
    return $('.viewHistory').html(html);
  };

  MeasurementHistoryView.prototype.scrollPageTo = function($node) {
    $('html, body').animate({
      scrollTop: ~~$node.offset().top - 60
    }, 150);
    return $('body').css('overflow', 'auto');
  };

  return MeasurementHistoryView;

})(Marionette.ItemView);

App.ViewMeasurementHistoryCtrl = (function(_super) {
  __extends(ViewMeasurementHistoryCtrl, _super);

  function ViewMeasurementHistoryCtrl() {
    return ViewMeasurementHistoryCtrl.__super__.constructor.apply(this, arguments);
  }

  ViewMeasurementHistoryCtrl.prototype.initialize = function(options) {
    var productId, products;
    if (options == null) {
      options = {};
    }
    this.show(this.parent().getLLoadingView());
    productId = this.getParams();
    products = [];
    return this._showView(productId[0]);
  };

  ViewMeasurementHistoryCtrl.prototype._showView = function(model) {
    return this.show(new MeasurementHistoryView({
      id: model
    }));
  };

  return ViewMeasurementHistoryCtrl;

})(Ajency.RegionController);
