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
  updateXoomaMessages: function() {
    var date, difference, message_set_date, today, update;
    update = false;
    date = CordovaStorage.getMessages().date;
    if (_.isNull(date)) {
      update = true;
    } else {
      today = moment().format('DD/MM/YYYY');
      today = moment(today, 'DD/MM/YYYY');
      message_set_date = moment(date, 'DD/MM/YYYY');
      difference = today.diff(message_set_date, 'days');
      if (difference > 7) {
        update = true;
      }
    }
    if (update) {
      return $.get(APIURL + "/messages", function(messages) {
        return console.log('Xooma Messages Updated');
      });
    }
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
