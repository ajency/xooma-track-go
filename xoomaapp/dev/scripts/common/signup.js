(function() {
  var SignUpView,
    bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
    extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty;

  App.state('SignUp', {
    url: '/signup',
    parent: 'xooma'
  });

  SignUpView = (function(superClass) {
    extend(SignUpView, superClass);

    function SignUpView() {
      this._errorHandler = bind(this._errorHandler, this);
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
      xooma_member_id: '.xooma_member_id',
      repassword: '.repassword',
      reError: '.reError'
    };

    SignUpView.prototype.modelEvents = {
      'change:profile_picture': 'render',
      'keypress .form-control': function(e) {
        if (e.which === 9) {
          return e.preventDefault();
        }
      }
    };

    SignUpView.prototype.onShow = function() {
      var dateObj;
      if (!window.isWebView()) {
        $('#birth_date').datepicker({
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          changeMonth: true,
          maxDate: new Date(),
          yearRange: "-100:+0"
        });
      }
      if (window.isWebView()) {
        dateObj = new Date($('#birth_date').val());
        $('#birth_date').click(function() {
          var maxDate, options;
          maxDate = CordovaApp.isPlatformIOS() ? new Date() : (new Date()).valueOf();
          options = {
            mode: 'date',
            date: dateObj,
            maxDate: maxDate
          };
          datePicker.show(options, function(selectedDate) {
            var dateText;
            if (!_.isUndefined(selectedDate)) {
              dateObj = selectedDate;
              dateText = moment(dateObj).format('YYYY-MM-DD');
              $('#birth_date').val(dateText);
            }
          });
        });
      }
    };

    SignUpView.prototype.onFormSubmit = function(_formData) {
      var pass, repass;
      this.ui.reError.show().text("");
      $('.loadingconusme').html('<img src="' + _SITEURL + '/wp-content/themes/twentytwelve/xoomaapp/images/ajax-loader.gif" width="40px">');
      pass = $('#password').val();
      repass = $('#repassword').val();
      if (pass === repass && pass.length > 5) {
        return $.ajax({
          method: 'POST',
          url: APIURL + '/users/newprofile',
          data: JSON.stringify(_formData),
          success: this._successHandler,
          error: this._errorHandler
        });
      } else {
        $('.aj-response-message').removeClass('alert alert-success');
        return this.ui.reError.show().text("Passwords do not match");
      }
    };

    SignUpView.prototype._successHandler = function(response, status, xhr) {
      console.log(response);
      localStorage.setItem('user_reg_id', response);
      $('.loadingconusme').html("");
      $('.aj-response-message').addClass('alert alert-success').text("User Registered Successfully!");
      return document.location = "#/profile/personal-info";
    };

    SignUpView.prototype._errorHandler = function(response, status, xhr) {
      console.log(response.status + " -error");
      $('.loadingconusme').html("");
      window.removeMsg();
      if (response.status === 400) {
        $('.aj-response-message').removeClass('alert alert-success');
        return this.ui.reError.show().text("Email ID already exists");
      } else {
        this.ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be saved due to some error!");
        return $('html, body').animate({
          scrollTop: 0
        }, 'slow');
      }
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
