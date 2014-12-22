(function() {
  var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  App.ProfileMeasurementCtrl = (function(_super) {
    __extends(ProfileMeasurementCtrl, _super);

    function ProfileMeasurementCtrl() {
      this.successHandler = __bind(this.successHandler, this);
      this._showView = __bind(this._showView, this);
      return ProfileMeasurementCtrl.__super__.constructor.apply(this, arguments);
    }

    ProfileMeasurementCtrl.prototype.initialize = function(options) {
      var xhr;
      xhr = this._get_measurement_details();
      return xhr.done(this._showView).fail(this._showView);
    };

    ProfileMeasurementCtrl.prototype._showView = function() {
      return this.show(new App.ProfileMeasurementsView({
        model: App.currentUser
      }));
    };

    ProfileMeasurementCtrl.prototype._get_measurement_details = function() {
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

    ProfileMeasurementCtrl.prototype.errorHandler = function(error) {
      this.region = new Marionette.Region({
        el: '#nofound-template'
      });
      return new Ajency.HTTPRequestCtrl({
        region: this.region
      });
    };

    ProfileMeasurementCtrl.prototype.successHandler = function(response, status) {
      return App.currentUser.set('measurements', response.response);
    };

    return ProfileMeasurementCtrl;

  })(Marionette.RegionController);

}).call(this);
