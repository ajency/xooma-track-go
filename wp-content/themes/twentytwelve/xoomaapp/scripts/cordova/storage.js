var CordovaStorage;

CordovaStorage = {
  setUserData: function(data) {
    return $.localStorage.set('user_data', data);
  },
  getUserData: function() {
    return $.localStorage.get('user_data');
  },
  setMessages: function(data) {
    return $.localStorage.set('xooma_messages', data);
  },
  getMessages: function() {
    return $.localStorage.get('xooma_messages');
  },
  clear: function() {
    return $.localStorage.removeAll();
  }
};
