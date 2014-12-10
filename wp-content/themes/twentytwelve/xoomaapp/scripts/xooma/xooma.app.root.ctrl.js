// Generated by CoffeeScript 1.7.1
(function() {
  var XoomaAppRootView,
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  XoomaAppRootView = (function(_super) {
    __extends(XoomaAppRootView, _super);

    function XoomaAppRootView() {
      return XoomaAppRootView.__super__.constructor.apply(this, arguments);
    }

    XoomaAppRootView.prototype.className = 'animated bounceInLeft';

    XoomaAppRootView.prototype.template = '#xooma-app-template';

    return XoomaAppRootView;

  })(Marionette.LayoutView);

  App.PersonalInfoCtrl = (function(_super) {
    __extends(PersonalInfoCtrl, _super);

    function PersonalInfoCtrl() {
      return PersonalInfoCtrl.__super__.constructor.apply(this, arguments);
    }

    PersonalInfoCtrl.prototype.initialize = function(options) {
      return this.show(new Marionette.ItemView({
        template: '<div>Some profile screen here</div>'
      }));
    };

    return PersonalInfoCtrl;

  })(Ajency.RegionController);

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

}).call(this);