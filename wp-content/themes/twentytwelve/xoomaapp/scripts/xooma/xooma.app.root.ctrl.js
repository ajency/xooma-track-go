var XoomaAppRootView,
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
    ul: '.list-inline',
    link: '.link'
  };

  XoomaAppRootView.prototype.behaviors = {
    ActiveLink: {
      behaviorClass: Ajency.ActiveLinkBehavior
    }
  };

  XoomaAppRootView.prototype.events = {
    'click a.linkhref': function(e) {
      return e.preventDefault();
    }
  };

  XoomaAppRootView.prototype.onShow = function() {
    var state;
    state = App.currentUser.get('state');
    if (state !== '/home') {
      this.ui.link.hide();
    } else {
      this.ui.link.show();
    }
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

  XoomaCtrl.prototype.getLLoadingView = function() {
    return new Loading;
  };

  return XoomaCtrl;

})(Ajency.RegionController);
