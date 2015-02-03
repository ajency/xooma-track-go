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
  }
});
