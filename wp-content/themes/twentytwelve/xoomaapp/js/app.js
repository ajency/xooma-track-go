document.addEventListener("deviceready", function() {
  App.state('login').state('xooma', {
    url: '/'
  });
  App.onBeforeStart = function() {
    App.currentUser.set(window.userData);
    if (!App.currentUser.isLoggedIn()) {
      return App.currentUser.setNotLoggedInCapabilities();
    }
  };
  App.currentUser.on('user:auth:success', function() {
    if (window.isWebView()) {
      window.userData = App.currentUser.toJSON();
    }
    App.trigger('fb:status:connected');
    CordovaStorage.setUserData(window.userData);
    return ParseCloud.register().then(function() {
      return App.navigate('#' + App.currentUser.get('state'), {
        trigger: true,
        replace: true
      });
    }, function(error) {
      console.log('ParseCloud Register Error');
      return App.currentUser.logout();
    });
  });
  App.currentUser.on('user:logged:out', function() {
    var onLogout;
    onLogout = function() {
      var arr;
      CordovaStorage.clearUserData();
      arr = [];
      App.useProductColl.reset(arr);
      return delete window.userData;
    };
    if (App.getCurrentRoute() === 'login') {
      return CordovaApp.facebookLogout().then(onLogout);
    } else {
      return ParseCloud.deregister().then(function() {
        return CordovaApp.facebookLogout().then(function() {
          onLogout();
          return App.navigate('#login', {
            trigger: true,
            replace: true
          });
        });
      });
    }
  });
  Offline.options = {
    interceptRequests: true,
    requests: true,
    checks: {
      xhr: {
        url: "" + _SITEURL + "/"
      }
    }
  };
  Offline.on('confirmed-up', function() {
    return $('.error-connection').css({
      display: 'none'
    });
  });
  Offline.on('confirmed-down', function() {
    return $('.error-connection').css({
      display: 'block'
    });
  });
  Usage.notify.on('$usage:notification', function(event, data) {
    console.log("$usage:notification triggered at " + data.notificationTime);
    return CordovaNotification.schedule("Hey user achieve your today's health goal.", data.notificationTime);
  });
  App.addInitializer(function() {
    FastClick.attach(document.body);
    CordovaApp.updateXoomaMessages();
    CordovaNotification.registerPermission();
    Usage.track({
      days: 5
    });
    return Backbone.history.start();
  });
  App.on('fb:status:connected', function() {
    if (!App.currentUser.hasProfilePicture()) {
      return App.currentUser.getFacebookPicture();
    }
  });
  App.on('cordova:register:push:notification', function() {
    if (window.isWebView()) {
      return Push.register();
    }
  });
  App.on('cordova:set:user:data', function() {
    if (window.isWebView()) {
      return CordovaStorage.setUserData(App.currentUser.toJSON());
    }
  });
  App.on('cordova:hide:splash:screen', function() {
    if (window.isWebView()) {
      return CordovaApp.hideSplashscreen();
    }
  });
  return App.start();
}, false);
