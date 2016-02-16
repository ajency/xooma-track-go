(function() {
  var _storage, _track_for_days, addInstances, checkTimeSlot, end, formatHour, get3MaxTimeSlots, getBestTimes, getCurrentDate, getCurrentHour, getDate, i, inSlot, inTrackingPeriod, j, notify, setTimeSlot, start, timeSlots, triggerUsageEvent, updateTimeSlot;
  window.Usage = window.Usage || {};
  _storage = $.localStorage;
  _track_for_days = 10;
  getCurrentHour = function() {
    return moment().format('HH');
  };
  getCurrentDate = function() {
    return moment().format('DD/MM/YYYY');
  };
  formatHour = function(hour) {
    return moment(hour, 'HH').format('HH');
  };
  getDate = function(dayOfWeek) {
    return moment().day(dayOfWeek).format('DD/MM/YYYY');
  };
  inTrackingPeriod = function() {
    var before, lastDay, same, statistics, today;
    statistics = _storage.get('usage_statistics');
    lastDay = moment(_.last(statistics).date, 'DD/MM/YYYY');
    today = moment(getCurrentDate(), 'DD/MM/YYYY');
    before = today.isBefore(lastDay);
    same = today.isSame(lastDay);
    return before || same;
  };
  timeSlots = [];
  for (i = j = 0; j <= 23; i = j += 1) {
    start = formatHour(i);
    end = formatHour(i + 1);
    timeSlots[i] = {
      start: start,
      end: end,
      instances: 0
    };
  }
  inSlot = function(hour) {
    var slot;
    slot = null;
    _.each(timeSlots, function(timeSlot, index) {
      var startTime;
      startTime = timeSlot.start;
      if (startTime === hour) {
        return slot = index;
      }
    });
    return slot;
  };
  setTimeSlot = function() {
    var dayOfWeek, days, k, ref, statistics;
    days = _track_for_days;
    dayOfWeek = moment().day();
    statistics = [];
    for (i = k = 0, ref = days - 1; k <= ref; i = k += 1) {
      statistics[i] = {
        date: getDate(dayOfWeek + i),
        timeSlots: JSON.parse(JSON.stringify(timeSlots))
      };
    }
    statistics[0].timeSlots[inSlot(getCurrentHour())].instances = 1;
    return _storage.set('usage_statistics', statistics);
  };
  updateTimeSlot = function() {
    var statistics;
    statistics = _storage.get('usage_statistics');
    _.each(statistics, function(usage, index) {
      var count, slot;
      if (usage.date === getCurrentDate()) {
        slot = inSlot(getCurrentHour());
        count = statistics[index].timeSlots[slot].instances;
        return statistics[index].timeSlots[slot].instances = count + 1;
      }
    });
    Usage.reset();
    return _storage.set('usage_statistics', statistics);
  };
  addInstances = function(obj) {
    var sum;
    sum = 0;
    _.each(obj, function(value) {
      return sum = sum + value.instances;
    });
    return sum;
  };
  get3MaxTimeSlots = function(obj) {
    var max3TimeSlots;
    max3TimeSlots = [];
    max3TimeSlots[0] = _.max(obj, function(num) {
      return num.instances;
    });
    obj = _.reject(obj, function(num) {
      return num.start === max3TimeSlots[0].start;
    });
    max3TimeSlots[1] = _.max(obj, function(num) {
      return num.instances;
    });
    obj = _.reject(obj, function(num) {
      return num.start === max3TimeSlots[1].start;
    });
    max3TimeSlots[2] = _.max(obj, function(num) {
      return num.instances;
    });
    return max3TimeSlots;
  };
  getBestTimes = function() {
    var groupedFrequentTimeSlots, maxInstanceTimeSlots, statistics, sumInstances;
    statistics = _storage.get('usage_statistics');
    maxInstanceTimeSlots = [];
    _.each(statistics, function(usage, index) {
      return maxInstanceTimeSlots[index] = _.max(usage.timeSlots, function(num) {
        return num.instances;
      });
    });
    maxInstanceTimeSlots = _.reject(maxInstanceTimeSlots, function(num) {
      return num.instances === 0;
    });
    if (_.size(maxInstanceTimeSlots) <= 3) {
      return maxInstanceTimeSlots;
    } else {
      groupedFrequentTimeSlots = _.groupBy(maxInstanceTimeSlots, function(num) {
        return num.start;
      });
      sumInstances = [];
      _.each(groupedFrequentTimeSlots, function(groupedObj) {
        return sumInstances.push({
          start: groupedObj[0].start,
          end: groupedObj[0].end,
          instances: addInstances(groupedObj)
        });
      });
      if (_.size(sumInstances) <= 3) {
        return sumInstances;
      } else {
        return get3MaxTimeSlots(sumInstances);
      }
    }
  };
  notify = function() {
    var bestTime, bestTimes, index, size, time;
    bestTimes = getBestTimes();
    size = _.size(bestTimes);
    index = _.random(0, size - 1);
    bestTime = bestTimes[index];
    time = bestTime.start + ":30";
    _storage.set('usage_trigger_date', getCurrentDate());
    return Usage.notify.trigger('$usage:notification', {
      notificationTime: time
    });
  };
  triggerUsageEvent = function() {
    var currentDate, difference, lastDate, lastTriggerDate;
    lastTriggerDate = _storage.get('usage_trigger_date');
    if (_.isNull(lastTriggerDate)) {
      return notify();
    } else {
      lastDate = moment(lastTriggerDate, 'DD/MM/YYYY');
      currentDate = moment(getCurrentDate(), 'DD/MM/YYYY');
      difference = currentDate.diff(lastDate, 'days');
      if (difference > 2) {
        return notify();
      }
    }
  };
  checkTimeSlot = function() {
    if (_storage.isSet('usage_statistics')) {
      if (inTrackingPeriod()) {
        return updateTimeSlot();
      } else {
        return triggerUsageEvent();
      }
    } else {
      return setTimeSlot();
    }
  };
  return (function(Usage) {
    Usage.track = function(options) {
      var days;
      if (options == null) {
        options = {};
      }
      console.log('Tracking Application Usage');
      days = options.days;
      if (days && (days === parseInt(days, 10)) && days !== 0) {
        _track_for_days = options.days;
      }
      return checkTimeSlot();
    };
    Usage.reset = function() {
      _storage.remove('usage_statistics');
      return _storage.remove('usage_trigger_date');
    };
    return Usage.notify = $(window);
  })(Usage);
})();
