(function() {
  return document.addEventListener("deviceready", (function() {
    _.enableCordovaBackbuttonNavigation();
    Push.initialize();
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
    });
    App.onBeforeStart = function() {
      App.currentUser.set(userData);
      if (!App.currentUser.isLoggedIn()) {
        return App.currentUser.setNotLoggedInCapabilities();
      }
    };
    App.currentUser.on('user:auth:success', function() {
      _.setUserData(App.currentUser.toJSON());
      return App.navigate('#' + App.currentUser.get('state'), true);
    });
    App.currentUser.on('user:logged:out', function() {
      App.navigate('/login', true);
      window.localStorage.removeItem("user_data");
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
      return _.cordovaHideSplashscreen();
    });
    App.on('2fb:status:connected', function() {
      if (!App.currentUser.hasProfilePicture()) {
        return App.currentUser.getFacebookPicture();
      }
    });
    return App.start();
  }), false);
}).call();
