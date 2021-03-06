var XoomaAppRootView,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

XoomaAppRootView = (function(_super) {
  __extends(XoomaAppRootView, _super);

  function XoomaAppRootView() {
    this._successHandler = __bind(this._successHandler, this);
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
    },
    'click nav#menu >li.logout-button': function(e) {
      console.log("aaaaaaaaaa");
      return e.preventDefault();
    }
  };

  XoomaAppRootView.prototype.serializeData = function() {
    var data;
    data = XoomaAppRootView.__super__.serializeData.call(this);
    data.display_name = App.currentUser.get('display_name');
    data.user_email = App.currentUser.get('user_email');
    return data;
  };

  XoomaAppRootView.prototype._successHandler = function(response, status, xhr) {
    return App.currentUser.logout();
  };

  XoomaAppRootView.prototype.onShow = function() {
    var state;
    $('.display_name').text(App.currentUser.get('display_name'));
    $('.user_email').text(App.currentUser.get('user_email'));
    if (App.currentUser.get('ID') === void 0 || App.currentUser.get('caps').administrator === true) {
      $('.profile-template').hide();
      $('.menulink').hide();
    }
    this.showViews();
    $('.logout-button').on('click', function(e) {
      e.preventDefault();
      return $.ajax({
        method: 'GET',
        url: "" + APIURL + "/logout",
        success: XoomaAppRootView.prototype._successHandler
      });
    });
    state = App.currentUser.get('state');
    if (state !== '/home') {
      return $('.link').hide();
    } else {
      return $('.link').show();
    }
  };

  XoomaAppRootView.prototype.showViews = function() {
    var state;
    state = App.currentUser.get('state');
    if (window.location.hash === '' && App.currentUser.get('ID') === void 0) {
      App.currentUser.set({});
      $('.link').hide();
      $('.user-data').hide();
      App.navigate('#login', {
        trigger: true,
        replace: true
      });
      App.stop();
      return App.start();
    } else if (window.location.hash === '' && App.currentUser.get('ID') !== void 0 && state === '/home') {
      App.navigate('#home', {
        trigger: true,
        replace: true
      });
      App.stop();
      return App.start();
    } else if (window.location.hash === '' && App.currentUser.get('ID') !== void 0 && state !== '/home') {
      App.navigate('#' + App.currentUser.get('state'), {
        trigger: true,
        replace: true
      });
      App.stop();
      return App.start();
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
