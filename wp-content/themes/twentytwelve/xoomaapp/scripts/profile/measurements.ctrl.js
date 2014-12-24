var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

App.ProfileMeasurementsView = (function(_super) {
  __extends(ProfileMeasurementsView, _super);

  function ProfileMeasurementsView() {
    this.onPauseSessionClick = __bind(this.onPauseSessionClick, this);
    this.valueOutput = __bind(this.valueOutput, this);
    this.errorHandler = __bind(this.errorHandler, this);
    this.successHandler = __bind(this.successHandler, this);
    this.formSubmitHandler = __bind(this.formSubmitHandler, this);
    return ProfileMeasurementsView.__super__.constructor.apply(this, arguments);
  }

  ProfileMeasurementsView.prototype.template = '#profile-measurements-template';

  ProfileMeasurementsView.prototype.className = 'animated fadeIn';

  ProfileMeasurementsView.prototype.ui = {
    popoverElements: '.popover-element',
    form: '#add_measurements',
    rangeSliders: '[data-rangeslider]',
    responseMessage: '.response_msg'
  };

  ProfileMeasurementsView.prototype.events = {
    'change @ui.rangeSliders': function(e) {
      return this.valueOutput(e.currentTarget);
    }
  };

  ProfileMeasurementsView.prototype.onShow = function() {
    $('#measurement').parent().addClass('active');
    $('#product').bind('click', this.disabler);
    $('#product').css('cursor', 'default');
    this.ui.popoverElements.popover({
      html: true
    });
    this.ui.rangeSliders.each((function(_this) {
      return function(index, ele) {
        return _this.valueOutput(ele);
      };
    })(this));
    this.ui.rangeSliders.rangeslider({
      polyfill: false
    });
    this.ui.form.validate({
      submitHandler: this.formSubmitHandler
    });
    return this.cordovaEventsForModuleDescriptionView();
  };

  ProfileMeasurementsView.prototype.disabler = function(e) {
    e.preventDefault();
    return false;
  };

  ProfileMeasurementsView.prototype.formSubmitHandler = function(form) {
    var _formData;
    _formData = $('#add_measurements').serialize();
    return this.model.saveMeasurements(_formData).done(this.successHandler)["return"](false);
  };

  ProfileMeasurementsView.prototype.successHandler = function(response, status, responseCode) {
    if (responseCode.status === 404) {
      return this.ui.responseMessage.text("Something went wrong");
    } else {
      return this.ui.responseMessage.text("User details saved successfully");
    }
  };

  ProfileMeasurementsView.prototype.errorHandler = function(error) {
    return this.ui.responseMessage.text("Something went wrong");
  };

  ProfileMeasurementsView.prototype.valueOutput = function(element) {
    return $(element).parent().find("output").html($(element).val());
  };

  ProfileMeasurementsView.prototype.onPauseSessionClick = function() {
    console.log('Invoked onPauseSessionClick');
    Backbone.history.history.back();
    return document.removeEventListener("backbutton", this.onPauseSessionClick, false);
  };

  ProfileMeasurementsView.prototype.cordovaEventsForModuleDescriptionView = function() {
    navigator.app.overrideBackbutton(true);
    document.addEventListener("backbutton", this.onPauseSessionClick, false);
    return document.addEventListener("pause", this.onPauseSessionClick, false);
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
    if (_.onlineStatus() === false) {
      return window.plugins.toast.showLongBottom("Please check your internet connection.");
    } else {
      xhr = this._get_measurement_details();
      return xhr.done(this._showView);
    }
  };

  UserMeasurementCtrl.prototype._showView = function() {
    return this.show(new App.ProfileMeasurementsView({
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
    return App.currentUser.set('measurements', response.response);
  };

  return UserMeasurementCtrl;

})(Ajency.RegionController);
