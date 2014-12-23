(function() {
  var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  App.ProfilePersonalInfoView = (function(_super) {
    __extends(ProfilePersonalInfoView, _super);

    function ProfilePersonalInfoView() {
      this.errorHandler = __bind(this.errorHandler, this);
      this.successHandler = __bind(this.successHandler, this);
      this.onFormSubmit = __bind(this.onFormSubmit, this);
      return ProfilePersonalInfoView.__super__.constructor.apply(this, arguments);
    }

    ProfilePersonalInfoView.prototype.className = 'animated fadeIn';

    ProfilePersonalInfoView.prototype.template = '#profile-personal-info-template';

    ProfilePersonalInfoView.prototype.behaviors = {
      FormBehavior: {
        behaviorClass: Ajency.FormBehavior
      }
    };

    ProfilePersonalInfoView.prototype.ui = {
      form: '.update_user_details',
      responseMessage: '.aj-response-message',
      dateElement: 'input[name="profile[birth_date]"]'
    };

    ProfilePersonalInfoView.prototype.modelEvents = {
      'change:profile_picture': 'render'
    };

    ProfilePersonalInfoView.prototype.initialize = function() {
      return this.listenTo(App, 'fb:status:connected', function() {
        if (!App.currentUser.hasProfilePicture()) {
          return App.currentUser.getFacebookPicture();
        }
      });
    };

    ProfilePersonalInfoView.prototype.onShow = function() {
      return _.enableCordovaBackbuttonNavigation();
    };

    ProfilePersonalInfoView.prototype.onRender = function() {
      Backbone.Syphon.deserialize(this, this.model.toJSON());
      return this.ui.dateElement.pickadate();
    };

    ProfilePersonalInfoView.prototype.onFormSubmit = function(_formData) {
      return this.model.saveProfile(_formData['profile']).done(this.successHandler);
    };

    ProfilePersonalInfoView.prototype.successHandler = function(response, status) {
      return this.showSuccessMessage();
    };

    ProfilePersonalInfoView.prototype.errorHandler = function(error) {};

    return ProfilePersonalInfoView;

  })(Marionette.ItemView);

  App.UserPersonalInfoCtrl = (function(_super) {
    __extends(UserPersonalInfoCtrl, _super);

    function UserPersonalInfoCtrl() {
      this._showView = __bind(this._showView, this);
      return UserPersonalInfoCtrl.__super__.constructor.apply(this, arguments);
    }

    UserPersonalInfoCtrl.prototype.initialize = function(options) {
      if (_.onlineStatus() === false) {
        return window.plugins.toast.showLongBottom("Please check your internet connection.");
      } else {
        return App.currentUser.getProfile().done(this._showView);
      }
    };

    UserPersonalInfoCtrl.prototype._showView = function(userModel) {
      return this.show(new App.ProfilePersonalInfoView({
        model: userModel
      }));
    };

    UserPersonalInfoCtrl.prototype.errorHandler = function(error) {
      this.region = new Marionette.Region({
        el: '#nofound-template'
      });
      return new Ajency.HTTPRequestCtrl({
        region: this.region
      });
    };

    return UserPersonalInfoCtrl;

  })(Ajency.RegionController);

}).call(this);
