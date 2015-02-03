var CordovaApp;

CordovaApp = {
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
  facebookLogout: function() {
    var defer;
    defer = $.Deferred();
    facebookConnectPlugin.logout(function(success) {
      return defer.resolve(success);
    }, function(error) {
      console.log('facebookLogout error');
      console.log(error);
      return defer.resolve(error);
    });
    return defer.promise();
  }
};
