var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

App.LoginCtrl = Ajency.LoginCtrl;

App.NothingFoundCtrl = Ajency.NothingFoundCtrl;

Ajency.CurrentUserView.prototype.template = '#current-user-template';

Ajency.LoginView.prototype.template = '#login-template';

Ajency.LoginView.prototype.onShow = this.showslick;

_.extend(Ajency.LoginView.prototype, {
  onShow: function() {
    return $('.single-item').slick({
      dots: true,
      infinite: true,
      speed: 500,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true
    }, {
      autoplaySpeed: 2000
    });
  }
});

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
    var formdata, _successHandler;
    formdata = $.param(measurements);
    _successHandler = (function(_this) {
      return function(resp) {
        _this.set('measurements', measurements);
        return App.currentUser.set('weight', measurements.weight);
      };
    })(this);
    return $.ajax({
      method: 'POST',
      url: this._getUrl('measurements'),
      data: formdata,
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
    var date, _successHandler;
    date = moment().format('YYYY-MM-DD');
    _successHandler = (function(_this) {
      return function(response, status, xhr) {
        var data, dates, param, products;
        if (xhr.status === 200) {
          data = response.response;
          dates = response.graph['dates'];
          param = response.graph['param'];
          App.graph = new Backbone.Model;
          App.currentUser.set('weight', response.weight);
          App.graph.set('dates', dates);
          App.graph.set('param', param);
          App.graph.set('reg_date', response.reg_date);
          products = [];
          $.each(data, function(ind, val) {
            products.push(parseInt(val.id));
            return App.useProductColl.add(val);
          });
          return _this.set('products', products);
        }
      };
    })(this);
    return $.ajax({
      method: 'GET',
      data: 'date=' + date,
      url: this._getUrl('products'),
      success: _successHandler
    });
  },
  getHomeProducts: function() {
    var date, deferred, _successHandler;
    deferred = Marionette.Deferred();
    date = "";
    if (App.currentUser.get('homeDate') !== void 0 && App.currentUser.get('homeDate') !== "") {
      date = App.currentUser.get('homeDate');
    } else {
      console.log(date = moment().format('YYYY-MM-DD'));
      App.currentUser.set('homeDate', date);
    }
    console.log(date);
    _successHandler = (function(_this) {
      return function(response, status, xhr) {
        var data, dates, param;
        data = response.response;
        dates = response.graph['dates'];
        param = response.graph['param'];
        App.graph = new Backbone.Model;
        App.currentUser.set('weight', response.weight);
        App.graph.set('dates', dates);
        App.graph.set('param', param);
        App.graph.set('reg_date', response.reg_date);
        if (xhr.status === 200) {
          $.each(data, function(index, value) {
            return App.useProductColl.add(value);
          });
          return deferred.resolve(response);
        }
      };
    })(this);
    $.ajax({
      method: 'GET',
      data: 'date=' + date,
      url: "" + APIURL + "/records/" + (App.currentUser.get('ID')),
      success: _successHandler
    });
    return deferred.promise();
  }
});

Ajency.HTTPRequestFailView = (function(_super) {
  __extends(HTTPRequestFailView, _super);

  function HTTPRequestFailView() {
    return HTTPRequestFailView.__super__.constructor.apply(this, arguments);
  }

  HTTPRequestFailView.prototype.template = 'Requested page not Found';

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
