var SettingsView,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

App.state('Settings', {
  url: '/settings',
  parent: 'xooma'
});

SettingsView = (function(_super) {
  __extends(SettingsView, _super);

  function SettingsView() {
    return SettingsView.__super__.constructor.apply(this, arguments);
  }

  SettingsView.prototype.className = 'animated fadeIn';

  SettingsView.prototype.template = '#settings-template';

  return SettingsView;

})(Marionette.LayoutView);

App.SettingsCtrl = (function(_super) {
  __extends(SettingsCtrl, _super);

  function SettingsCtrl() {
    return SettingsCtrl.__super__.constructor.apply(this, arguments);
  }

  SettingsCtrl.prototype.initialize = function(options) {
    return this.show(new SettingsView);
  };

  return SettingsCtrl;

})(Ajency.RegionController);
