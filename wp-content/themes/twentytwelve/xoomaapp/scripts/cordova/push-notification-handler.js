var Push, onNotificationAPN, onNotificationGCM;

onNotificationGCM = function(e) {
  console.log('Received notification for Android');
  return console.log(e);
};

onNotificationAPN = function(e) {
  console.log('Received notification for iOS');
  return alert(JSON.stringify(e));
};

Push = {
  initialize: function() {
    this.pushNotification = window.plugins.pushNotification;
    if (_.isPlatformAndroid()) {
      return this.registerAndroid();
    } else if (_.isPlatformIOS()) {
      return this.registerIOS();
    }
  },
  registerAndroid: function() {
    return this.pushNotification.register(function(result) {
      return console.log('registerAndroid success');
    }, function(error) {
      return console.log('registerAndroid error');
    }, {
      "senderID": "dummy",
      "ecb": "onNotificationGCM"
    });
  },
  registerIOS: function() {
    return this.pushNotification.register(function(result) {
      return console.log('registerIOS success');
    }, function(error) {
      return console.log('registerAndroid error');
    }, {
      "badge": "true",
      "sound": "true",
      "alert": "true",
      "ecb": "onNotificationAPN"
    });
  }
};
