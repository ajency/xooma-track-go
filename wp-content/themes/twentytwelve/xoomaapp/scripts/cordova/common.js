_.mixin({
  isDeviceOnline: function() {
    if (navigator.connection.type === Connection.NONE) {
      return false;
    } else {
      return true;
    }
  },
  isPlatformAndroid: function() {
    if (device.platform.toLowerCase() === "android") {
      return true;
    } else {
      return false;
    }
  },
  isPlatformIOS: function() {
    if (device.platform.toLowerCase() === "ios") {
      return true;
    } else {
      return false;
    }
  },
  hideSplashscreen: function() {
    return setTimeout(function() {
      return navigator.splashscreen.hide();
    }, 500);
  },
  enableDeviceBackNavigation: function() {
    var onDeviceBackClick;
    onDeviceBackClick = function() {
      var currentRoute;
      currentRoute = App.getCurrentRoute();
      console.log('Fired cordova back button event for ' + currentRoute);
      if (currentRoute === 'login' || currentRoute === 'profile/personal-info') {
        if (navigator.app) {
          navigator.app.exitApp();
        }
      } else {
        Backbone.history.history.back();
      }
      return document.removeEventListener("backbutton", onDeviceBackClick, false);
    };
    if (navigator.app) {
      navigator.app.overrideBackbutton(true);
    }
    return document.addEventListener("backbutton", onDeviceBackClick, false);
  },
  disableDeviceBackNavigation: function() {
    if (navigator.app) {
      return navigator.app.overrideBackbutton(false);
    }
  }
});
