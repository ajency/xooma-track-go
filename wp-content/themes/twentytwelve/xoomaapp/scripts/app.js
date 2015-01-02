(function() {
  return document.addEventListener("deviceready", (function() {
    var notificationIdAndBadgeValue;
    notificationIdAndBadgeValue = [];
    cordova.plugins.notification.badge;
    _.enableCordovaBackbuttonNavigation();
    App.state('login').state('xooma', {
      url: '/'
    }).state('home', {
      url: '/home',
      parent: 'xooma',
      sections: {
        'x2o': {
          ctrl: 'HomeX2OCtrl'
        },
        'other-products': {
          ctrl: 'HomeOtherProductsCtrl'
        }
      }
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
      var current_user_data;
      current_user_data = App.currentUser.toJSON();
      _.setUserData(current_user_data);
      return App.navigate('#' + App.currentUser.get('state'), true);
    });
    App.currentUser.on('user:logged:out', function() {
      var userData;
      App.navigate('/login', true);
      window.localStorage.removeItem("user_data");
      userData = {};
      return App.state('settings', {
        url: '/settings',
        parent: 'xooma'
      }).state('home', {
        url: '/home',
        parent: 'xooma',
        sections: {
          'x2o': {
            ctrl: 'HomeX2OCtrl'
          },
          'other-products': {
            ctrl: 'HomeOtherProductsCtrl'
          }
        }
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
        } else if (action === "Action 2") {
          window.plugin.notification.local.cancel(id);
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
              window.plugin.notification.local.setDefaults(badge);
            } else if (id === '2') {
              badgeValue = 0;
              badge = {
                badge: setbadgeValue
              };
              window.plugin.notification.local.setDefaults(badge);
            } else if (id === '3') {
              badgeValue = 0;
              badge = {
                badge: setbadgeValue
              };
              window.plugin.notification.local.setDefaults(badge);
            } else if (id === '4') {
              badgeValue = 0;
              badge = {
                badge: setbadgeValue
              };
              window.plugin.notification.local.setDefaults(badge);
            }
            window.plugin.notification.local.cancel(id);
            App.navigate("/notification-info", true);
            $('#time_for_notification').text(JSON.parse(json).date);
            return $('#Message_for_notification').text(JSON.parse(json).test);
          }
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
