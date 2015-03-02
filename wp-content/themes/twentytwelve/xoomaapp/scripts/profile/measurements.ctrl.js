var ProfileMeasurementsView,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

ProfileMeasurementsView = (function(_super) {
  __extends(ProfileMeasurementsView, _super);

  function ProfileMeasurementsView() {
    this.valueOutput = __bind(this.valueOutput, this);
    this.errorHandler = __bind(this.errorHandler, this);
    this.successHandler = __bind(this.successHandler, this);
    this.onFormSubmit = __bind(this.onFormSubmit, this);
    return ProfileMeasurementsView.__super__.constructor.apply(this, arguments);
  }

  ProfileMeasurementsView.prototype.template = '#profile-measurements-template';

  ProfileMeasurementsView.prototype.className = 'animated fadeIn';

  ProfileMeasurementsView.prototype.ui = {
    form: '#add_measurements',
    rangeSliders: '[data-rangeslider]',
    responseMessage: '.aj-response-message',
    link: '.link',
    inpt_el: '.inpt_el',
    update: '.update'
  };

  ProfileMeasurementsView.prototype.behaviors = {
    FormBehavior: {
      behaviorClass: Ajency.FormBehavior
    }
  };

  ProfileMeasurementsView.prototype.initialize = function() {
    $(document).on('keyup', _.bind(this.keyup, this));
    return $(document).on('keypress', _.bind(this.keydown, this));
  };

  ProfileMeasurementsView.prototype.events = {
    'change @ui.rangeSliders': function(e) {
      return this.valueOutput(e.currentTarget);
    },
    'change #height': function(e) {
      var cms, ftcm, inchcm, temparr;
      temparr = $(e.target).val().split('.');
      if (temparr.length === 1) {
        temparr.push(0);
      }
      $('.heightcms').text(temparr[0] + "'" + temparr[1] + '"');
      ftcm = 30.48 * parseFloat(temparr[0]);
      inchcm = 2.54 * parseFloat(temparr[1]);
      cms = parseFloat(ftcm) + parseFloat(inchcm);
      return $('.convertheight').text(cms.toFixed(2) + ' Cms');
    },
    'change #weight': function(e) {
      var onepound, pounds, xpound;
      pounds = $(e.target).val();
      onepound = 0.4535;
      xpound = parseFloat(onepound) * parseFloat(pounds);
      $('.convertweight').text(xpound.toFixed(2) + ' Kgs');
      return $('.weightcms').text($(e.target).val());
    }
  };

  ProfileMeasurementsView.prototype.keydown = function(e) {
    var inputVal;
    if (e.charCode === 13) {
      $('#mcttCloseButton').trigger('click');
    }
    if (e.charCode === 46) {
      inputVal = $(e.target).val().split('.').length;
      if (parseInt(inputVal) >= 2) {
        return false;
      }
    }
    return e.charCode >= 48 && e.charCode <= 57 || e.charCode === 46 || e.charCode === 8;
  };

  ProfileMeasurementsView.prototype.keyup = function(e) {
    return this.measurements[e.target.id] = $('#' + e.target.id).val();
  };

  ProfileMeasurementsView.prototype.onShow = function() {
    var date, height, i, obj, select, state, timezone, weight;
    select = document.getElementById('weight');
    select.options.length = 0;
    i = 30;
    while (i <= 500) {
      select.options.add(new Option(i, i));
      i++;
    }
    if (App.currentUser.get('measurements') !== void 0) {
      height = App.currentUser.get('measurements').height;
      weight = App.currentUser.get('measurements').weight;
      $('#height option[value="' + height + '"]').prop("selected", true);
      $('#weight option[value="' + weight + '"]').prop("selected", true);
    }
    $('#height').trigger("change");
    $('#weight').trigger("change");
    App.trigger('cordova:hide:splash:screen');
    timezone = App.currentUser.get('timezone');
    $('#date_field').val(moment().zone(timezone).format('YYYY-MM-DD'));
    date = moment(App.currentUser.get('user_registered')).format('YYYY-MM-DD');
    if (!window.isWebView()) {
      $('#update').val('TODAY');
      $('#update').datepicker({
        dateFormat: 'yy-mm-dd',
        changeYear: true,
        changeMonth: true,
        maxDate: new Date(),
        minDate: new Date(date),
        onSelect: function(dateText, inst) {
          return $('#date_field').val(dateText);
        }
      });
    }
    if (window.isWebView()) {
      $('#update').val(moment().format('YYYY-MM-DD'));
      $('#update').attr({
        max: moment().format('YYYY-MM-DD'),
        min: date
      }).change(function() {
        return $('#date_field').val($('#update').val());
      });
    }
    this.ui.rangeSliders.each((function(_this) {
      return function(index, ele) {
        return _this.valueOutput(ele);
      };
    })(this));
    this.ui.rangeSliders.rangeslider({
      polyfill: false
    });
    this.measurements = {
      'arm': '',
      'chest': '',
      'neck': '',
      'waist': '',
      'abdomen': '',
      'midcalf': '',
      'thigh': '',
      'hips': ''
    };
    if (App.currentUser.get('measurements') !== void 0) {
      obj = App.currentUser.get('measurements');
      this.measurements.arm = obj.arm;
      this.measurements.neck = obj.neck;
      this.measurements.waist = obj.waist;
      this.measurements.abdomen = obj.abdomen;
      this.measurements.midcalf = obj.midcalf;
      this.measurements.thigh = obj.thigh;
      this.measurements.hips = obj.hips;
    }
    state = App.currentUser.get('state');
    if (state === '/home') {
      $('.measurements_update').removeClass('hidden');
      $('#measurement').parent().removeClass('done');
      $('#measurement').parent().addClass('selected');
      $('#measurement').parent().siblings().removeClass('selected');
      $('#measurement').parent().prevAll().addClass('done');
      return $('#measurement').parent().nextAll().addClass('done');
    }
  };

  ProfileMeasurementsView.prototype.onFormSubmit = function(_formData) {
    var count, formdata;
    $('.loadingconusme').html('<img src="' + _SITEURL + '/wp-content/themes/twentytwelve/xoomaapp/images/ajax-loader.gif" width="40px">');
    count = 0;
    $.each(this.measurements, function(ind, val) {
      if ((!($.isNumeric(val))) && val !== "" && ind !== 'date') {
        count++;
        $('.loadingconusme').html("");
        window.removeMsg();
        $('.aj-response-message').addClass('alert alert-danger').text("Measurement entered for part of the body is incorrect");
        $('html, body').animate({
          scrollTop: 0
        }, 'slow');
      }
    });
    if (count === 0) {
      this.measurements['weight'] = $('#weight').val();
      this.measurements['height'] = $('#height').val();
      this.measurements['date'] = $('#date_field').val();
      formdata = this.measurements;
      return this.model.saveMeasurements(formdata).done(this.successHandler).fail(this.errorHandler);
    }
  };

  ProfileMeasurementsView.prototype.successHandler = function(response, status, xhr) {
    var state;
    $('.loadingconusme').html("");
    if (xhr.status === 404) {
      window.removeMsg();
      this.ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be saved due to some error!");
      return $('html, body').animate({
        scrollTop: 0
      }, 'slow');
    } else {
      state = App.currentUser.get('state');
      if (state === '/home') {
        window.removeMsg();
        this.ui.responseMessage.addClass('alert alert-success').text("Measurements successfully updated!");
        return $('html, body').animate({
          scrollTop: 0
        }, 'slow');
      } else {
        App.currentUser.set('state', '/profile/my-products');
        return App.navigate('#' + App.currentUser.get('state'), true);
      }
    }
  };

  ProfileMeasurementsView.prototype.errorHandler = function(error) {
    $('.loadingconusme').html("");
    window.removeMsg();
    this.ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be saved due to some error!");
    return $('html, body').animate({
      scrollTop: 0
    }, 'slow');
  };

  ProfileMeasurementsView.prototype.valueOutput = function(element) {
    var cms, ftcm, inchcm, onepound, pounds, temparr, xpound;
    if (element.id === 'height') {
      temparr = $(element).val().split('.');
      if (temparr.length === 1) {
        temparr.push(0);
      }
      $('.heightcms').text(temparr[0] + "'" + temparr[1] + '"');
      ftcm = 30.48 * parseFloat(temparr[0]);
      inchcm = 2.54 * parseFloat(temparr[1]);
      cms = parseFloat(ftcm) + parseFloat(inchcm);
      return $('.convertheight').text(cms.toFixed(2) + ' Cms');
    } else {
      pounds = $(element).val();
      onepound = 0.4535;
      xpound = parseFloat(onepound) * parseFloat(pounds);
      $('.convertweight').text(xpound.toFixed(2) + ' Kgs');
      return $('.weightcms').text($(element).val());
    }
  };

  return ProfileMeasurementsView;

})(Marionette.ItemView);

App.UserMeasurementCtrl = (function(_super) {
  __extends(UserMeasurementCtrl, _super);

  function UserMeasurementCtrl() {
    this.successHandler = __bind(this.successHandler, this);
    this._showView = __bind(this._showView, this);
    return UserMeasurementCtrl.__super__.constructor.apply(this, arguments);
  }

  UserMeasurementCtrl.prototype.initialize = function(options) {
    var xhr;
    this.show(this.parent().parent().getLLoadingView());
    xhr = this._get_measurement_details();
    return xhr.done(this._showView).fail(this.errorHandler);
  };

  UserMeasurementCtrl.prototype._showView = function() {
    return this.show(new ProfileMeasurementsView({
      model: App.currentUser
    }));
  };

  UserMeasurementCtrl.prototype._get_measurement_details = function() {
    return $.ajax({
      method: 'GET',
      url: "" + _SITEURL + "/wp-json/users/" + (App.currentUser.get('ID')) + "/measurements",
      success: this.successHandler
    });
  };

  UserMeasurementCtrl.prototype.errorHandler = function(error) {
    this.region = new Marionette.Region({
      el: '#nofound-template'
    });
    return new Ajency.HTTPRequestCtrl({
      region: this.region
    });
  };

  UserMeasurementCtrl.prototype.successHandler = function(response, status) {
    var deferred;
    App.currentUser.set('measurements', response.response);
    deferred = Marionette.Deferred();
    deferred.resolve(true);
    return deferred.promise();
  };

  return UserMeasurementCtrl;

})(Ajency.RegionController);
