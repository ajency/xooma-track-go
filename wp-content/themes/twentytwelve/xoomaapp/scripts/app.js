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
        var badge, badgeValue, badgeValues, i, ids, option, setbadgeValue, value, _i, _ref;
        window.plugin.notification.local.clear(id);
        if (action === "Action 1") {
          window.plugin.notification.local.cancel(id);
          window.plugin.notification.local.add({
            id: '200',
            message: "Great job! You have consumed your supplement"
          });
        } else {
          setbadgeValue = 0;
          ids = [];
          badgeValues = [];
          value = _.getNotificationBadgeNumber();
          option = JSON.parse(value);
          for (i = _i = 0, _ref = option.length - 1; _i <= _ref; i = _i += 1) {
            if (id === option[i].ids) {
              badgeValue = 0;
              badge = {
                badge: badgeValue
              };
              notificationIdAndBadgeValue.push({
                ids: id,
                badgeValues: badgeValue
              });
              _.setNotificationBadgeNumber(notificationIdAndBadgeValue);
            }
            if (id === '4') {
              badgeValue = 0;
              badge = {
                badge: setbadgeValue
              };
              window.plugin.notification.local.setDefaults(badge);
            }
          }
          App.navigate("/notification-info", true);
          $('#time_for_notification').text(JSON.parse(json).date);
          $('#Message_for_notification').text(JSON.parse(json).test);
          if (badgeValue !== 0) {
            if (id === '1') {
              badgeValue = 0;
              badge = {
                badge: setbadgeValue
              };
              return window.plugin.notification.local.setDefaults(badge);
            } else if (id === '2') {
              badgeValue = 0;
              badge = {
                badge: setbadgeValue
              };
              return window.plugin.notification.local.setDefaults(badge);
            } else if (id === '3') {
              badgeValue = 0;
              badge = {
                badge: setbadgeValue
              };
              return window.plugin.notification.local.setDefaults(badge);
            } else if (id === '4') {
              badgeValue = 0;
              badge = {
                badge: setbadgeValue
              };
              return window.plugin.notification.local.setDefaults(badge);
            }
          }
        }
      };
    });
    App.on('fb:status:connected', function() {
      if (!App.currentUser.hasProfilePicture()) {
        return App.currentUser.getFacebookPicture();
      }
    });
    return App.start();
  }), false);
}).call();
