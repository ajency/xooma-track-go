var Loading,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

Loading = (function(_super) {
  __extends(Loading, _super);

  function Loading() {
    return Loading.__super__.constructor.apply(this, arguments);
  }

  Loading.prototype.template = "<div class='loader'></div>";

  return Loading;

})(Marionette.ItemView);
