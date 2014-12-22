(function() {
  var __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  App.LoginCtrl = Ajency.LoginCtrl;

  App.NothingFoundCtrl = Ajency.NothingFoundCtrl;

  _.extend(Marionette.Application.prototype, {
    isLoggedInState: function(stateName) {
      var notLoggedInStates;
      notLoggedInStates = ['login'];
      return notLoggedInStates.indexOf(stateName) === -1;
    }
  });

  _.extend(Ajency.CurrentUser.prototype, {
    _getUrl: function(property) {
      return "" + _SITEURL + "/wp-json/users/" + (App.currentUser.get('ID')) + "/" + property;
    },
    saveMeasurements: function(measurements) {
      var _successHandler;
      _successHandler = (function(_this) {
        return function(resp) {
          return _this.set('measurements', measurements);
        };
      })(this);
      return $.ajax({
        method: 'PUT',
        url: this._getUrl('measurements'),
        data: measurements,
        success: _successHandler
      });
    },
    getProfile: function() {
      var deferred, _successHandler;
      deferred = Marionette.Deferred();
      _successHandler = (function(_this) {
        return function(response, status, responseCode) {
          _this.set('profile', response);
          return deferred.resolve(_this);
        };
      })(this);
      if (!this.has('profile')) {
        $.ajax({
          method: 'GET',
          url: this._getUrl('profile'),
          success: _successHandler
        });
      } else {
        deferred.resolve(this);
      }
      return deferred.promise();
    },
    saveProfile: function(profile) {
      var _successHandler;
      _successHandler = (function(_this) {
        return function(resp) {
          return _this.set('profile', profile);
        };
      })(this);
      return $.ajax({
        method: 'PUT',
        url: this._getUrl('profile'),
        data: JSON.stringify(profile),
        success: _successHandler
      });
    },
    hasProfilePicture: function() {
      var profilePicture;
      if (!this.has('profile_picture')) {
        return false;
      }
      profilePicture = this.get('profile_picture');
      return (parseInt(profilePicture.id) !== 0) || !_.isUndefined(profilePicture.type);
    }
  });

  Ajency.HTTPRequestFailView = (function(_super) {
    __extends(HTTPRequestFailView, _super);

    function HTTPRequestFailView() {
      return HTTPRequestFailView.__super__.constructor.apply(this, arguments);
    }

    HTTPRequestFailView.prototype.template = 'Request page not  Found';

    return HTTPRequestFailView;

  })(Marionette.ItemView);

  Ajency.HTTPRequestCtrl = (function(_super) {
    __extends(HTTPRequestCtrl, _super);

    function HTTPRequestCtrl() {
      return HTTPRequestCtrl.__super__.constructor.apply(this, arguments);
    }

    HTTPRequestCtrl.prototype.initialize = function(options) {
      return this.show(new Ajency.HTTPRequestFailView);
    };

    return HTTPRequestCtrl;

  })(Marionette.RegionController);

}).call(this);
