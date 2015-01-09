var Push, onNotificationGCM;

onNotificationGCM = function(e) {
  console.log('Received notification');
  return console.log(e);
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
  registerIOS: function() {}
};
