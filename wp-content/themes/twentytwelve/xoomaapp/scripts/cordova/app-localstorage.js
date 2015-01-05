_.mixin({
  setUserData: function(userData) {
    return window.localStorage.setItem("user_data", JSON.stringify(userData));
  },
  getUserData: function() {
    return JSON.parse(window.localStorage.getItem("user_data"));
  },
  setNotificationBadgeNumber: function(Value) {
    return window.localStorage.setItem("notification_value", JSON.stringify(Value));
  },
  getNotificationBadgeNumber: function() {
    return window.localStorage.getItem("notification_value");
  }
});
