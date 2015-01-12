var ScheduleView,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

App.state('Schedule', {
  url: '/products/:id/consume',
  parent: 'xooma'
});

ScheduleView = (function(_super) {
  __extends(ScheduleView, _super);

  function ScheduleView() {
    return ScheduleView.__super__.constructor.apply(this, arguments);
  }

  ScheduleView.prototype.template = '#schedule-template';

  ScheduleView.prototype.serializeData = function() {
    var data, no_servings, occurr, product_type, qty;
    data = ScheduleView.__super__.serializeData.call(this);
    console.log(data.day = moment().format("dddd"));
    console.log(data.today = moment().format("MMMM Do YYYY"));
    qty = this.model.get('qty');
    occurr = this.model.get('occurrences');
    product_type = this.model.get('product_type_name');
    no_servings = [];
    $.each(qty, function(ind, val) {
      var expected, i, occurrence, servings;
      console.log(occurrence = occurr[ind]);
      occurrence = _.has(occurrence, "occurrence");
      expected = _.has(occurrence, "expected");
      if (occurrence === true && expected === true) {
        data.classname = product_type + '_occurred_class';
      } else if (occurrence === false && expected === true) {
        data.classname = product_type + '_expected_class';
      } else if (occurrence === true && expected === false) {
        data.classname = product_type + '_bonus_class';
      }
      i = 0;
      servings = [];
      while (i < val.qty) {
        servings.push({
          classname: data.classname
        });
        i++;
      }
      no_servings.push({
        servings: servings
      });
      return data.no_servings = no_servings;
    });
    dsata.original = product_type + 'occurred_class';
    return data;
  };

  return ScheduleView;

})(Marionette.ItemView);

App.ScheduleCtrl = (function(_super) {
  __extends(ScheduleCtrl, _super);

  function ScheduleCtrl() {
    this.successHandler = __bind(this.successHandler, this);
    return ScheduleCtrl.__super__.constructor.apply(this, arguments);
  }

  ScheduleCtrl.prototype.initialize = function(options) {
    var product, productId;
    if (options == null) {
      options = {};
    }
    productId = this.getParams();
    product = parseInt(productId[0]);
    return $.ajax({
      method: 'GET',
      data: 'date=""',
      url: "" + _SITEURL + "/wp-json/intakes/" + (App.currentUser.get('ID')) + "/products/" + product,
      success: this.successHandler,
      error: this.erroraHandler
    });
  };

  ScheduleCtrl.prototype.successHandler = function(response, status, xhr) {
    var model;
    model = new Backbone.Model(response);
    return this._showView(model);
  };

  ScheduleCtrl.prototype._showView = function(productModel) {
    console.log(productModel);
    return this.show(new ScheduleView({
      model: productModel
    }));
  };

  return ScheduleCtrl;

})(Ajency.RegionController);
