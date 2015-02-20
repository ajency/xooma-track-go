document.addEventListener("deviceready", function() {
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
        replace: true,
        trigger: true
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
          return App.navigate('/login', {
            replace: true,
            trigger: true
          });
        });
      });
    }
  });
  Usage.notify.on('$usage:notification', function(event, data) {
    console.log('Event triggered');
    console.log(data.notificationTime);
    return CordovaNotification.schedule('Test Local Notification Based on App Usage', data.notificationTime);
  });
  App.addInitializer(function() {
    CordovaApp.updateXoomaMessages();
    Push.register();
    Usage.track();
    return Backbone.history.start();
  });
  App.on('fb:status:connected', function() {
    if (!App.currentUser.hasProfilePicture()) {
      return App.currentUser.getFacebookPicture();
    }
  });
  App.on('cordova:hide:splash:screen', function() {
    if (window.isWebView()) {
      return CordovaApp.hideSplashscreen();
    }
  });
  return App.start();
}, false);
