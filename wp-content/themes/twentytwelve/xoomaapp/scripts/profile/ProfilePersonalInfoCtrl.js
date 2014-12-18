(function() {
  var __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  App.ProfilePersonalInfoCtrl = (function(_super) {
    __extends(ProfilePersonalInfoCtrl, _super);

    function ProfilePersonalInfoCtrl() {
      return ProfilePersonalInfoCtrl.__super__.constructor.apply(this, arguments);
    }

    ProfilePersonalInfoCtrl.prototype.initialize = function(options) {
      this.user = this._get_user_details();
      return App.execute("when:fetched", [this.user], (function(_this) {
        return function() {
          console.log(_this.user);
          return _this.show(new ProfilePersonalInfoView({
            model: _this.user
          }));
        };
      })(this));
    };

    ProfilePersonalInfoCtrl.prototype._get_user_details = function() {
      $.ajax({
        method: 'GET',
        url: _SITEURL + '/wp-json/profiles/128',
        data: '',
        success: function(response) {
          var response_data;
          response_data = response;
          App.currentUser.set('xooma_member_id', response_data.response.xooma_member_id);
          App.currentUser.set('name', response_data.response.name);
          App.currentUser.set('email_id', response_data.response.email);
          App.currentUser.set('image', response_data.response.image);
          App.currentUser.set('gender', response_data.response.gender);
          App.currentUser.set('phone_no', response_data.response.phone_no);
          App.currentUser.set('timezone', response_data.response.timezone);
          App.currentUser.set('birth_date', response_data.response.birth_date);
          return App.currentUser.set('user_products', response_data.response.user_products);
        },
        error: function(error) {
          return $('.response_msg').text("Something went wrong");
        }
      });
      return App.currentUser;
    };

    return ProfilePersonalInfoCtrl;

  })(Marionette.RegionController);

}).call(this);
