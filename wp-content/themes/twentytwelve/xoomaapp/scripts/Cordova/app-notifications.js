(function() {
  var notificationIdAndBadgeValue;

  notificationIdAndBadgeValue = [];

  _.mixin({
    setNotificationTime: function() {
      var badgeValue, convertTo12hourFormat, current_time, date, dateValue, getNotificationTime, laterDate, scheduledTime, timeDifference, time_for_notification, time_selected, today;
      current_time = moment().format("HH:mm");
      getNotificationTime = $("#timeupdate").val();
      time_selected = moment(getNotificationTime, "HH:mm").format("HH:mm");
      today = new Date();
      date = "" + (today.getFullYear()) + "-" + (today.getMonth() + 1) + "-" + (today.getDate());
      laterDate = moment(date + " " + getNotificationTime);
      convertTo12hourFormat = laterDate.format('hh:mm:ss A');
      dateValue = laterDate.toDate();
      scheduledTime = dateValue.getTime();
      timeDifference = moment(current_time, "HH:mm").diff(moment(time_selected, "HH:mm"));
      if (timeDifference <= 0) {
        badgeValue = window.plugin.notification.local.getDefaults().badge;
        time_for_notification = new Date(scheduledTime);
        window.plugin.notification.local.add({
          id: '4',
          autoCancel: true,
          title: "Xooma Track & Go",
          message: 'Time Scheduled Gear up xooma time!',
          date: time_for_notification,
          json: JSON.stringify({
            test: "Its Xooma Time!!",
            date: convertTo12hourFormat
          }),
          badge: badgeValue
        });
      } else {
        alert("Select a valid time");
      }
      window.plugin.notification.local.ontrigger = function(id, state, json) {
        var badge;
        console.log("ontrigger");
        badgeValue = badgeValue + 1;
        badge = {
          badge: badgeValue
        };
        if (id === '4') {
          window.plugin.notification.local.setDefaults(badge);
        }
        cordova.plugins.notification.badge.configure({
          title: '%d Xooma Track & Go',
          message: 'Time Scheduled Gear up xooma time!'
        });
        return cordova.plugins.notification.badge.get(function(badge) {
          return console.log('badge number: ' + badge);
        });
      };
    },
    notificationCall: function(id) {
      var badgeValue, badgeValues, collection, concatDateAndTime, convertTo12hourFormat, convertToMilliSecs, date, getId, ids, newDate, notificationMessage, one_min, option, time, value;
      value = _.getNotificationBadgeNumber();
      ids = [];
      badgeValues = [];
      if (!_.isNull(value)) {
        option = JSON.parse(value);
        collection = new Backbone.Collection(option);
        getId = _.chain(collection.where({
          'ids': id
        })).last().value();
        if (_.isUndefined(getId)) {
          badgeValue = 0;
          notificationIdAndBadgeValue.push({
            ids: id,
            badgeValues: badgeValue
          });
          _.setNotificationBadgeNumber(notificationIdAndBadgeValue);
        } else {
          badgeValue = getId.get('badgeValues');
        }
      } else {
        badgeValue = window.plugin.notification.local.getDefaults().badge;
        notificationIdAndBadgeValue.push({
          ids: id,
          badgeValues: badgeValue
        });
        _.setNotificationBadgeNumber(notificationIdAndBadgeValue);
      }
      if (badgeValue === 0) {
        notificationMessage = 'Gear up xooma time!';
      } else {
        notificationMessage = 'Gear up xooma time! &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ' + badgeValue + ' ';
      }
      newDate = new Date();
      date = "" + (newDate.getFullYear()) + "-" + (newDate.getMonth() + 1) + "-" + (newDate.getDate());
      convertToMilliSecs = newDate.getTime();
      one_min = new Date(convertToMilliSecs + 3 * 1000);
      time = one_min.getHours() + ':' + one_min.getMinutes() + ':' + one_min.getSeconds();
      concatDateAndTime = moment(date + " " + time);
      convertTo12hourFormat = concatDateAndTime.format('hh:mm:ss A');
      window.plugin.notification.local.add({
        id: id,
        autoCancel: true,
        title: "Xooma Track & Go for product" + id + "",
        message: notificationMessage,
        badge: badgeValue,
        json: JSON.stringify({
          test: "Xooma Track & Go!!",
          date: convertTo12hourFormat
        }),
        date: time
      });
      return window.plugin.notification.local.ontrigger = function(id, state, json) {
        var badge, i, lengthOfOption, _i, _ref, _results;
        ids = [];
        badgeValues = [];
        value = _.getNotificationBadgeNumber();
        console.log("ontrigger");
        option = JSON.parse(value);
        lengthOfOption = _.size(option);
        console.log(notificationIdAndBadgeValue);
        _results = [];
        for (i = _i = 0, _ref = lengthOfOption - 1; _i <= _ref; i = _i += 1) {
          if (id === option[i].ids) {
            option[i].badgeValues = badgeValue + 1;
            badge = {
              badge: option[i].badgeValues
            };
            window.plugin.notification.local.setDefaults(badge);
            console.log(notificationIdAndBadgeValue);
            notificationIdAndBadgeValue.push({
              ids: option[i].ids,
              badgeValues: option[i].badgeValues
            });
            console.log(notificationIdAndBadgeValue);
            notificationIdAndBadgeValue.splice(i, 1);
            _results.push(_.setNotificationBadgeNumber(notificationIdAndBadgeValue));
          } else {
            _results.push(void 0);
          }
        }
        return _results;
      };
    },
    notificationCall2: function() {
      var concatDateAndTime, convertTo12hourFormat, convertToMilliSecs, date, newDate, one_min, time;
      newDate = new Date();
      date = "" + (newDate.getFullYear()) + "-" + (newDate.getMonth() + 1) + "-" + (newDate.getDate());
      convertToMilliSecs = newDate.getTime();
      one_min = new Date(convertToMilliSecs + 3 * 1000);
      time = one_min.getHours() + ':' + one_min.getMinutes() + ':' + one_min.getSeconds();
      concatDateAndTime = moment(date + " " + time);
      convertTo12hourFormat = concatDateAndTime.format('hh:mm:ss A');
      window.plugin.notification.local.add({
        id: id,
        autoCancel: true,
        title: "Xooma Track & Go for product" + id + "",
        message: notificationMessage,
        badge: badgeValue,
        json: JSON.stringify({
          test: "Xooma Track & Go!!",
          date: convertTo12hourFormat
        }),
        date: time
      });
      window.plugin.notification.local.isScheduled(id, function() {
        console.log("data");
        parseInt(id);
        return cordova.plugins.notification.badge.set(parseInt(id));
      });
      return window.plugin.notification.local.ontrigger = function(id, state, json) {
        var badgeValues, ids, value;
        ids = [];
        badgeValues = [];
        value = _.getNotificationBadgeNumber();
        return console.log("ontrigger");
      };
    }
  });

}).call(this);
