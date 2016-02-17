var Push, cordovaPushNavigation, onNotificationAPN, onNotificationGCM;

cordovaPushNavigation = function(data) {
  var homeDate;
  switch (data.type) {
    case 'consume':
      homeDate = App.currentUser.get('homeDate');
      if (data.title.toUpperCase() === 'X2O') {
        return App.navigate("#/products/" + data.productId + "/bmi/" + homeDate, true);
      } else {
        return App.navigate("#/products/" + data.productId + "/consume/" + homeDate, true);
      }
      break;
    case 'inventory':
      return App.navigate("#/inventory/" + data.productId + "/edit", true);
    case 'New Product':
      return App.navigate('#products', true);
  }
};

onNotificationGCM = function(e) {
  var data, payload;
  console.log('Received notification for Android');
  console.log(e);
  if (e.event === 'message') {
    if (!e.foreground) {
      payload = e.payload.data;
      data = {
        title: payload.header,
        alert: payload.message,
        productId: payload.productId,
        type: payload.type
      };
      return cordovaPushNavigation(data);
    }
  }
};

onNotificationAPN = function(e) {
  console.log('Received notification for iOS');
  console.log(e);
  if (e.foreground === "0") {
    return cordovaPushNavigation(e);
  }
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
