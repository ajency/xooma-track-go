// Generated by CoffeeScript 1.7.1
jQuery(document).ready(function($) {
  App.state('login').state('xooma', {
    url: '/'
  }).state('AddProducts', {
    url: '/products',
    parent: 'xooma'
  }).state('UserProductList', {
    url: '/my-products',
    parent: 'profile'
  }).state('home', {
    url: '/home',
    parent: 'xooma'
  });
  App.onBeforeStart = function() {
    App.currentUser.set(userData);
    if (!App.currentUser.isLoggedIn()) {
      return App.currentUser.setNotLoggedInCapabilities();
    }
  };
  App.currentUser.on('user:auth:success', function() {
    App.trigger('fb:status:connected');
    return App.navigate(App.currentUser.get('state'), true);
  });
  App.currentUser.on('user:logged:out', function() {
    return App.navigate('/login', true);
  });
  App.state('settings', {
    url: '/settings',
    parent: 'xooma'
  }).state('home', {
    url: '/home',
    parent: 'xooma'
  }).state('UserProductList', {
    url: '/my-products',
    parent: 'profile'
  }).state('AddProducts', {
    url: '/products',
    parent: 'xooma'
  });
  App.addInitializer(function() {
    return Backbone.history.start();
  });
  App.on('fb:status:connected', function() {
    if (!App.currentUser.hasProfilePicture()) {
      return App.currentUser.getFacebookPicture();
    }
  });
  return App.start();
});
