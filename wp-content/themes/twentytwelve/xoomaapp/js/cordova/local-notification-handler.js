var CordovaNotification;

CordovaNotification = {
  schedule: function(message, time) {
    return this.hasPermission().done((function(_this) {
      return function(granted) {
        if (granted) {
          return window.plugin.notification.local.schedule({
            id: '111',
            message: message,
            date: _this.triggerDate(time),
            autoCancel: true,
            icon: 'icon',
            smallIcon: 'icon'
          });
        }
      };
    })(this));
  },
  triggerDate: function(time) {
    var currentDate, currenttime, date, hr, min, nextDate, tomorrow, triggerTime;
    date = null;
    hr = moment().hours();
    min = moment().minutes();
    triggerTime = moment(time, 'HH:mm');
    currenttime = moment("" + hr + ":" + min, 'HH:mm');
    if (triggerTime.isAfter(currenttime)) {
      currentDate = moment().format('DD/MM/YYYY');
      date = moment("" + currentDate + " " + time, 'DD/MM/YYYY HH:mm');
    } else {
      tomorrow = moment().add(1, 'd');
      nextDate = moment(tomorrow).format('DD/MM/YYYY');
      date = moment("" + nextDate + " " + time, 'DD/MM/YYYY HH:mm');
    }
    return date.toDate();
  },
  registerPermission: function() {
    return this.hasPermission().done(function(granted) {
      if (!granted) {
        return window.plugin.notification.local.registerPermission(function(registered) {
          return console.log("Permission has been granted: " + registered);
        });
      }
    });
  },
  hasPermission: function() {
    var defer;
    defer = $.Deferred();
    window.plugin.notification.local.hasPermission(function(granted) {
      return defer.resolve(granted);
    });
    return defer.promise();
  },
  cancelAll: function() {
    return window.plugin.notification.local.cancelAll();
  }
};
