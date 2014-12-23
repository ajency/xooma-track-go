(function() {
  App.state('addProducts', {
    url: '/add-products',
    parent: 'xooma',
    resolve: function(stateName, params) {
      return {
        userModel: App.currentUser
      };
    }
  });

}).call(this);
