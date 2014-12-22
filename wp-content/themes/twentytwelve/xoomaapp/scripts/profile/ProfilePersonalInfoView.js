(function() {
  var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  App.ProfilePersonalInfoView = (function(_super) {
    __extends(ProfilePersonalInfoView, _super);

    function ProfilePersonalInfoView() {
      this.errorHandler = __bind(this.errorHandler, this);
      this.successHandler = __bind(this.successHandler, this);
      this.formSubmitHandler = __bind(this.formSubmitHandler, this);
      return ProfilePersonalInfoView.__super__.constructor.apply(this, arguments);
    }

    ProfilePersonalInfoView.prototype.className = 'animated fadeIn';

    ProfilePersonalInfoView.prototype.template = '#profile-personal-info-template';

    ProfilePersonalInfoView.prototype.ui = {
      form: '#add_user_details',
      responseMessage: '.response_msg'
    };

    ProfilePersonalInfoView.prototype.events = {
      'click .radio': function(e) {
        return $('#gender').val($('#' + e.target.id).val());
      },
      'click #measurement': function(e) {
        return e.preventDefault();
      },
      'click #birth_date': function(e) {
        var $input, picker;
        $input = $('.js__datepicker').pickadate({
          formatSubmit: 'yyyy-mm-dd',
          clear: 'Clear date'
        });
        picker = $input.pickadate('picker');
        return picker.set('select', this.model.get('profiles').birth_date, {
          format: 'yyyy-mm-dd'
        });
      }
    };

    ProfilePersonalInfoView.prototype.onShow = function() {
      _.enableCordovaBackbuttonNavigation();
      $('#profile').parent().addClass('active');
      $('#measurement').bind('click', this.disabler);
      $('#measurement').css('cursor', 'default');
      $('#product').bind('click', this.disabler);
      $('#product').css('cursor', 'default');
      this.$el.find("#timezone option[value='" + this.model.get('profiles').timezone + "']").attr("selected", "selected");
      this.$el.find("input[name=radio_grp][value=" + this.model.get('profiles').gender + "]").prop('checked', true);
      this.$el.find('#gender').val(this.model.get('profiles').gender);
      this.ui.form.validate({
        rules: {
          xooma_member_id: {
            number: true,
            equalLength: true
          },
          phone_no: {
            number: true
          },
          radio_grp: {
            required: true
          }
        },
        submitHandler: this.formSubmitHandler
      });
      return jQuery.validator.addMethod("equalLength", function(value, element) {
        return this.optional(element) || (parseInt(value.length) === 6);
      }, "* Enter valid 6 digit Xooma ID");
    };

    ProfilePersonalInfoView.prototype.disabler = function(e) {
      e.preventDefault();
      return false;
    };

    ProfilePersonalInfoView.prototype.formSubmitHandler = function(form) {
      var _formData;
      _formData = $('#add_user_details').serialize();
      this.model.saveProfiles(_formData).done(this.successHandler).fail(this.errorHandler);
      return false;
    };

    ProfilePersonalInfoView.prototype.successHandler = function(response, status) {
      if (status === 404) {
        return this.ui.responseMessage.text(response.response);
      } else {
        return this.ui.responseMessage.text("User details saved successfully");
      }
    };

    ProfilePersonalInfoView.prototype.errorHandler = function(error) {
      return this.ui.responseMessage.text("Details could not be saved");
    };

    return ProfilePersonalInfoView;

  })(Marionette.ItemView);

}).call(this);
