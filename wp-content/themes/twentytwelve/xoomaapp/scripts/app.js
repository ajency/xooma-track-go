(function() {
  return document.addEventListener("deviceready", (function() {
    var notificationIdAndBadgeValue;
    notificationIdAndBadgeValue = [];
    cordova.plugins.notification.badge;
    _.enableCordovaBackbuttonNavigation();
    App.state('login').state('xooma', {
      url: '/'
    }).state('AddProducts', {
      url: '/products',
      parent: 'xooma'
    }).state('UserProductList', {
      url: '/my-products',
      parent: 'profile'
    }).state('notificationDisplay', {
      url: '/notification-display'
    }).state('notification', {
      url: '/notification-info'
    });
    App.onBeforeStart = function() {
      App.currentUser.set(userData);
      if (!App.currentUser.isLoggedIn()) {
        return App.currentUser.setNotLoggedInCapabilities();
      }
    };
    App.currentUser.on('user:auth:success', function() {
      return App.navigate(App.currentUser.get('state'), true);
    });
    App.currentUser.on('user:logged:out', function() {
      App.navigate('/login', true);
      return App.state('settings', {
        url: '/settings',
        parent: 'xooma'
      }).state('home', {
        url: '/home'
      }).state('UserProductList', {
        url: '/my-products',
        parent: 'profile'
      }).state('AddProducts', {
        url: '/products',
        parent: 'xooma'
      });
    });
    App.addInitializer(function() {
      Backbone.history.start();
      _.cordovaHideSplashscreen();
      return window.plugin.notification.local.onclick = function(id, state, action, json) {
        window.plugin.notification.local.clear(id);
        if (action === "Action 1") {
          window.plugin.notification.local.cancel(id);
          window.plugin.notification.local.add({
            id: '200',
            message: "Great job! You have consumed your supplement"
          });
        }
      };
    });
    App.on('2fb:status:connected', function() {
      if (!App.currentUser.hasProfilePicture()) {
        return App.currentUser.getFacebookPicture();
      }
    });
    return App.start();
  }), false);
}).call();
