var CordovaStorage;

CordovaStorage = {
  setUserData: function(data) {
    return $.localStorage.set('user_data', data);
  },
  getUserData: function() {
    return $.localStorage.get('user_data');
  },
  clear: function() {
    return $.localStorage.removeAll();
  }
};
