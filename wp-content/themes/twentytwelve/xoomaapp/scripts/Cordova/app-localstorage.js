_.mixin({
  localStorage: function() {
    return window.localStorage;
  },
  setNotificationBadgeNumber: function(Value) {
    return this.localStorage().setItem("notification_value", JSON.stringify(Value));
  },
  getNotificationBadgeNumber: function() {
    return this.localStorage().getItem("notification_value");
  }
});
