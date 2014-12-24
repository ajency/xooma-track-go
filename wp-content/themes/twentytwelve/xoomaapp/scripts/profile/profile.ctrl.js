var ProfileCtrlView,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

App.state('profile', {
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

ProfileCtrlView = (function(_super) {
  __extends(ProfileCtrlView, _super);

  function ProfileCtrlView() {
    return ProfileCtrlView.__super__.constructor.apply(this, arguments);
  }

  ProfileCtrlView.prototype.className = 'animated fadeIn';

  ProfileCtrlView.prototype.template = '#profile-template';

  ProfileCtrlView.prototype.ui = {
    ul: '.list-inline'
  };

  ProfileCtrlView.prototype.events = {
    'click @ui.ul li a': 'preventClick'
  };

  ProfileCtrlView.prototype.initialize = function(options) {
    if (options == null) {
      options = {};
    }
    ProfileCtrlView.__super__.initialize.call(this, options);
    return this.listenTo(App, 'state:transition:complete', this.handleMenu);
  };

  ProfileCtrlView.prototype.preventClick = function(evt) {};

  ProfileCtrlView.prototype.handleMenu = function(evt, state, args) {
    var url;
    url = App.currentUser.get('state');
    if (url === '/profile/personal-info') {
      $('#profile').parent().addClass('active');
      $('#measurement').css({
        cursor: 'default'
      });
      $('#measurement').bind('click', this.disableEvent);
      $('#product').css({
        cursor: 'default'
      });
      return $('#product').bind('click', this.disableEvent);
    } else if (url === '/profile/measurements') {
      $('#profile').parent().removeClass('active');
      $('#measurement').parent().addClass('active');
      $('#measurement').css({
        cursor: 'pointer'
      });
      $('#product').css('cursor:default');
      $('#product').bind('click', this.disableEvent);
      return $('#profile').unbind();
    }
  };

  ProfileCtrlView.prototype.disableEvent = function(evt) {
    evt.preventDefault();
    return false;
  };

  return ProfileCtrlView;

})(Marionette.LayoutView);

App.ProfileCtrl = (function(_super) {
  __extends(ProfileCtrl, _super);

  function ProfileCtrl() {
    return ProfileCtrl.__super__.constructor.apply(this, arguments);
  }

  ProfileCtrl.prototype.initialize = function(options) {
    return this.show(new ProfileCtrlView);
  };

  return ProfileCtrl;

})(Marionette.RegionController);
