var ProfilePersonalInfoView,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

ProfilePersonalInfoView = (function(_super) {
  __extends(ProfilePersonalInfoView, _super);

  function ProfilePersonalInfoView() {
    this.errorHandler = __bind(this.errorHandler, this);
    this.successHandler = __bind(this.successHandler, this);
    this._successHandler = __bind(this._successHandler, this);
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
    xooma_member_id: '.xooma_member_id',
    timezone: 'input[name="profile[timezone]"]'
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

  ProfilePersonalInfoView.prototype.onRender = function() {
    Backbone.Syphon.deserialize(this, this.model.toJSON());
    if (!window.isWebView()) {
      $('#birth_date').datepicker({
        dateFormat: 'yy-mm-dd',
        changeYear: true,
        changeMonth: true,
        maxDate: new Date(),
        yearRange: "-100:+0"
      });
    }
    return $('.data1').hide();
  };

  ProfilePersonalInfoView.prototype.onShow = function() {
    var state;
    $('.data1').hide();
    if (App.currentUser.get('caps').administrator === true) {
      $('.profile-template').hide();
      $('.tabelements').attr('disabled', true);
      $('.data').hide();
      $('.data1').show();
    }
    App.trigger('cordova:hide:splash:screen');
    if (!window.isWebView()) {
      $('#birth_date').datepicker({
        dateFormat: 'yy-mm-dd',
        changeYear: true,
        changeMonth: true,
        maxDate: new Date(),
        yearRange: "-100:+0"
      });
    }
    state = App.currentUser.get('state');
    if (state === '/home') {
      $('.measurements_update').removeClass('hidden');
      $('#profile').parent().removeClass('done');
      $('#profile').parent().addClass('selected');
      $('#profile').parent().siblings().removeClass('selected');
      $('#profile').parent().nextAll().addClass('done');
    }
    if (App.currentUser.get('timezone') === null) {
      return this.$el.find('#timezone option[value="' + $('#timezone').val() + '"]').prop("selected", true);
    }
  };

  ProfilePersonalInfoView.prototype.onFormSubmit = function(_formData) {
    var id;
    $('.loadingconusme').html('<img src="' + _SITEURL + '/wp-content/themes/twentytwelve/xoomaapp/images/ajax-loader.gif" width="40px">');
    if (App.currentUser.get('caps').administrator === true) {
      console.log(id = this.model.get('profile').user_id);
      return $.ajax({
        method: 'PUT',
        url: APIURL + '/users/' + id + '/profile',
        data: JSON.stringify(_formData['profile']),
        success: this._successHandler
      });
    } else {
      return this.model.saveProfile(_formData['profile']).done(this.successHandler).fail(this.errorHandler);
    }
  };

  ProfilePersonalInfoView.prototype._successHandler = function(response, status, xhr) {
    $('.loadingconusme').html("");
    this.ui.responseMessage.addClass('alert alert-success').text("Personal Information successfully updated!");
    return $('html, body').animate({
      scrollTop: 0
    }, 'slow');
  };

  ProfilePersonalInfoView.prototype.successHandler = function(response, status, xhr) {
    var state;
    $('.loadingconusme').html("");
    state = App.currentUser.get('state');
    if (xhr.status === 404) {
      window.removeMsg();
      this.ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be saved due to some error!");
      return $('html, body').animate({
        scrollTop: 0
      }, 'slow');
    } else {
      if (state === '/home') {
        window.removeMsg();
        App.currentUser.set('profile', response);
        App.currentUser.set('timezone', response.timezone);
        App.currentUser.set('offset', response.offset);
        this.ui.responseMessage.addClass('alert alert-success').text("Personal Information successfully updated!");
        return $('html, body').animate({
          scrollTop: 0
        }, 'slow');
      } else {
        App.currentUser.set('profile', response);
        App.currentUser.set('timezone', response.timezone);
        App.currentUser.set('state', '/profile/measurements');
        return App.navigate('#' + App.currentUser.get('state'), true);
      }
    }
  };

  ProfilePersonalInfoView.prototype.errorHandler = function(error) {
    $('.loadingconusme').html("");
    window.removeMsg();
    this.ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be saved due to some error!");
    return $('html, body').animate({
      scrollTop: 0
    }, 'slow');
  };

  return ProfilePersonalInfoView;

})(Marionette.ItemView);

App.UserPersonalInfoCtrl = (function(_super) {
  __extends(UserPersonalInfoCtrl, _super);

  function UserPersonalInfoCtrl() {
    this.errorHandler = __bind(this.errorHandler, this);
    this._showView = __bind(this._showView, this);
    return UserPersonalInfoCtrl.__super__.constructor.apply(this, arguments);
  }

  UserPersonalInfoCtrl.prototype.initialize = function(options) {
    var computed_url, url;
    url = '#' + App.currentUser.get('state');
    computed_url = '#' + window.location.hash.split('#')[1];
    if (url !== computed_url && url !== '#/home') {
      return this.show(new workflow);
    } else {
      this.show(this.parent().parent().getLLoadingView());
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
      el: '#404-template'
    });
    return new Ajency.HTTPRequestCtrl({
      region: this.region
    });
  };

  return UserPersonalInfoCtrl;

})(Ajency.RegionController);
