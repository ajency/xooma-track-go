var AdminView,
  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  hasProp = {}.hasOwnProperty,
  bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

App.state('Admin', {
  url: '/user_id/:id',
  parent: 'xooma'
});

AdminView = (function(superClass) {
  extend(AdminView, superClass);

  function AdminView() {
    return AdminView.__super__.constructor.apply(this, arguments);
  }

  AdminView.prototype.template = '#admin-template';

  AdminView.prototype.onShow = function() {
    return $('.menulink').hide();
  };

  return AdminView;

})(Marionette.ItemView);

App.AdminCtrl = (function(superClass) {
  extend(AdminCtrl, superClass);

  function AdminCtrl() {
    this._successHandler = bind(this._successHandler, this);
    return AdminCtrl.__super__.constructor.apply(this, arguments);
  }

  AdminCtrl.prototype.initialize = function(options) {
    var id, user_id;
    if (options == null) {
      options = {};
    }
    $('.menulink').hide();
    user_id = this.getParams();
    id = user_id[0];
    return $.ajax({
      method: 'GET',
      url: APIURL + "/users/" + id + "/profile",
      success: this._successHandler
    });
  };

  AdminCtrl.prototype._successHandler = function(response, status, xhr) {
    var model;
    model = new Ajency.CurrentUser;
    console.log('in admin ctrl', response);
    model.set('display_name', response.display_name);
    model.set('user_email', response.user_email);
    model.set('profile', response);
    return this.show(new ProfilePersonalInfoView({
      model: model
    }));
  };

  return AdminCtrl;

})(Ajency.RegionController);