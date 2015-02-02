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
      return App.navigate('#' + App.currentUser.get('state'), {
        replace: true,
        trigger: true
      });
    });
  });
  App.currentUser.on('user:logged:out', function() {
    return ParseCloud.deregister().done(function() {
      CordovaStorage.clear();
      return App.navigate('/login', {
        replace: true,
        trigger: true
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
    return Push.register().done(function() {
      if (!App.currentUser.isLoggedIn()) {
        App.navigate('/login', {
          replace: true,
          trigger: true
        });
        return _.hideSplashscreen();
      } else {
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
  return App.start();
}, false);
