(function() {
  var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  App.ProfilePersonalInfoCtrl = (function(_super) {
    __extends(ProfilePersonalInfoCtrl, _super);

    function ProfilePersonalInfoCtrl() {
      this.successHandler = __bind(this.successHandler, this);
      this._showView = __bind(this._showView, this);
      return ProfilePersonalInfoCtrl.__super__.constructor.apply(this, arguments);
    }

    ProfilePersonalInfoCtrl.prototype.initialize = function(options) {
      var xhr;
      if (_.onlineStatus() === false) {
        return window.plugins.toast.showLongBottom("Please check your internet connection.");
      } else {
        xhr = this._get_user_details();
        return xhr.done(this._showView).fail(this.errorHandler);
      }
    };

    ProfilePersonalInfoCtrl.prototype._showView = function() {
      return this.show(new App.ProfilePersonalInfoView({
        model: App.currentUser
      }));
    };

    ProfilePersonalInfoCtrl.prototype._get_user_details = function() {
      var deferred;
      if (!App.currentUser.has('profiles')) {
        return $.ajax({
          method: 'GET',
          url: "" + _SITEURL + "/wp-json/profiles/" + (App.currentUser.get('ID')),
          success: this.successHandler
        });
      } else {
        deferred = Marionette.Deferred();
        deferred.resolve(true);
        return deferred.promise();
      }
    };

    ProfilePersonalInfoCtrl.prototype.errorHandler = function(error) {
      this.region = new Marionette.Region({
        el: '#nofound-template'
      });
      return new Ajency.HTTPRequestCtrl({
        region: this.region
      });
    };

    ProfilePersonalInfoCtrl.prototype.successHandler = function(response, status) {
      return App.currentUser.set('profiles', response.response);
    };

    return ProfilePersonalInfoCtrl;

  })(Marionette.RegionController);

}).call(this);
