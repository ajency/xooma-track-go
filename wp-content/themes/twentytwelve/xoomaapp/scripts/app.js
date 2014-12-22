(function() {
  (function() {
    return document.addEventListener("deviceready", (function() {
      var notificationIdAndBadgeValue;
      notificationIdAndBadgeValue = [];
      cordova.plugins.notification.badge;
      _.enableCordovaBackbuttonNavigation();
      App.state('login').state('xooma', {
        url: '/'
      });
      App.addInitializer(function() {
        Backbone.history.start();
        _.cordovaHideSplashscreen();
        return App.currentUser.on('user:auth:success', function() {
          return App.navigate(App.currentUser.get('state'), true);
        });
      });
      App.on('fb:status:connected', function() {
        if (!App.currentUser.hasProfilePicture()) {
          return App.currentUser.getFacebookPicture();
        }
      });
      return App.start();
    }), false);
  }).call();

}).call(this);
