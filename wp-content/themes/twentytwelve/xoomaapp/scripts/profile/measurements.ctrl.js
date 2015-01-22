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
    inpt_el: '.inpt_el'
  };

  ProfileMeasurementsView.prototype.behaviors = {
    FormBehavior: {
      behaviorClass: Ajency.FormBehavior
    }
  };

  ProfileMeasurementsView.prototype.initialize = function() {
    return $(document).on('keyup', _.bind(this.keyup, this));
  };

  ProfileMeasurementsView.prototype.events = {
    'change @ui.rangeSliders': function(e) {
      return this.valueOutput(e.currentTarget);
    }
  };

  ProfileMeasurementsView.prototype.keyup = function(e) {
    var inputVal;
    console.log(e.target.id);
    console.log(this.measurements[e.target.id] = $('#' + e.target.id).val());
    if (e.charCode === 46) {
      console.log(inputVal = $(e.target).val().split('.').length);
      if (parseInt(inputVal) >= 2) {
        return false;
      }
    }
    return e.charCode >= 48 && e.charCode <= 57 || e.charCode === 46 || e.charCode === 44;
  };

  ProfileMeasurementsView.prototype.onShow = function() {
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
    return console.log(this.view);
  };

  ProfileMeasurementsView.prototype.onFormSubmit = function(_formData) {
    var formdata;
    console.log(this.measurements['weight'] = $('#weight').val());
    this.measurements['height'] = $('#height').val();
    this.measurements['date_field'] = $('#date_field').val();
    console.log(formdata = $.param(this.measurements));
    return this.model.saveMeasurements(formdata).done(this.successHandler).fail(this.errorHandler);
  };

  ProfileMeasurementsView.prototype.successHandler = function(response, status, xhr) {
    var state;
    if (xhr.status === 404) {
      this.ui.responseMessage.text("Something went wrong");
      return $('html, body').animate({
        scrollTop: 0
      }, 'slow');
    } else {
      state = App.currentUser.get('state');
      if (state === '/home') {
        return this.ui.responseMessage.text("profile successfully updated");
      } else {
        App.currentUser.set('state', '/profile/my-products');
        return App.navigate('#' + App.currentUser.get('state'), true);
      }
    }
  };

  ProfileMeasurementsView.prototype.errorHandler = function(error) {
    this.ui.responseMessage.text("Something went wrong");
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
    xhr = this._get_measurement_details();
    return xhr.done(this._showView).fail(this.errorHandler);
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
    return App.currentUser.set('measurements', response.response);
  };

  return UserMeasurementCtrl;

})(Ajency.RegionController);
