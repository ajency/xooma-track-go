// Generated by CoffeeScript 1.8.0
(function() {
  window.App = new Marionette.Application;

  this.mainRegion = new Marionette.Region({
    el: '#main-region'
  });

  this.profileapp = new Xoomapp.ProfilePersonalInfoCtrl({
    region: this.mainRegion
  });

  App.start();

}).call(this);