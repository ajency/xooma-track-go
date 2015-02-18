var XoomaAppRootView,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

XoomaAppRootView = (function(_super) {
  __extends(XoomaAppRootView, _super);

  function XoomaAppRootView() {
    return XoomaAppRootView.__super__.constructor.apply(this, arguments);
  }

  XoomaAppRootView.prototype.template = '#xooma-app-template';

  XoomaAppRootView.prototype.ui = {
    ul: '.list-inline',
    link: '.link',
    logolink: '.logo_link'
  };

  XoomaAppRootView.prototype.behaviors = {
    ActiveLink: {
      behaviorClass: Ajency.ActiveLinkBehavior
    }
  };

  XoomaAppRootView.prototype.events = {
    'click a.linkhref': function(e) {
      return e.preventDefault();
    },
    'click @ui.logolink': function(e) {
      var computed_url;
      e.preventDefault();
      computed_url = '#' + window.location.hash.split('#')[1];
      return App.navigate(computed_url, true);
    }
  };

  XoomaAppRootView.prototype.serializeData = function() {
    var data;
    data = XoomaAppRootView.__super__.serializeData.call(this);
    data.display_name = App.currentUser.get('display_name');
    data.user_email = App.currentUser.get('user_email');
    return data;
  };

  XoomaAppRootView.prototype.onShow = function() {
    var state;
    $('nav#menu').mmenu({
      onClick: {
        close: true,
        preventDefault: false,
        setSelected: true
      }
    });
    state = App.currentUser.get('state');
    if (state !== '/home') {
      this.ui.link.hide();
    } else {
      this.ui.link.show();
    }
    this.currentUserRegion.show(new Ajency.CurrentUserView({
      model: App.currentUser
    }));
    if (window.location.hash === '' && App.currentUser.get('ID') === void 0) {
      App.currentUser.set({});
      this.ui.link.hide();
      $('.user-data').hide();
      return App.navigate('#login', true);
    } else {
      return App.navigate('#home', true);
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

  XoomaCtrl.prototype.getLLoadingView = function() {
    return new Loading;
  };

  return XoomaCtrl;

})(Ajency.RegionController);
