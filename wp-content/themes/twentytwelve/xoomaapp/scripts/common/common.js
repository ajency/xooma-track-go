// Generated by CoffeeScript 1.7.1
(function() {
  var LoginView,
    __slice = [].slice,
    __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  _.extend(Ajency.CurrentUser.prototype, {
    authenticates: function() {
      var accessToken, args, data, responseFn, userData, userLogin, _currentUser, _this;
      args = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
      _currentUser = this;
      _this = this;
      responseFn = function(response, status, xhr) {
        if (_.isUndefined(response.ID)) {
          _currentUser.trigger("user:auth:failed", response);
          return _this.trigger("user:auth:failed", response);
        } else {
          authNS.localStorage.set("HTTP_X_API_KEY", xhr.getResponseHeader("HTTP_X_API_KEY"));
          authNS.localStorage.set("HTTP_X_SHARED_SECRET", xhr.getResponseHeader("HTTP_X_SHARED_SECRET"));
          currentUserNS.localStorage.set("userModel", response);
          _currentUser.set(response);
          return _currentUser.trigger("user:auth:success", _currentUser);
        }
      };
      if (_.isString(args[0])) {
        userData = args[1];
        accessToken = args[2];
        userLogin = "FB_" + userData.id;
        data = {
          user_login: userLogin,
          user_pass: accessToken,
          type: "facebook",
          userData: userData
        };
        return $.post("" + APIURL + "/authenticate", data, responseFn, "json");
      } else if (_.isObject(args[0])) {
        return $.post("" + APIURL + "/authenticate", args[0], responseFn, "json");
      }
    },
    getFacebookPicture: function() {
      return FB.api("/me/picture", {
        "redirect": false,
        "height": "200",
        "type": "normal",
        "width": "200"
      }, (function(_this) {
        return function(resp) {
          var _picture;
          if (resp && !resp.error) {
            _picture = {
              'id': 0,
              'sizes': {
                "thumbnail": {
                  "height": 150,
                  "width": 150,
                  "url": resp.data.url
                }
              }
            };
            return _this.set('profile_picture', _picture);
          }
        };
      })(this));
    }
  });

  LoginView = (function(_super) {
    __extends(LoginView, _super);

    function LoginView() {
      this.checkFbLoginStatus = __bind(this.checkFbLoginStatus, this);
      this.loginWithFacebook = __bind(this.loginWithFacebook, this);
      return LoginView.__super__.constructor.apply(this, arguments);
    }

    LoginView.prototype.template = '#login-template';

    LoginView.prototype.className = 'text-center';

    LoginView.prototype.initialize = function(opts) {
      LoginView.__super__.initialize.call(this, opts);
      return this.on('show', this.checkFbLoginStatus);
    };

    LoginView.prototype.ui = {
      fbLoginButton: '.f-login-button'
    };

    LoginView.prototype.events = {
      'click @ui.fbLoginButton': 'loginWithFacebook'
    };

    LoginView.prototype.loginWithFacebook = function(evt) {
      return FB.login((function(_this) {
        return function(response) {
          if (response.authResponse) {
            return FB.api('/me', function(user) {
              return _this.triggerMethod('facebook:login:success', user, response.authResponse.accessToken);
            });
          } else {
            return _this.triggerMethod('facebook:login:cancel');
          }
        };
      })(this), {
        scope: 'email'
      });
    };

    LoginView.prototype.checkFbLoginStatus = function() {
      if (this.ui.fbLoginButton.length === 0) {

      }
    };

    return LoginView;

  })(Marionette.ItemView);

  App.LoginCtrl = (function(_super) {
    __extends(LoginCtrl, _super);

    function LoginCtrl() {
      return LoginCtrl.__super__.constructor.apply(this, arguments);
    }

    LoginCtrl.prototype.initialize = function() {
      var loginView;
      loginView = new LoginView;
      this.listenTo(loginView, 'facebook:login:success', this._facebookAuthSuccess);
      this.listenTo(loginView, 'facebook:login:cancel', this._facebookAuthCancel);
      return this.show(loginView);
    };

    LoginCtrl.prototype._facebookAuthSuccess = function() {
      var args, _ref;
      args = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
      return (_ref = App.currentUser).authenticate.apply(_ref, ['facebook'].concat(__slice.call(args)));
    };

    LoginCtrl.prototype._facebookAuthCancel = function() {
      return App.currentUser.trigger('user:auth:cancel');
    };

    return LoginCtrl;

  })(Ajency.LoginCtrl);

}).call(this);
