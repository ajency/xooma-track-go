var UserProductListView,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

App.UserProductListCtrl = (function(_super) {
  __extends(UserProductListCtrl, _super);

  function UserProductListCtrl() {
    return UserProductListCtrl.__super__.constructor.apply(this, arguments);
  }

  UserProductListCtrl.prototype.initialize = function() {
    return this.show(new UserProductListView);
  };

  UserProductListCtrl.prototype._get_users_products = function() {
    return $.ajax({
      method: 'GET',
      url: SITEURL + '/wp-json/products',
      data: '',
      success: function(response) {
        return console.log(response);
      },
      error: function(error) {
        return $('.response_msg').text("Something went wrong");
      }
    });
  };

  return UserProductListCtrl;

})(Marionette.RegionController);

UserProductListView = (function(_super) {
  __extends(UserProductListView, _super);

  function UserProductListView() {
    return UserProductListView.__super__.constructor.apply(this, arguments);
  }

  UserProductListView.prototype.template = '#produts-template';

  UserProductListView.prototype.className = 'animated fadeIn';

  return UserProductListView;

})(Marionette.ItemView);
