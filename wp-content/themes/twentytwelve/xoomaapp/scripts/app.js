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
    App.currentUser.set(userData);
    if (!App.currentUser.isLoggedIn()) {
      return App.currentUser.setNotLoggedInCapabilities();
    }
  };
  App.currentUser.on('user:auth:success', function() {
    App.trigger('fb:status:connected');
    CordovaStorage.setUserData(App.currentUser.toJSON());
    return ParseCloud.register().then(function() {
      return App.navigate('#' + App.currentUser.get('state'), {
        replace: true,
        trigger: true
      });
    });
  });
  App.currentUser.on('user:logged:out', function() {
    return CordovaApp.facebookLogout().then(function() {
      return ParseCloud.deregister().then(function() {
        CordovaStorage.clear();
        App.currentUser.set({});
        userData = {};
        App.currentUser.loginCheck();
        return App.navigate('/login', {
          replace: true,
          trigger: true
        });
      });
    });
  });
  App.state('settings', {
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
  });
  App.addInitializer(function() {
    Backbone.history.start();
    Usage.notify.on('$usage:notification', function(event, data) {
      console.log('Event triggered');
      return console.log(data);
    });
    Usage.track();
    return Push.register().then(function() {
      if (!App.currentUser.isLoggedIn()) {
        App.navigate('/login', {
          replace: true,
          trigger: true
        });
        return App.trigger('cordova:hide:splash:screen');
      } else {
        App.trigger('fb:status:connected');
        return App.navigate('#' + App.currentUser.get('state'), {
          replace: true,
          trigger: true
        });
      }
    });
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
