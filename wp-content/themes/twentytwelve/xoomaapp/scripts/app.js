// Generated by CoffeeScript 1.7.1
jQuery(document).ready(function($) {
  App.state('login').state('xooma', {
    url: '/'
  }).state('profile', {
    url: '/profile',
    parent: 'xooma'
  }).state('ProfilePersonalInfo', {
    url: '/personal-info',
    parent: 'profile'
  }).state('profileMeasurement', {
    url: '/measurements',
    parent: 'profile'
  }).state('settings', {
    url: '/settings',
    parent: 'xooma'
  }).state('home', {
    url: '/home'
  });
  App.addInitializer(function() {
    Backbone.history.start();
    return App.currentUser.on('user:auth:success', function() {
      return App.navigate(App.currentUser.get('state'), true);
    });
  });
  return App.start();
});
