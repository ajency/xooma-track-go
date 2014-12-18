_.mixin({
  cordovaLocalStorage: function() {
    return _.localStorage = window.localStorage;
  },
  setNotificationBadgeNumber: function(Value) {
    return _.localStorage.setItem("notification_value", JSON.stringify(Value));
  },
  getNotificationBadgeNumber: function() {
    return _.localStorage.getItem("notification_value");
  }
});
