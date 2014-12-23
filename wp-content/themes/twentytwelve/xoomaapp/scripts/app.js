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
      App.onBeforeStart = function() {
        App.currentUser.set(userData);
        if (!App.currentUser.isLoggedIn()) {
          return App.currentUser.set('caps', notLoggedInCaps);
        }
      };
      App.currentUser.on('user:auth:success', function() {
        return App.navigate(App.currentUser.get('state'), true);
      });
      App.currentUser.on('user:logged:out', function() {
        App.currentUser.clear({
          slient: true
        });
        App.currentUser.set('caps', notLoggedInCaps);
        return App.navigate('/login', true);
      });
      App.addInitializer(function() {
        _.cordovaHideSplashscreen();
        return Backbone.history.start();
      });
      return App.start();
    }), false);
  }).call();

}).call(this);
