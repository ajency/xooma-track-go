(function() {
  var SignInView,
    extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty;

  App.state('SignIn', {
    url: '/signin',
    parent: 'xooma'
  });

  SignInView = (function(superClass) {
    extend(SignInView, superClass);

    function SignInView() {
      return SignInView.__super__.constructor.apply(this, arguments);
    }

    SignInView.prototype["class"] = 'animated fadeIn';

    SignInView.prototype.template = '#sign_in_template';

    SignInView.prototype.behaviors = {
      FormBehavior: {
        behaviorClass: Ajency.FormBehavior
      }
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

}).call(this);
