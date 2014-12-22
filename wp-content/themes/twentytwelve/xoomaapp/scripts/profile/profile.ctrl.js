(function() {
  var __hasProp = {}.hasOwnProperty,
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

  App.ProfileCtrlView = (function(_super) {
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

    ProfileCtrlView.prototype.preventClick = function(evt) {
      return evt.preventDefault();
    };

    ProfileCtrlView.prototype.handleMenu = function(evt, state, args) {
      var url;
      url = "#/" + (state.get('computed_url'));
      this.ui.ul.find('a').removeAttr('disabled');
      this.$('a[href="' + url + '"]').parent().siblings().removeClass('active');
      return this.$('a[href="' + url + '"]').parent().addClass('active');
    };

    return ProfileCtrlView;

  })(Marionette.LayoutView);

  App.ProfileCtrl = (function(_super) {
    __extends(ProfileCtrl, _super);

    function ProfileCtrl() {
      return ProfileCtrl.__super__.constructor.apply(this, arguments);
    }

    ProfileCtrl.prototype.initialize = function(options) {
      return this.show(new App.ProfileCtrlView);
    };

    return ProfileCtrl;

  })(Marionette.RegionController);

}).call(this);
