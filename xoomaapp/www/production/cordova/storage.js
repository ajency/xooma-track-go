var CordovaStorage;

CordovaStorage = {
  setUserData: function(data) {
    if ($.localStorage.get('user_data') !== null) {
      data.user_email = $.localStorage.get('user_data').email;
      if ($.localStorage.get('user_data').profile_picture) {
        data.profile_picture = $.localStorage.get('user_data').profile_picture;
      }
      data.emails = 1;
    }
    return $.localStorage.set('user_data', data);
  },
  getUserData: function() {
    return $.localStorage.get('user_data');
  },
  clearUserData: function() {
    return $.localStorage.remove('user_data');
  },
  setMessages: function(data) {
    return $.localStorage.set('xooma_messages', data);
  },
  getMessages: function() {
    return $.localStorage.get('xooma_messages');
  },
  publishFeedDialog: function(action, bool) {
    switch (action) {
      case 'get':
        return $.localStorage.get('publish_feed_dialog');
      case 'set':
        return $.localStorage.set('publish_feed_dialog', bool);
      case 'init':
        if (_.isNull($.localStorage.get('publish_feed_dialog'))) {
          return $.localStorage.set('publish_feed_dialog', true);
        }
    }
  }
};
