(function() {
  var NotificationDisplayView, NotificationView, XoomaAppRootView,
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

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

    XoomaAppRootView.prototype.onShow = function() {
      return this.currentUserRegion.show(new Ajency.CurrentUserView({
        model: App.currentUser
      }));
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

  })(Ajency.RegionController);

  NotificationDisplayView = (function(_super) {
    __extends(NotificationDisplayView, _super);

    function NotificationDisplayView() {
      return NotificationDisplayView.__super__.constructor.apply(this, arguments);
    }

    NotificationDisplayView.prototype.className = 'animated fadeIn';

    NotificationDisplayView.prototype.template = '#notification-display-template';

    return NotificationDisplayView;

  })(Marionette.ItemView);

  App.NotificationDisplayCtrl = (function(_super) {
    __extends(NotificationDisplayCtrl, _super);

    function NotificationDisplayCtrl() {
      return NotificationDisplayCtrl.__super__.constructor.apply(this, arguments);
    }

    NotificationDisplayCtrl.prototype.initialize = function(options) {
      return this.show(new NotificationDisplayView);
    };

    return NotificationDisplayCtrl;

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
