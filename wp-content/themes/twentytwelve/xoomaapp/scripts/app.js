// Generated by CoffeeScript 1.7.1
(function() {
  jQuery(document).ready(function($) {
    App.state('login').state('xooma', {
      url: '/'
    }).state('ProfilePersonalInfo', {
      url: '/profile/personal-info',
      parent: 'xooma'
    });
    App.addInitializer(function() {
      Backbone.history.start();
      return App.navigate('/login', true);
    });
    return App.start();
  });

}).call(this);
