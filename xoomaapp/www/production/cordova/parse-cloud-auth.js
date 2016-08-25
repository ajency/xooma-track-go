var ParseCloud;

Parse.initialize(APP_ID, JS_KEY);

ParseCloud = {
  register: function() {
    var defer, userData;
    defer = $.Deferred();
    userData = CordovaStorage.getUserData();
    this.getInstallationId().then(function(installationId) {
      return Parse.Cloud.run('registerXoomaUser', {
        'userId': userData.ID,
        'userEmail': userData.user_email,
        'installationId': installationId
      }, {
        success: function(result) {
          return defer.resolve(result);
        },
        error: function(error) {
          return defer.reject(error);
        }
      });
    }, function(error) {
      return defer.reject(error);
    });
    return defer.promise();
  },
  deregister: function() {
    var defer, userData;
    defer = $.Deferred();
    userData = CordovaStorage.getUserData();
    this.getInstallationId().then(function(installationId) {
      return Parse.Cloud.run('unregisterXoomaUser', {
        'userId': userData.ID,
        'installationId': installationId
      }, {
        success: function(result) {
          return defer.resolve(result);
        },
        error: function(error) {
          return defer.reject(error);
        }
      });
    }, function(error) {
      return defer.reject(error);
    });
    return defer.promise();
  },
  getInstallationId: function() {
    var defer;
    defer = $.Deferred();
    ParsePushPlugin.getInstallationId(function(installationId) {
      return defer.resolve(installationId);
    }, function(error) {
      return defer.reject(error);
    });
    return defer.promise();
  }
};
