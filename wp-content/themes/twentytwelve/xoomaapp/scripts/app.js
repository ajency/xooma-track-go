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
    CordovaStorage.setUserData(App.currentUser.toJSON());
    return ParseCloud.register().done(function() {
      return App.navigate('#' + App.currentUser.get('state'), true);
    });
  });
  App.currentUser.on('user:logged:out', function() {
    return ParseCloud.deregister().done(function() {
      CordovaStorage.clear();
      return App.navigate('/login', true);
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
    Push.register().done(function() {
      console.log('register_GCM_APNS success');
      if (!App.currentUser.isLoggedIn()) {
        App.navigate('/login', true);
      } else {
        console.log('USER LOGGED IN');
      }
      return _.hideSplashscreen();
    });
    return _.enableDeviceBackNavigation();
  });
  App.on('fb:status:connected', function() {
    if (!App.currentUser.hasProfilePicture()) {
      return App.currentUser.getFacebookPicture();
    }
  });
  return App.start();
}, false);
