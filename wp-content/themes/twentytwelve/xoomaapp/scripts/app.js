// Generated by CoffeeScript 1.7.1
jQuery(document).ready(function($) {
  App.state('login').state('xooma', {
    url: '/'
  }).state('profile', {
    url: '/profile',
    parent: 'xooma',
    data: {
      arule: 'SOME:ACCESS;RULES:HERE',
      trule: 'SOME:TRANSITION;RUlES:HERE'
    }
  }).state('userPersonalInfo', {
    url: '/personal-info',
    parent: 'profile'
  }).state('userMeasurement', {
    url: '/measurements',
    parent: 'profile'
  });
  App.addInitializer(function() {
    Backbone.history.start();
    return App.currentUser.on('user:auth:success', function() {
      return App.navigate(App.currentUser.get('state'), true);
    });
  });
  App.on('fb:status:connected', function() {
    if (!App.currentUser.hasProfilePicture()) {
      return App.currentUser.getFacebookPicture();
    }
  });
  App.on('state:transition:start', function(evt, state, params) {
    if (!App.currentUser.isLoggedIn() && App.isLoggedInState(stateName)) {
      evt.preventDefault();
      App.navigate('#/login', true);
    }
    if (App.currentUser.isLoggedIn() && state.get('name') === 'login') {
      evt.preventDefault();
      return App.navigate('#/profile/personal-info', true);
    }
  });
  return App.start();
});
