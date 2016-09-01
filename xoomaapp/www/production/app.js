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
    App.currentUser.set(window.userData);
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
    } else if (App.getCurrentRoute() === 'signin') {
      return CordovaStorage.clearUserData();
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
  if (window.isWebView()) {
    document.addEventListener("online", function() {
      if (window.offlineOnAppStart) {
        window.offlineOnAppStart = false;
        App.navigate('#settings', {
          trigger: true,
          replace: true
        });
        App.navigate('#home', {
          trigger: true,
          replace: true
        });
      }
      $('.mm-page').removeAttr('style');
      return $('.error-connection').css({
        display: 'none'
      });
    }, false);
    document.addEventListener("offline", function() {
      if (App.getCurrentRoute() === 'settings') {
        $('.mm-page').css({
          height: '100%'
        });
      }
      return $('.error-connection').css({
        display: 'block'
      });
    }, false);
  }
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
    if (!CordovaApp.isDeviceOnline()) {
      window.offlineOnAppStart = true;
      $('.mm-page').css({
        height: '100%'
      });
      $('.error-connection').css({
        display: 'block'
      });
      App.trigger('cordova:hide:splash:screen');
    }
    return Backbone.history.start();
  });
  App.on('fb:status:connected', function() {
    if (!App.currentUser.hasProfilePicture()) {
      return App.currentUser.getFacebookPicture();
    }
  });
  App.on('cordova:register:push:notification', function() {
    console.log('In push notification');
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
  App.on('ios:header:footer:fix', function() {
    if (window.isWebView()) {
      return CordovaApp.headerFooterIOSFix();
    }
  });
  App.on('fb:publish:feed', function(model) {
    if (window.isWebView()) {
      return CordovaApp.publishFbFeed(model);
    }
  });
  return App.start();
}, false);
