var workflow,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

workflow = (function(_super) {
  __extends(workflow, _super);

  function workflow() {
    return workflow.__super__.constructor.apply(this, arguments);
  }

  workflow.prototype.template = '<div class="container"> <div class="row"> <div class="col-md-3"></div> <div class="col-md-6"> <img src="' + _SITEURL + '/wp-content/themes/twentytwelve/images/noaccess.jpg" class="center-block"/> <h4 class="text-center" >You are not allowed to view this page</h4> </div> <div class="col-md-3"></div> </div>';

  return workflow;

})(Marionette.ItemView);
