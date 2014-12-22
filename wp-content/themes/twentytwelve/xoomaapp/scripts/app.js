// Generated by CoffeeScript 1.7.1
jQuery(document).ready(function($) {
  App.state('login').state('xooma', {
    url: '/'
  });
  App.onBeforeStart = function() {
    App.currentUser.set(userData);
    if (!App.currentUser.isLoggedIn()) {
      return App.currentUser.set('caps', notLoggedInCaps);
    }
  };
  App.currentUser.on('user:auth:success', function() {
    return App.navigate(App.currentUser.get('state'), true);
  });
  App.currentUser.on('user:logged:out', function() {
    App.currentUser.clear({
      slient: true
    });
    App.currentUser.set('caps', notLoggedInCaps);
    return App.navigate('/login', true);
  });
  App.addInitializer(function() {
    return Backbone.history.start();
  });
  return App.start();
});
