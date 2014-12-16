// Generated by CoffeeScript 1.7.1
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

App.ProfileMeasurementCtrl = (function(_super) {
  __extends(ProfileMeasurementCtrl, _super);

  function ProfileMeasurementCtrl() {
    return ProfileMeasurementCtrl.__super__.constructor.apply(this, arguments);
  }

  ProfileMeasurementCtrl.prototype.initialize = function(options) {
    this.user = this._get_measurement_details();
    return this.show(new ProfileMeasurementsView);
  };

  ProfileMeasurementCtrl.prototype._get_measurement_details = function() {
    return $.ajax({
      method: 'GET',
      url: _SITEURL + '/wp-json/measurements/2',
      data: '',
      success: function(response) {},
      error: function(error) {
        return $('.response_msg').text("Something went wrong");
      }
    });
  };

  return ProfileMeasurementCtrl;

})(Marionette.RegionController);
