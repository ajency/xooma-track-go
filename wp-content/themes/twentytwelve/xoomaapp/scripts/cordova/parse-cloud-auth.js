var ParseCloud;

Parse.initialize(APP_ID, JS_KEY);

ParseCloud = {
  register: function() {
    var defer, userData;
    defer = $.Deferred();
    userData = CordovaStorage.getUserData();
    Parse.Cloud.run('registerXoomaUser', {
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
    return defer.promise();
  },
  deregister: function() {
    var defer, userData;
    defer = $.Deferred();
    userData = CordovaStorage.getUserData();
    Parse.Cloud.run('unregisterXoomaUser', {
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
    return defer.promise();
  },
  getInstallationId: function() {
    var defer;
    defer = $.Deferred();
    defer.resolve('920d4b2e-4c39-4971-9a75-985380bd946f');
    return defer.promise();
  }
};
