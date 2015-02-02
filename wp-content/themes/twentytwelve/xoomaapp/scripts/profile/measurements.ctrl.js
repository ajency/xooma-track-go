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
    }
  };

  ProfileMeasurementsView.prototype.keydown = function(e) {
    var inputVal;
    if (e.charCode === 46) {
      inputVal = $(e.target).val().split('.').length;
      if (parseInt(inputVal) >= 2) {
        return false;
      }
    }
    return e.charCode >= 48 && e.charCode <= 57 || e.charCode === 46 || e.charCode === 44;
  };

  ProfileMeasurementsView.prototype.keyup = function(e) {
    return this.measurements[e.target.id] = $('#' + e.target.id).val();
  };

  ProfileMeasurementsView.prototype.onShow = function() {
    var date, state;
    $('#update').val(moment().format('YYYY-MM-DD'));
    date = moment(App.currentUser.get('user_registered')).format('YYYY-MM-DD');
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
    var formdata;
    this.measurements['weight'] = $('#weight').val();
    this.measurements['height'] = $('#height').val();
    this.measurements['date'] = $('#date_field').val();
    formdata = this.measurements;
    return this.model.saveMeasurements(formdata).done(this.successHandler).fail(this.errorHandler);
  };

  ProfileMeasurementsView.prototype.successHandler = function(response, status, xhr) {
    var state;
    if (xhr.status === 404) {
      this.ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be saved due to some error!");
      return $('html, body').animate({
        scrollTop: 0
      }, 'slow');
    } else {
      state = App.currentUser.get('state');
      if (state === '/home') {
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
    this.ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be saved due to some error!");
    return $('html, body').animate({
      scrollTop: 0
    }, 'slow');
  };

  ProfileMeasurementsView.prototype.valueOutput = function(element) {
    return $(element).parent().find("output").html($(element).val());
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
    if (_.isDeviceOnline()) {
      this.show(this.parent().parent().getLLoadingView());
      xhr = this._get_measurement_details();
      return xhr.done(this._showView).fail(this.errorHandler);
    } else {
      return window.plugins.toast.showLongBottom("Please check your internet connection.");
    }
  };

  UserMeasurementCtrl.prototype._showView = function() {
    return this.show(new ProfileMeasurementsView({
      model: App.currentUser
    }));
  };

  UserMeasurementCtrl.prototype._get_measurement_details = function() {
    var deferred;
    if (!App.currentUser.has('measurements')) {
      return $.ajax({
        method: 'GET',
        url: "" + _SITEURL + "/wp-json/users/" + (App.currentUser.get('ID')) + "/measurements",
        success: this.successHandler
      });
    } else {
      deferred = Marionette.Deferred();
      deferred.resolve(true);
      return deferred.promise();
    }
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
