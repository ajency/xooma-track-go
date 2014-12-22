(function() {
  _.mixin({
    cordovaHideSplashscreen: function() {
      return navigator.splashscreen.hide();
    },
    enableCordovaBackbuttonNavigation: function() {
      navigator.app.overrideBackbutton(true);
      return document.addEventListener("backbutton", _.onDeviceBackButtonClick, false);
    },
    disableCordovaBackbuttonNavigation: function() {
      return navigator.app.overrideBackbutton(false);
    },
    onDeviceBackButtonClick: function() {
      var currentRoute;
      currentRoute = App.getCurrentRoute();
      console.log('Fired cordova back button event for ' + currentRoute);
      if (currentRoute === 'login' || currentRoute === 'profile/personal-info') {
        navigator.app.exitApp();
      } else {
        Backbone.history.history.back();
      }
      return _.removeCordovaBackbuttonEventListener();
    },
    removeCordovaBackbuttonEventListener: function() {
      return document.removeEventListener("backbutton", _.onDeviceBackButtonClick, false);
    },
    onlineStatus: function() {
      if (navigator.connection.type === Connection.NONE) {
        return false;
      } else {
        return true;
      }
    }
  });

}).call(this);
