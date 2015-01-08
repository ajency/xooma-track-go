var SQLiteDatabaseController,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

SQLiteDatabaseController = (function(_super) {
  __extends(SQLiteDatabaseController, _super);

  function SQLiteDatabaseController() {
    return SQLiteDatabaseController.__super__.constructor.apply(this, arguments);
  }

  SQLiteDatabaseController.prototype.initialize = function() {
    this.db = window.sqlitePlugin.openDatabase({
      name: "xooma.db"
    });
    return this.createTable();
  };

  SQLiteDatabaseController.prototype.createTable = function() {
    return this.db.transaction(function(tx) {
      return tx.executeSql("CREATE TABLE IF NOT EXISTS product_notifications (id UNIQUE, productID INTEGER, time, type)");
    }, function(error) {
      return console.log('SQLite Error: ' + error.code);
    }, function() {
      return console.log('Created Product Notifications Table');
    });
  };

  return SQLiteDatabaseController;

})(Marionette.Controller);

App.reqres.setHandler("get:sqlite:database:controller", function() {
  return new SQLiteDatabaseController;
});
