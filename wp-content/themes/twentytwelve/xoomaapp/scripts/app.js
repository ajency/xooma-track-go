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
    });
  });
  App.currentUser.on('user:logged:out', function() {
    return CordovaApp.facebookLogout().then(function() {
      return ParseCloud.deregister().then(function() {
        var arr;
        CordovaStorage.clear();
        arr = [];
        App.useProductColl.reset(arr);
        delete window.userData;
        return App.navigate('/login', {
          replace: true,
          trigger: true
        });
      });
    });
  });
  App.addInitializer(function() {
    Backbone.history.start();
    CordovaApp.updateXoomaMessages();
    return Push.register();
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
