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
    console.log(App.currentUser);
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
        var userData;
        CordovaStorage.clear();
        App.navigate('/login', {
          replace: true,
          trigger: true
        });
        return userData = {};
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
