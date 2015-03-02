jQuery(document).ready(function($) {
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
    return App.navigate('#' + App.currentUser.get('state'), {
      trigger: true,
      replace: true
    });
  });
  App.currentUser.on('user:logged:out', function() {
    var arr;
    arr = [];
    App.useProductColl.reset(arr);
    delete window.userData;
    return App.navigate('#login', {
      trigger: true,
      replace: true
    });
  });
  Offline.options = {
    interceptRequests: true,
    requests: true,
    checks: {
      xhr: {
        url: _SITEURL + '/'
      }
    }
  };
  Offline.on('up', function() {
    return $('.error-connection').hide();
  });
  Offline.on('down', function() {
    return $('.error-connection').show();
  });
  App.addInitializer(function() {
    return Backbone.history.start();
  });
  App.on('fb:status:connected', function() {
    if (!App.currentUser.hasProfilePicture()) {
      return App.currentUser.getFacebookPicture();
    }
  });
  App.on('cordova:hide:splash:screen', function() {
    return console.log("triggered");
  });
  return App.start();
});
