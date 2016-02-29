(function() {
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
    App.currentUser.on('user:lauth:success', function() {
      App.trigger('user:status:connected');
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
          url: _SITEURL + "/"
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
    App.addInitializer(function() {
      return Backbone.history.start();
    });
    App.on('fb:status:connected', function() {
      if (!App.currentUser.hasProfilePicture()) {
        return App.currentUser.getFacebookPicture();
      }
    });
    App.on('user:status:connected', function() {
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
  });

}).call(this);
