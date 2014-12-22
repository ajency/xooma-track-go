(function() {
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
      this.model.saveMeasurements(_formData).done(this.successHandler).fail(this.errorHandler);
      return false;
    };

    ProfileMeasurementsView.prototype.successHandler = function(response, status) {
      if (status === 404) {
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

}).call(this);
