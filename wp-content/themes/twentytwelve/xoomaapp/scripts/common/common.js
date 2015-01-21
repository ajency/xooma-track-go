var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

App.LoginCtrl = Ajency.LoginCtrl;

App.NothingFoundCtrl = Ajency.NothingFoundCtrl;

Ajency.LoginView.prototype.template = '#login-template';

Ajency.FormView = (function(_super) {
  __extends(FormView, _super);

  function FormView() {
    return FormView.__super__.constructor.apply(this, arguments);
  }

  FormView.prototype.behaviors = {
    FormBehavior: {
      behaviorClass: Ajency.FormBehavior
    }
  };

  return FormView;

})(Marionette.LayoutView);

_.extend(Ajency.CurrentUser.prototype, {
  _getUrl: function(property) {
    return "" + APIURL + "/users/" + (App.currentUser.get('ID')) + "/" + property;
  },
  saveMeasurements: function(measurements) {
    var _successHandler;
    _successHandler = (function(_this) {
      return function(resp) {
        return _this.set('measurements', measurements);
      };
    })(this);
    return $.ajax({
      method: 'POST',
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
  },
  addProduct: function(id) {
    var _successHandler;
    _successHandler = (function(_this) {
      return function(response, status, xhr) {
        var products;
        if (xhr.status === 201) {
          products = _this.get('products');
          if (typeof products === 'undefined') {
            products = [];
          }
          products = _.union(products, [response]);
          return _this.set('products', products);
        }
      };
    })(this);
    return $.ajax({
      method: 'POST',
      url: this._getUrl('products'),
      data: 'productId=' + id,
      success: _successHandler
    });
  },
  getUserProducts: function() {
    var _successHandler;
    _successHandler = (function(_this) {
      return function(response, status, xhr) {
        var products, x2oArray;
        if (xhr.status === 200) {
          console.log(response[0].products);
          x2oArray = [];
          $.each(response[0].products, function(index, value) {
            return x2oArray.push(value);
          });
          App.currentUser.set('x2o', x2oArray);
          products = [];
          $.each(response, function(ind, val) {
            return $.each(val.products, function(index, value) {
              return products.push(parseInt(value.id));
            });
          });
          return _this.set('products', products);
        }
      };
    })(this);
    return $.ajax({
      method: 'GET',
      url: this._getUrl('products'),
      success: _successHandler
    });
  },
  getHomeProducts: function() {
    var _successHandler;
    _successHandler = (function(_this) {
      return function(response, status, xhr) {
        App.useProductColl = new Backbone.Collection;
        if (xhr.status === 200) {
          return $.each(response, function(index, value) {
            return $.each(value.products, function(ind, val) {
              return App.useProductColl.add(val);
            });
          });
        }
      };
    })(this);
    return $.ajax({
      method: 'GET',
      url: "" + APIURL + "/records/" + (App.currentUser.get('ID')),
      success: _successHandler
    });
  }
});

Ajency.HTTPRequestFailView = (function(_super) {
  __extends(HTTPRequestFailView, _super);

  function HTTPRequestFailView() {
    return HTTPRequestFailView.__super__.constructor.apply(this, arguments);
  }

  HTTPRequestFailView.prototype.template = 'Requested page not  Found';

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
