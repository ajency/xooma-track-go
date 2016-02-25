(function() {
  var SignUpView,
    extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty;

  App.state('SignUp', {
    url: '/signup',
    parent: 'xooma'
  });

  SignUpView = (function(superClass) {
    extend(SignUpView, superClass);

    function SignUpView() {
      return SignUpView.__super__.constructor.apply(this, arguments);
    }

    SignUpView.prototype.template = '#sign_up_template';

    SignUpView.prototype["class"] = 'animated fadeIn';

    SignUpView.prototype.behaviors = {
      FormBehavior: {
        behaviorClass: Ajency.FormBehavior
      }
    };

    SignUpView.prototype.ui = {
      form: '.user-sign-up',
      responseMessage: '.aj-response-message',
      dateElement: 'input[name="profile[birth_date]"]',
      xooma_member_id: '.xooma_member_id'
    };

    return SignUpView;

  })(Marionette.ItemView);

  App.SignUpCtrl = (function(superClass) {
    extend(SignUpCtrl, superClass);

    function SignUpCtrl() {
      return SignUpCtrl.__super__.constructor.apply(this, arguments);
    }

    SignUpCtrl.prototype.initialize = function() {
      return this.show(new SignUpView);
    };

    return SignUpCtrl;

  })(Ajency.RegionController);

}).call(this);
