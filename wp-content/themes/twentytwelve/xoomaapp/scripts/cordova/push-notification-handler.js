var Push, onNotificationAPN, onNotificationGCM;

onNotificationGCM = function(e) {
  console.log('Received notification for Android');
  console.log(e);
  if (e.event === 'message') {
    if (!e.foreground) {
      return App.navigate('#settings', true);
    }
  }
};

onNotificationAPN = function(e) {
  console.log('Received notification for iOS');
  return console.log(e);
};

Push = {
  register: function() {
    var defer;
    defer = $.Deferred();
    parsePlugin.initialize(APP_ID, CLIENT_KEY, function() {
      return defer.resolve(Push.bindPushNotificationEvents());
    }, function(e) {
      return defer.reject(e);
    });
    return defer.promise();
  },
  bindPushNotificationEvents: function() {
    this.pushNotification = window.plugins.pushNotification;
    if (CordovaApp.isPlatformAndroid()) {
      return this.bindGCMEventListener();
    } else if (CordovaApp.isPlatformIOS()) {
      return this.bindAPNSEventListener();
    } else {
      return console.log("Unknown Platform");
    }
  },
  bindGCMEventListener: function() {
    return this.pushNotification.register(function(result) {
      return console.log('Android event success');
    }, function(error) {
      return console.log('Android event error');
    }, {
      "senderID": "dummy",
      "ecb": "onNotificationGCM"
    });
  },
  bindAPNSEventListener: function() {
    return this.pushNotification.register(function(result) {
      return console.log('iOS event success');
    }, function(error) {
      return console.log('iOS event error');
    }, {
      "badge": "true",
      "sound": "true",
      "alert": "true",
      "ecb": "onNotificationAPN"
    });
  }
};
