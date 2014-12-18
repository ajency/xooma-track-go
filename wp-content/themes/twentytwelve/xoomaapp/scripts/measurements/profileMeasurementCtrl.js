(function() {
  var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  App.ProfileMeasurementCtrl = (function(_super) {
    __extends(ProfileMeasurementCtrl, _super);

    function ProfileMeasurementCtrl() {
      this.successHandler = __bind(this.successHandler, this);
      return ProfileMeasurementCtrl.__super__.constructor.apply(this, arguments);
    }

    ProfileMeasurementCtrl.prototype.initialize = function(options) {
      var xhr;
      xhr = this._get_measurement_details();
      return xhr.done(this._showView).fail(this.errorHandler);
    };

    ProfileMeasurementCtrl.prototype._showView = function() {
      return this.show(new ProfileMeasurementsView({
        model: App.currentUser
      }));
    };

    ProfileMeasurementCtrl.prototype._get_measurement_details = function() {
      var deferred;
      if (!App.currentUser.has('measurements')) {
        return $.ajax({
          method: 'GET',
          url: "" + _SITEURL + "/wp-json/users/128/measurements",
          success: this.successHandler
        });
      } else {
        deferred = Marionette.Deferred;
        return deferred.resolve();
      }
    };

    ProfileMeasurementCtrl.prototype.errorHandler = function(error) {
      return this.show(new Ajency.HTTPRequestFailView);
    };

    ProfileMeasurementCtrl.prototype.successHandler = function(response, status) {
      return App.currentUser.set('measurements', response);
    };

    return ProfileMeasurementCtrl;

  })(Marionette.RegionController);

}).call(this);
