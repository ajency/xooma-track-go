// Generated by CoffeeScript 1.7.1
(function() {
  var __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  XoomApp.ProfilePersonalInfoController = (function(_super) {
    __extends(ProfilePersonalInfoController, _super);

    function ProfilePersonalInfoController() {
      return ProfilePersonalInfoController.__super__.constructor.apply(this, arguments);
    }

    ProfilePersonalInfoController.prototype.initialize = function() {
      this.view = new Xoomapp.ProfilePersonalInfoView;
      return this.show(this.view);
    };

    return ProfilePersonalInfoController;

  })(Ajency.RegionController);

}).call(this);
