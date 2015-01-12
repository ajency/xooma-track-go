var ProfilePersonalInfoView,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

ProfilePersonalInfoView = (function(_super) {
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
    dateElement: 'input[name="profile[birth_date]"]',
    xooma_member_id: '.xooma_member_id'
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
    var birth_date, picker;
    Backbone.Syphon.deserialize(this, this.model.toJSON());
    this.ui.dateElement.pickadate({
      formatSubmit: 'yyyy-mm-dd',
      hiddenName: true,
      max: new Date(),
      selectYears: 70
    });
    birth_date = this.model.get('profile').birth_date;
    picker = this.ui.dateElement.pickadate('picker');
    return picker.set('select', birth_date, {
      format: 'yyyy-mm-dd'
    });
  };

  ProfilePersonalInfoView.prototype.onFormSubmit = function(_formData) {
    return this.model.saveProfile(_formData['profile']).done(this.successHandler).fail(this.errorHandler);
  };

  ProfilePersonalInfoView.prototype.successHandler = function(response, status, xhr) {
    var state;
    state = App.currentUser.get('state');
    if (xhr.status === 404) {
      this.ui.responseMessage.text("Something went wrong");
      return $('html, body').animate({
        scrollTop: 0
      }, 'slow');
    } else {
      if (state === '/home') {
        return this.ui.responseMessage.text("profile successfully updated");
      } else {
        App.currentUser.set('state', '/profile/measurements');
        return App.navigate('#' + App.currentUser.get('state'), true);
      }
    }
  };

  ProfilePersonalInfoView.prototype.errorHandler = function(error) {
    this.ui.responseMessage.text("Data couldn't be saved due to some error.");
    return $('html, body').animate({
      scrollTop: 0
    }, 'slow');
  };

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
      return App.currentUser.getProfile().done(this._showView).fail(this.errorHandler);
    }
  };

  UserPersonalInfoCtrl.prototype._showView = function(userModel) {
    return this.show(new ProfilePersonalInfoView({
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
