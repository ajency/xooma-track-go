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
        'installationId': '920d4b2e-4c39-4971-9a75-985380bd946f'
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
        'installationId': '920d4b2e-4c39-4971-9a75-985380bd946f'
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
    parsePlugin.getInstallationId(function(installationId) {
      return defer.resolve(installationId);
    }, function(error) {
      return defer.reject(error);
    });
    return defer.promise();
  }
};
