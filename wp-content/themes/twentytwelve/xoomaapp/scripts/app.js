(function() {
  (function() {
    return document.addEventListener("deviceready", (function() {
      var notificationIdAndBadgeValue;
      notificationIdAndBadgeValue = [];
      cordova.plugins.notification.badge;
      _.cordovaLocalStorage();
      _.enableCordovaBackbuttonNavigation();
      App.state('login').state('xooma', {
        url: '/'
      }).state('profile', {
        url: '/profile',
        parent: 'xooma'
      }).state('ProfilePersonalInfo', {
        url: '/personal-info',
        parent: 'profile'
      }).state('profileMeasurement', {
        url: '/measurements',
        parent: 'profile'
      }).state('settings', {
        url: '/settings',
        parent: 'xooma'
      }).state('home', {
        url: '/home'
      }).state('notification', {
        url: '/notification-info'
      });
      App.addInitializer(function() {
        Backbone.history.start();
        _.cordovaHideSplashscreen();
        App.navigate('/login', true);
        return window.plugin.notification.local.onclick = function(id, state, json) {
          var badge, badgeValue, badgeValues, i, ids, option, setbadgeValue, value, _i, _ref;
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
          return $('#Message_for_notification').text(JSON.parse(json).test);
        };
      });
      return App.start();
    }), false);
  }).call();

}).call(this);
