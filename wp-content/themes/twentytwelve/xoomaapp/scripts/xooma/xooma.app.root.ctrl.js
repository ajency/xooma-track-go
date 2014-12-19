(function() {
  var HomeView, NotificationView, ProfileCtrlView, SettingsView, XoomaAppRootView,
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

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

    ProfileCtrlView.prototype.behaviors = {
      ActiveLink: {
        behaviorClass: Ajency.ActiveLinkBehavior
      }
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

  XoomaAppRootView = (function(_super) {
    __extends(XoomaAppRootView, _super);

    function XoomaAppRootView() {
      return XoomaAppRootView.__super__.constructor.apply(this, arguments);
    }

    XoomaAppRootView.prototype.className = 'animated fadeIn';

    XoomaAppRootView.prototype.template = '#xooma-app-template';

    XoomaAppRootView.prototype.ui = {
      ul: '.list-inline'
    };

    XoomaAppRootView.prototype.behaviors = {
      ActiveLink: {
        behaviorClass: Ajency.ActiveLinkBehavior
      }
    };

    return XoomaAppRootView;

  })(Marionette.LayoutView);

  App.XoomaCtrl = (function(_super) {
    __extends(XoomaCtrl, _super);

    function XoomaCtrl() {
      return XoomaCtrl.__super__.constructor.apply(this, arguments);
    }

    XoomaCtrl.prototype.initialize = function(options) {
      return this.show(new XoomaAppRootView);
    };

    return XoomaCtrl;

  })(Marionette.RegionController);

  SettingsView = (function(_super) {
    __extends(SettingsView, _super);

    function SettingsView() {
      return SettingsView.__super__.constructor.apply(this, arguments);
    }

    SettingsView.prototype.className = 'animated fadeIn clearfix';

    SettingsView.prototype.template = '#settings-template';

    return SettingsView;

  })(Marionette.ItemView);

  App.SettingsCtrl = (function(_super) {
    __extends(SettingsCtrl, _super);

    function SettingsCtrl() {
      return SettingsCtrl.__super__.constructor.apply(this, arguments);
    }

    SettingsCtrl.prototype.initialize = function(options) {
      return this.show(new SettingsView);
    };

    return SettingsCtrl;

  })(Marionette.RegionController);

  HomeView = (function(_super) {
    __extends(HomeView, _super);

    function HomeView() {
      return HomeView.__super__.constructor.apply(this, arguments);
    }

    HomeView.prototype.className = 'animated fadeIn clearfix';

    HomeView.prototype.template = '#home-template';

    return HomeView;

  })(Marionette.ItemView);

  App.HomeCtrl = (function(_super) {
    __extends(HomeCtrl, _super);

    function HomeCtrl() {
      return HomeCtrl.__super__.constructor.apply(this, arguments);
    }

    HomeCtrl.prototype.initialize = function(options) {
      return this.show(new HomeView);
    };

    return HomeCtrl;

  })(Marionette.RegionController);

  NotificationView = (function(_super) {
    __extends(NotificationView, _super);

    function NotificationView() {
      return NotificationView.__super__.constructor.apply(this, arguments);
    }

    NotificationView.prototype.className = 'animated fadeIn';

    NotificationView.prototype.template = '#notification-info-template';

    return NotificationView;

  })(Marionette.ItemView);

  App.NotificationCtrl = (function(_super) {
    __extends(NotificationCtrl, _super);

    function NotificationCtrl() {
      return NotificationCtrl.__super__.constructor.apply(this, arguments);
    }

    NotificationCtrl.prototype.initialize = function(options) {
      return this.show(new NotificationView);
    };

    return NotificationCtrl;

  })(Marionette.RegionController);

}).call(this);
