_.mixin({
  setUserData: function(userData) {
    return window.localStorage.setItem("user_data", JSON.stringify(userData));
  },
  getUserData: function() {
    return JSON.parse(window.localStorage.getItem("user_data"));
  }
});
