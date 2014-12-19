// Generated by CoffeeScript 1.7.1
var ProfilePersonalInfoView,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

ProfilePersonalInfoView = (function(_super) {
  __extends(ProfilePersonalInfoView, _super);

  function ProfilePersonalInfoView() {
    this.errorHandler = __bind(this.errorHandler, this);
    this.successHandler = __bind(this.successHandler, this);
    this.onFormSubmit = __bind(this.onFormSubmit, this);
    return ProfilePersonalInfoView.__super__.constructor.apply(this, arguments);
  }

  ProfilePersonalInfoView.prototype.className = 'animated fadeIn';

  ProfilePersonalInfoView.prototype.template = '#profile-personal-info-template';

  ProfilePersonalInfoView.prototype.behaviors = {
    FormBehavior: {
      behaviorClass: Ajency.FormBehavior
    }
  };

  ProfilePersonalInfoView.prototype.ui = {
    form: '#add_user_details',
    responseMessage: '.response_msg',
    dateElement: '.js__datepicker'
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
      $input = this.ui.dateElement.pickadate({
        formatSubmit: 'yyyy-mm-dd'
      });
      picker = $input.pickadate('picker');
      return picker.set('select', this.model.get('profiles').birth_date, {
        format: 'yyyy-mm-dd'
      });
    }
  };

  ProfilePersonalInfoView.prototype.onsShow = function() {
    $('#profile').parent().addClass('active');
    $('#measurement').bind('click', this.disabler);
    $('#measurement').css('cursor', 'default');
    $('#product').bind('click', this.disabler);
    $('#product').css('cursor', 'default');
    this.$el.find("#timezone option[value='" + this.model.get('profiles').timezone + "']").attr("selected", "selected");
    this.$el.find("input[name=radio_grp][value=" + this.model.get('profiles').gender + "]").prop('checked', true);
    return this.$el.find('#gender').val(this.model.get('profiles').gender);
  };

  ProfilePersonalInfoView.prototype.disabler = function(e) {
    e.preventDefault();
    return false;
  };

  ProfilePersonalInfoView.prototype.onFormSubmit = function(_formData) {
    this.model.saveProfiles(_formData).done(this.successHandler).fail(this.errorHandler);
    return false;
  };

  ProfilePersonalInfoView.prototype.successHandler = function(response, status) {
    $('#product').unbind('click', this.disabler);
    $('#measurement').css('cursor', 'pointer');
    return this.showSuccessMessage();
  };

  ProfilePersonalInfoView.prototype.errorHandler = function(error) {
    return this.ui.responseMessage.text("Details could not be saved");
  };

  return ProfilePersonalInfoView;

})(Marionette.ItemView);
