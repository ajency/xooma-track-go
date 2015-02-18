var CordovaNotification;

CordovaNotification = {
  schedule: function(message, time) {
    return window.plugin.notification.local.schedule({
      id: '111',
      message: message,
      date: this.triggerDate(time),
      autoCancel: true,
      icon: 'icon',
      smallIcon: 'icon'
    });
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
  }
};
