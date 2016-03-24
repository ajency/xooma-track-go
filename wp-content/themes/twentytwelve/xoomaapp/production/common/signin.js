var SignInView,
  bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  hasProp = {}.hasOwnProperty;

App.state('SignIn', {
  url: '/signin',
  parent: 'xooma'
});

SignInView = (function(superClass) {
  extend(SignInView, superClass);

  function SignInView() {
    this._errorHandler = bind(this._errorHandler, this);
    return SignInView.__super__.constructor.apply(this, arguments);
  }

  SignInView.prototype["class"] = 'animated fadeIn';

  SignInView.prototype.template = '#sign_in_template';

  SignInView.prototype.behaviors = {
    FormBehavior: {
      behaviorClass: Ajency.FormBehavior
    }
  };

  SignInView.prototype.ui = {
    form: '.sign-in-user',
    responseMessage: '.aj-response-message',
    reError: '.creError'
  };

  SignInView.prototype.modelEvents = {
    'change:profile_picture': 'render',
    'keypress .form-control': function(e) {
      if (e.which === 9) {
        return e.preventDefault();
      }
    }
  };

  SignInView.prototype.onFormSubmit = function(_formData) {
    $('.loadingconusme').html('<img src="' + _SITEURL + '/wp-content/themes/twentytwelve/xoomaapp/images/ajax-loader.gif" width="40px">');
    return $.ajax({
      method: 'POST',
      url: APIURL + '/users/login',
      data: JSON.stringify(_formData),
      success: this._successHandler,
      error: this._errorHandler
    });
  };

  SignInView.prototype._successHandler = function(response) {
    var display_name;
    window.userData = response;
    $('.loadingconusme').html("");
    $('.aj-response-message').addClass('alert alert-success').text("User Logged In Successfully!");
    App.currentUser.set(window.userData);
    display_name = App.currentUser.get('display_name');
    $('.display_name').text(App.currentUser.get('display_name'));
    $('.user_email').text(App.currentUser.get('user_email'));
    App.trigger('cordova:set:user:data');
    if (App.currentUser.get('state') === '/home') {
      $('.link').show();
    }
    return App.navigate('#' + App.currentUser.get('state'), true);
  };

  SignInView.prototype._errorHandler = function(response) {
    console.log(response + " -error");
    console.log(response.status + " -error");
    $('.loadingconusme').html("");
    window.removeMsg();
    this.ui.responseMessage.addClass('alert alert-danger').text("Invalid Login Credentials");
    return $('html, body').animate({
      scrollTop: 0
    }, 'slow');
  };

  return SignInView;

})(Marionette.ItemView);

App.SignInCtrl = (function(superClass) {
  extend(SignInCtrl, superClass);

  function SignInCtrl() {
    return SignInCtrl.__super__.constructor.apply(this, arguments);
  }

  SignInCtrl.prototype.initialize = function() {
    console.log("sign in");
    return this.show(new SignInView);
  };

  return SignInCtrl;

})(Ajency.RegionController);
