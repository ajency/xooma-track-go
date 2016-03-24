var SettingsView,
  bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  hasProp = {}.hasOwnProperty;

App.state('Settings', {
  url: '/settings',
  parent: 'xooma'
});

SettingsView = (function(superClass) {
  extend(SettingsView, superClass);

  function SettingsView() {
    this.successSave = bind(this.successSave, this);
    this.successnotiSave = bind(this.successnotiSave, this);
    return SettingsView.__super__.constructor.apply(this, arguments);
  }

  SettingsView.prototype.template = '#settings-template';

  SettingsView.prototype.ui = {
    notification: '#notification',
    emails: '#emails',
    responseMessage: '.aj-response-message'
  };

  SettingsView.prototype.events = {
    'click @ui.notification': function(e) {
      var data;
      $('.loadingconusme').html('<img src="' + _SITEURL + '/wp-content/themes/twentytwelve/xoomaapp/images/ajax-loader.gif" width="40px">');
      if ($(e.target).prop('checked') === true) {
        $(e.target).val('1');
        $(e.target).prop('checked', true);
      } else {
        $(e.target).val('0');
        $(e.target).prop('checked', false);
      }
      data = 'notification=' + $(e.target).val();
      return $.ajax({
        method: 'POST',
        url: _APIURL + "/notifications/" + (App.currentUser.get('ID')),
        data: data,
        success: this.successnotiSave,
        error: this.showErr
      });
    },
    'click @ui.emails': function(e) {
      var data;
      $('.loadingconusme').html('<img src="' + _SITEURL + '/wp-content/themes/twentytwelve/xoomaapp/images/ajax-loader.gif" width="40px">');
      if ($(e.target).prop('checked') === true) {
        $(e.target).val('1');
        $(e.target).prop('checked', true);
      } else {
        $(e.target).val('0');
        $(e.target).prop('checked', false);
      }
      data = 'emails=' + $(e.target).val();
      return $.ajax({
        method: 'POST',
        url: _APIURL + "/emails/" + (App.currentUser.get('ID')),
        data: data,
        success: this.successSave,
        error: this.showErr
      });
    }
  };

  SettingsView.prototype.successnotiSave = function(response, status, xhr) {
    $('.loadingconusme').html('');
    window.removeMsg();
    if (xhr.status === 201) {
      App.currentUser.set('notification', parseInt(response.notification));
      this.ui.responseMessage.addClass('alert alert-success').text("Notification alerts saved!");
      $('html, body').animate({
        scrollTop: 0
      }, 'slow');
    } else {
      this.showErr();
    }
    return App.trigger('cordova:set:user:data');
  };

  SettingsView.prototype.showErr = function() {
    $('.loadingconusme').html('');
    window.removeMsg();
    this.ui.responseMessage.addClass('alert alert-danger').text("Sorry!Data couldn't be saved!");
    return $('html, body').animate({
      scrollTop: 0
    }, 'slow');
  };

  SettingsView.prototype.successSave = function(response, status, xhr) {
    $('.loadingconusme').html('');
    window.removeMsg();
    if (xhr.status === 201) {
      App.currentUser.set('emails', parseInt(response.emails));
      this.ui.responseMessage.addClass('alert alert-success').text("Email alerts saved!");
      $('html, body').animate({
        scrollTop: 0
      }, 'slow');
    } else {
      this.showErr();
    }
    return App.trigger('cordova:set:user:data');
  };

  SettingsView.prototype.onShow = function() {
    var emails, notification;
    if (!window.isWebView()) {
      $('.notificationclass').hide();
    }
    notification = App.currentUser.get('notification');
    if (parseInt(notification) === 1) {
      this.ui.notification.prop('checked', true);
      this.ui.notification.val('1');
    } else {
      this.ui.notification.prop('checked', false);
      this.ui.notification.val('0');
    }
    emails = App.currentUser.get('emails');
    if (parseInt(emails) === 1) {
      this.ui.emails.prop('checked', true);
      return this.ui.emails.val('1');
    } else {
      this.ui.emails.prop('checked', false);
      return this.ui.emails.val('0');
    }
  };

  return SettingsView;

})(Marionette.ItemView);

App.SettingsCtrl = (function(superClass) {
  extend(SettingsCtrl, superClass);

  function SettingsCtrl() {
    return SettingsCtrl.__super__.constructor.apply(this, arguments);
  }

  SettingsCtrl.prototype.initialize = function(options) {
    return this.show(new SettingsView);
  };

  return SettingsCtrl;

})(Ajency.RegionController);
