(function() {
  var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  (function($) {
    var EAProgressVertical, root;
    root = this;
    EAProgressVertical = (function() {
      EAProgressVertical.prototype.change = 0.1;

      function EAProgressVertical(parent, initial, type, time, breakArray) {
        if (type == null) {
          type = 'fill';
        }
        if (time == null) {
          time = 10000;
        }
        if (breakArray == null) {
          breakArray = [0, 100];
        }
        this.animateBottle = __bind(this.animateBottle, this);
        if (breakArray[0] !== 0) {
          breakArray.unshift(0);
        }
        if (breakArray[breakArray.length - 1] !== 100) {
          breakArray.push(100);
        }
        this.breakArray = breakArray;
        this.parent = parent;
        this.parent.html('<div class="empty"></div><div class="full"></div>');
        this.progress = initial;
        this.time = time;
        this.delay = this.time * this.change / 100;
        this.type = type;
      }

      EAProgressVertical.prototype.startProgress = function() {
        var limit;
        console.log(this.delay);
        limit = this.type === 'fill' ? 100 : 0;
        return this.animateInterval = setInterval(this.animateBottle, this.delay, this.type, limit);
      };

      EAProgressVertical.prototype.stopProgress = function(returnBreak) {
        var i, returnValue;
        if (returnBreak == null) {
          returnBreak = false;
        }
        clearInterval(this.animateInterval);
        if (returnBreak) {
          returnValue = 0;
          if (this.type === 'empty') {
            i = 0;
            while (i < this.breakArray.length - 1) {
              if (this.progress > this.breakArray[i] && this.progress < this.breakArray[i + 1]) {
                returnValue = this.breakArray[i + 1];
                break;
              }
              i++;
            }
          } else {
            i = 0;
            while (i < this.breakArray.length - 1) {
              if (this.progress > this.breakArray[i] && this.progress < this.breakArray[i + 1]) {
                returnValue = this.breakArray[i];
                break;
              }
              i++;
            }
          }
          return returnValue;
        } else {
          return this.progress;
        }
      };

      EAProgressVertical.prototype.setProgress = function(progress, speed) {
        if (speed == null) {
          speed = 'fast';
        }
        if (speed === 'fast') {
          this.progress = progress;
          return this.setProgressUI();
        } else if (progress > this.progress) {
          return this.animateInterval = setInterval(this.animateBottle, this.delay, 'fill', progress);
        } else {
          return this.animateInterval = setInterval(this.animateBottle, this.delay, 'empty', progress);
        }
      };

      EAProgressVertical.prototype.animateBottle = function(direction, limit) {
        if (direction == null) {
          direction = 'fill';
        }
        if (limit == null) {
          limit = 100;
        }
        if ((direction === 'fill' && this.progress >= limit) || (direction === 'empty' && this.progress <= limit)) {
          console.log('s');
          return clearInterval(this.animateInterval);
        } else {
          if (direction === 'fill') {
            this.progress += this.change;
          } else if (direction === 'empty') {
            this.progress -= this.change;
          }
          return this.setProgressUI();
        }
      };

      EAProgressVertical.prototype.setProgressUI = function() {
        var empty, full;
        empty = 100 - this.progress;
        full = this.progress;
        this.parent.find('.empty').css('height', empty + '%');
        return this.parent.find('.full').css('height', full + '%');
      };

      return EAProgressVertical;

    })();
    return root.EAProgressVertical = EAProgressVertical;
  }).call(this, jQuery);

}).call(this);
