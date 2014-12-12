// Generated by CoffeeScript 1.7.1
(function() {
  jQuery(document).ready(function($) {
    document.addEventListener('deviceready', function(){
      App.state('login').state('xooma', {
        url: '/'
      }).state('personalInfo', {
        url: '/profile/personal-info',
        parent: 'xooma'
      });
      App.addInitializer(function() {
        Backbone.history.start();
        if (!App.currentUser.isLoggedIn()) {
          return App.navigate('/login', true);
        } else {
          return App.navigate('/', true);
        }

      });
     
    });
    return App.start();
  }, false);
}).call();
