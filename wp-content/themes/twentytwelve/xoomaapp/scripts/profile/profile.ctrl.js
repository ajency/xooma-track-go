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
}).state('AddProducts', {
  url: '/products',
  parent: 'xooma'
}).state('UserProductList', {
  url: '/my-products',
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
    'click @ui.ul li': 'preventClick'
  };

  ProfileCtrlView.prototype.initialize = function(options) {
    if (options == null) {
      options = {};
    }
    ProfileCtrlView.__super__.initialize.call(this, options);
    return this.listenTo(App, 'state:transition:complete', this.handleMenu);
  };

  ProfileCtrlView.prototype.preventClick = function(evt) {
    this.$('#' + evt.target.id).parent().addClass('selected');
    return this.$('#' + evt.target.id).parent().siblings().removeClass('selected');
  };

  ProfileCtrlView.prototype.handleMenu = function(evt, state, args) {
    var computed_url, url;
    url = '#' + App.currentUser.get('state');
    console.log(computed_url = '#' + window.location.hash.split('#')[1]);
    if (url === computed_url) {
      this.$('a[href="' + url + '"]').parent().addClass('selected');
      this.$('a[href="' + url + '"]').parent().unbind();
      this.$('a[href="' + url + '"]').parent().find('a').css({
        cursor: 'pointer'
      });
      this.$('a[href="' + url + '"]').parent().nextAll().bind('click', this.disableEvent);
      this.$('a[href="' + url + '"]').parent().nextAll().find('a').css({
        cursor: 'default'
      });
      this.$('a[href="' + url + '"]').parent().prevAll().unbind();
      this.$('a[href="' + url + '"]').parent().prevAll().find('a').css({
        cursor: 'pointer'
      });
      return this.$('a[href="' + url + '"]').parent().prevAll().removeClass('selected');
    } else {
      return this.$('a[href="' + computed_url + '"]').parent().addClass('selected');
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
