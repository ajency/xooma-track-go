var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

App.ProfilePersonalInfoView = (function(_super) {
  __extends(ProfilePersonalInfoView, _super);

  function ProfilePersonalInfoView() {
    return ProfilePersonalInfoView.__super__.constructor.apply(this, arguments);
  }

  ProfilePersonalInfoView.prototype.className = 'animated fadeIn';

  ProfilePersonalInfoView.prototype.template = '#profile-personal-info-template';

  ProfilePersonalInfoView.prototype.events = {
    'click .radio': function(e) {
      return $('#gender').val($('#' + e.target.id).val());
    }
  };

  ProfilePersonalInfoView.prototype.onShow = function() {
    this.$el.find("#timezone option[value='" + this.model.get('timezone') + "']").attr("selected", "selected");
    $("input[name=radio_grp][value=" + this.model.get('gender') + "]").prop('checked', true);
    $('#gender').val(this.model.get('gender'));
    jQuery.validator.addMethod("equalLength", function(value, element) {
      return this.optional(element) || (parseInt(value.length) === 6);
    }, "* Enter valid 6 digit Xooma ID");
    return $("#add_user_details").validate({
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
      submitHandler: function(form) {
        $.ajax({
          method: 'POST',
          url: _SITEURL + '/wp-json/profiles/134',
          data: $('#add_user_details').serialize(),
          success: function(response) {
            if (response.status === 404) {
              return $('.response_msg').text(response.response);
            } else {
              return $('.response_msg').text("User details saved successfully");
            }
          },
          error: function(error) {
            return $('.response_msg').text("Details could not be saved");
          }
        });
        return false;
      }
    });
  };

  return ProfilePersonalInfoView;

})(Marionette.ItemView);
