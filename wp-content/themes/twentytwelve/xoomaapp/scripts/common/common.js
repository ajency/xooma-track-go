(function() {
  var __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  App.LoginCtrl = Ajency.LoginCtrl;

  App.NothingFoundCtrl = Ajency.NothingFoundCtrl;

  _.extend(Ajency.CurrentUser.prototype, {
    saveMeasurements: function(measurements) {
      var _successHandler;
      _successHandler = (function(_this) {
        return function(resp) {
          return _this.set('measurements', measurements);
        };
      })(this);
      return $.ajax({
        method: 'POST',
        url: "" + _SITEURL + "/wp-json/users/" + (App.currentUser.get('ID')) + "/measurements",
        data: measurements,
        success: _successHandler
      });
    },
    getFacebookPicture: function() {
      var options;
      options = {
        "redirect": false,
        "height": "200",
        "type": "normal",
        "width": "200"
      };
      return FB.api("/me/picture", options, function(resp) {
        if (resp && !resp.error) {
          return App.currentUser.set('profile_picture', {
            id: 0,
            sizes: {
              thumbnail: {
                url: resp.data.url
              }
            }
          });
        }
      });
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

}).call(this);
