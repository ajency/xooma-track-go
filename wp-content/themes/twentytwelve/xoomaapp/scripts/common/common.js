(function() {
  App.LoginCtrl = Ajency.LoginCtrl;

  App.NothingFoundCtrl = Ajency.NothingFoundCtrl;

  _.extend(Ajency.CurrentUser.prototype, {
    saveMeasurements: function(measurements) {
      var _successHandler;
      _successHandler = (function(_this) {
        return function(resp) {
          return _this.set('measurements', measurements);
        };
      })(this);
      return $.ajax({
        method: 'PUT',
        url: "" + _SITEURL + "/wp-json/users/" + (App.currentUser.get('ID')) + "/measurements",
        data: measurements,
        success: _successHandler
      });
    }
  });

}).call(this);
