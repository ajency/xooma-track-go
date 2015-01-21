var EditProductsView,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

EditProductsView = (function(_super) {
  __extends(EditProductsView, _super);

  function EditProductsView() {
    this.valueOutput = __bind(this.valueOutput, this);
    this.erroraHandler = __bind(this.erroraHandler, this);
    this.successSave = __bind(this.successSave, this);
    this.erroraHandler = __bind(this.erroraHandler, this);
    this.successHandler = __bind(this.successHandler, this);
    return EditProductsView.__super__.constructor.apply(this, arguments);
  }

  EditProductsView.prototype.template = '#edit-product-template';

  EditProductsView.prototype.ui = {
    schedule: '.schedule',
    servings_diff: 'input[name="servings_diff"]',
    servings_per_day: '.servings_per_day',
    form: '#edit_product',
    reminder_button: '.reminder_button',
    responseMessage: '.aj-response-message',
    cancel: '.cancel',
    rangeSliders: '[data-rangeslider]',
    x2o: 'x2o',
    subtract: 'input[name="subtract"]'
  };

  EditProductsView.prototype.events = {
    'click .save_another': function(e) {
      e.preventDefault();
      return $('.save').trigger("click");
    },
    'keypress @ui.subtract': function(e) {
      return e.charCode >= 48 && e.charCode <= 57 || e.charCode === 44;
    },
    'change @ui.rangeSliders': function(e) {
      return this.valueOutput(e.currentTarget);
    },
    'click @ui.cancel': function(e) {
      return App.navigate('#/profile/my-products', true);
    },
    'click @ui.reminder_button': function(e) {
      var html1;
      $(this.ui.reminder_button).removeClass('btn-success');
      $(e.target).addClass('btn-success');
      $('#reminder').val($(e.target).attr('data-reminder'));
      html1 = '<div class="reminder">' + $('.reminder').first().html() + '</div>';
      $('.reminder_div').text("");
      $('.reminder_div').append(html1);
      $('.js__timepicker').each(function(ind, val) {
        val.name = 'reminder_time' + ind;
        return val.id = 'reminder_time' + ind;
      });
      $(this.ui.servings_per_day).trigger("change");
      console.log(this.model.get('frequency_value'));
      if (parseInt(this.model.get('frequency_value')) === 2) {
        this.selectSchdule(this.model);
      }
      return this.showReminders();
    },
    'click .save': function(e) {
      var data, product, sub;
      e.preventDefault();
      sub = this.ui.subtract.val();
      if (sub === "") {
        sub = 0;
        this.ui.subtract.val(0);
      }
      if (parseInt($('#available').val()) >= parseInt(sub)) {
        data = this.ui.form.serialize();
        product = this.model.get('id');
        return $.ajax({
          method: 'POST',
          url: "" + _SITEURL + "/wp-json/trackers/" + (App.currentUser.get('ID')) + "/products/" + product,
          data: data,
          success: this.successSave,
          error: this.errorSave
        });
      } else {
        this.ui.responseMessage.text("Value entered shoule be less than available count");
        return $('html, body').animate({
          scrollTop: 0
        }, 'slow');
      }
    },
    'click @ui.schedule': function(e) {
      $(this.ui.schedule).removeClass('btn-primary');
      $(e.target).addClass('btn-primary');
      $('#timeset').val($(e.target).attr('data-time'));
      console.log($('#timeset').val());
      if ($(e.target).attr('data-time') === 'Once') {
        $('.second').hide();
      } else {
        $('.second').show();
      }
      this.selectSchdule(this.model);
      return this.showReminders();
    },
    'click @ui.servings_diff ': function(e) {
      var html, i, servings;
      if ($(this.ui.servings_diff).prop('checked') === true) {
        $(e.target).val('1');
        $('#check').val('1');
        servings = $('.servings_per_day').val();
        html = "";
        i = 1;
        while (i <= servings) {
          html += '<div class="qtyper">' + $('.qtyper').first().html() + '</div>';
          i++;
        }
        $('.qty_per_servings_div').text("");
        $('.qty_per_servings_div').append(html);
        return $('.qty_per_servings').each(function(ind, val) {
          val.name = 'qty_per_servings' + ind;
          return val.id = 'qty_per_servings' + ind;
        });
      } else {
        $(this.ui.servings_diff).prop('val', 0);
        $('#check').val('0');
        html = '<div class="qtyper">' + $('.qtyper').first().html() + '</div>';
        $('.qty_per_servings_div').text("");
        $('.qty_per_servings_div').append(html);
        return $('.qty_per_servings').each(function(ind, val) {
          val.name = 'qty_per_servings' + ind;
          return val.id = 'qty_per_servings' + ind;
        });
      }
    },
    'change @ui.servings_per_day ': function(e) {
      var html, html1, servings;
      if (parseInt($(e.target).val()) === 1) {
        $(this.ui.servings_diff).prop('disabled', true);
        $(this.ui.servings_diff).prop('checked', false);
        $(this.ui.servings_diff).prop('val', 0);
        servings = $('.servings_per_day').val();
        html = '<div class="qtyper">' + $('.qtyper').first().html() + '</div>';
        html1 = '<div class="reminder">' + $('.reminder').first().html() + '</div>';
        $('.qty_per_servings_div').text("");
        $('.reminder_div').text("");
        $('.qty_per_servings_div').append(html);
        $('.reminder_div').append(html1);
        $('.qty_per_servings').each(function(ind, val) {
          val.name = 'qty_per_servings' + ind;
          return val.id = 'qty_per_servings' + ind;
        });
        $('.js__timepicker').each(function(ind, val) {
          val.name = 'reminder_time' + ind;
          return val.id = 'reminder_time' + ind;
        });
      } else {
        $(this.ui.servings_diff).prop('disabled', false);
        this.showReminders();
      }
      this.loadCheckedData();
      return $('.js__timepicker').pickatime();
    },
    'change .no_of_container': function(e) {
      var cnt;
      cnt = parseInt($(e.target).val()) * parseInt(this.model.get('total'));
      $('#available').val(cnt);
      return $('.available').text(cnt);
    }
  };

  EditProductsView.prototype.loadCheckedData = function() {
    var html, i, servings;
    if ($(this.ui.servings_diff).prop('checked') === true) {
      $(this.ui.servings_diff).prop('disabled', false);
      servings = $('.servings_per_day').val();
      html = "";
      i = 1;
      while (i <= servings) {
        html += '<div class="qtyper">' + $('.qtyper').first().html() + '</div>';
        i++;
      }
      $('.qty_per_servings_div').text("");
      $('.qty_per_servings_div').append(html);
      $('.qty_per_servings').each(function(ind, val) {
        console.log(val.name = 'qty_per_servings' + ind);
        return val.id = 'qty_per_servings' + ind;
      });
      return this.showReminders();
    }
  };

  EditProductsView.prototype.selectSchdule = function(model) {
    console.log($('#timeset').val());
    if ($('#timeset').val() === 'Once') {
      return $('.servings_per_day option[value="1"]').prop("selected", true);
    } else {
      $('.servings_per_day option[value="2"]').prop("selected", true);
      return console.log($('.servings_per_day').val());
    }
  };

  EditProductsView.prototype.showReminders = function() {
    var html1, i, servings;
    if (parseInt($('#reminder').val()) === 1) {
      $(this.ui.servings_diff).prop('disabled', false);
      console.log(servings = $('.servings_per_day').val());
      html1 = "";
      i = 1;
      while (i <= servings) {
        html1 += '<div class="reminder">' + $('.reminder').first().html() + '</div>';
        i++;
      }
      $('.reminder_div').text("");
      $('.reminder_div').append(html1);
      $('.js__timepicker').each(function(ind, val) {
        val.name = 'reminder_time' + ind;
        return val.id = 'reminder_time' + ind;
      });
    } else {
      html1 = '<div class="reminder">' + $('.reminder').first().html() + '</div>';
      $('.reminder_div').text("");
      $('.reminder_div').append(html1);
      $('.js__timepicker').each(function(ind, val) {
        val.name = 'reminder_time' + ind;
        return val.id = 'reminder_time' + ind;
      });
    }
    return $('.js__timepicker').pickatime();
  };

  EditProductsView.prototype.successHandler = function(response, status, xhr) {
    var products, updatedProducts;
    if (xhr.status === 200) {
      products = App.currentUser.get('products');
      response = parseInt(response);
      console.log(updatedProducts = _.without(products, response));
      console.log(App.currentUser.set('products', _.uniq(updatedProducts)));
    }
    return App.navigate('#/profile/my-products', true);
  };

  EditProductsView.prototype.erroraHandler = function(response, status, xhr) {
    this.ui.responseMessage.text("Something went wrong");
    return $('html, body').animate({
      scrollTop: 0
    }, 'slow');
  };

  EditProductsView.prototype.successSave = function(response, status, xhr) {
    var products;
    if (xhr.status === 201) {
      response = parseInt(response);
      products = App.currentUser.get('products');
      if (typeof products === 'undefined') {
        products = [];
      }
      products = _.union(products, [response]);
      App.currentUser.set('products', _.uniq(products));
    }
    if (document.activeElement.name === "save") {
      return App.navigate('#/profile/my-products', true);
    } else {
      return App.navigate('#/products', true);
    }
  };

  EditProductsView.prototype.erroraHandler = function(response, status, xhr) {
    this.ui.responseMessage.text("Could not delete the prodcut");
    return $('html, body').animate({
      scrollTop: 0
    }, 'slow');
  };

  EditProductsView.prototype.serializeData = function() {
    var data, frequecy, product, products, qty, reminder_flag, reminders, weightbmi;
    data = EditProductsView.__super__.serializeData.call(this);
    product = parseInt(this.model.get('id'));
    weightbmi = this.get_weight_bmi(this.model.get('bmi'));
    data.x2o = weightbmi;
    products = App.currentUser.get('products');
    if (this.model.get('time_set') === 'asperbmi' && this.model.get('qty') !== void 0) {
      qty = this.model.get('qty');
      reminders = this.model.get('reminders');
      data.x2o = qty.length;
      data.reminder = reminders[0].time;
    }
    frequecy = this.model.get('frequency_value');
    if (parseInt(frequecy) === 1) {
      data.anytime = '';
      data.schedule = 'disabled';
      data.anytimeclass = 'btn-primary';
      data.scheduleclass = '';
    } else {
      data.anytime = 'disabled';
      data.schedule = '';
      data.anytimeclass = '';
      data.scheduleclass = 'btn-primary';
      if (this.model.get('time_set') === 'Once') {
        data.once = 'btn-primary';
        data.twice = '';
      } else {
        data.once = '';
        data.twice = 'btn-primary';
      }
    }
    reminder_flag = this.model.get('reminder_flag');
    if (reminder_flag === void 0 || parseInt(reminder_flag) === 0 || reminder_flag === 'true') {
      data["default"] = 'btn-success';
      data.success = '';
    } else {
      data["default"] = '';
      data.success = 'btn-success';
    }
    return data;
  };

  EditProductsView.prototype.get_weight_bmi = function(bmi) {
    var actual, weight;
    console.log(bmi);
    weight = App.currentUser.get('weight');
    actual = 1;
    $.each(bmi, function(index, value) {
      var bmi_val;
      bmi_val = value['range'].split('<');
      console.log(bmi_val[0]);
      console.log(bmi_val[1]);
      if (parseInt(bmi_val[0]) <= parseInt(weight) && parseInt(weight) <= parseInt(bmi_val[1])) {
        return actual = value['quantity'];
      }
    });
    return actual;
  };

  EditProductsView.prototype.onShow = function() {
    var container, product, products, reminder_flag;
    this.checkMode();
    $('.js__timepicker').pickatime();
    this.ui.rangeSliders.each((function(_this) {
      return function(index, ele) {
        return _this.valueOutput(ele);
      };
    })(this));
    this.ui.rangeSliders.rangeslider({
      polyfill: false
    });
    $('#timeset').val(this.model.get('time_set'));
    container = this.model.get('no_of_container');
    reminder_flag = this.model.get('reminder_flag');
    $('#reminder').val(reminder_flag);
    $('.no_of_container option[value="' + container + '"]').prop("selected", true);
    if (parseInt(this.model.get('frequency_value')) === 1 && this.model.get('time_set') !== 'asperbmi') {
      $('.schedule_data').remove();
      $('.asperbmi').hide();
      $('.servings_per_day option[value="' + this.model.get('time_set') + '"]').prop("selected", true);
      if (parseInt(this.model.get('time_set')) === 1) {
        $(this.ui.servings_diff).prop('disabled', true);
      }
      $(this.ui.servings_per_day).trigger("change");
      this.showAnytimeData(this.model);
    } else if (parseInt(this.model.get('frequency_value')) === 2) {
      $('.anytime').hide();
      $('.asperbmi').hide();
      $('#check').val('1');
      this.selectSchdule(this.model);
      this.showReminders();
      this.showScheduleData(this.model);
    } else {
      $('.schedule_data').hide();
      $('.anytime').hide();
    }
    product = parseInt(this.model.get('id'));
    products = App.currentUser.get('products');
    if ($.inArray(product, products) === -1) {
      return $('.remove').hide();
    }
  };

  EditProductsView.prototype.checkMode = function() {
    var product, products;
    product = parseInt(this.model.get('id'));
    products = App.currentUser.get('products');
    if ($.inArray(product, products) === -1) {
      $('.save').text("Add");
      $('.save_another').removeClass('hidden');
      return $('.save_another').text('Add & Choose another');
    } else {
      $('.noofcontainer').hide();
      return $('.view').removeClass('hidden');
    }
  };

  EditProductsView.prototype.valueOutput = function(element) {
    return $(element).parent().find("output").html($(element).val());
  };

  EditProductsView.prototype.showScheduleData = function(model) {
    var product, products;
    product = parseInt(model.get('id'));
    products = App.currentUser.get('products');
    if ($.inArray(product, products) > -1) {
      return this.showEditScheduleData(model);
    } else {
      return this.showAddScheduleData(model);
    }
  };

  EditProductsView.prototype.showAddScheduleData = function(model) {
    var qty, whendata;
    qty = this.model.get('serving_size').split('|');
    whendata = this.model.get('when').split('|');
    $('.qty0 option[value="' + qty[0] + '"]').prop("selected", true);
    $('.when0 option[value="' + whendata[0] + '"]').prop("selected", true);
    if (this.model.get('time_set') === 'Once') {
      return $('.second').hide();
    } else {
      $('.qty1 option[value="' + qty[1] + '"]').prop("selected", true);
      return $('.when1 option[value="' + whendata[1] + '"]').prop("selected", true);
    }
  };

  EditProductsView.prototype.showEditScheduleData = function(model) {
    var qty, reminder, reminders;
    qty = model.get('qty');
    reminders = model.get('reminders');
    $('.qty0 option[value="' + qty[0].qty + '"]').prop("selected", true);
    $('.when0 option[value="' + qty[0].when + '"]').prop("selected", true);
    reminder = reminders[0].time;
    $('#reminder_time0').val(reminder);
    if (this.model.get('time_set') === 'Once') {
      return $('.second').hide();
    } else {
      $('.qty1 option[value="' + qty[1].qty + '"]').prop("selected", true);
      $('.when1 option[value="' + qty[1].when + '"]').prop("selected", true);
      reminder = reminders[1].time;
      return $('#reminder_time1').val(reminder);
    }
  };

  EditProductsView.prototype.showAnytimeData = function(model) {
    var product, products, qty;
    product = parseInt(model.get('id'));
    products = App.currentUser.get('products');
    if ($.inArray(product, products) > -1) {
      return this.showServings(model);
    } else {
      qty = model.get('serving_size').split('|');
      return $('.qty_per_servings option[value="' + qty[0] + '"]').prop("selected", true);
    }
  };

  EditProductsView.prototype.showServings = function(model) {
    var qty, reminders;
    qty = model.get('qty');
    reminders = model.get('reminders');
    if (parseInt(model.get('check')) === 1) {
      $(this.ui.servings_diff).prop('checked', true);
      $(this.ui.servings_per_day).trigger("change");
      $('#check').val(1);
      $.each(qty, function(ind, val) {
        return $('#qty_per_servings' + ind + ' option[value="' + val.qty + '"]').prop("selected", true);
      });
    } else {
      $('#qty_per_servings0 option[value="' + qty[0].qty + '"]').prop("selected", true);
    }
    return $.each(reminders, function(ind, val) {
      console.log(val.time);
      return $('#reminder_time' + ind).val(val.time);
    });
  };

  return EditProductsView;

})(Marionette.ItemView);

App.state('EditProducts', {
  url: '/products/:id/edit',
  parent: 'xooma'
});

App.EditProductsCtrl = (function(_super) {
  __extends(EditProductsCtrl, _super);

  function EditProductsCtrl() {
    this.successHandler = __bind(this.successHandler, this);
    return EditProductsCtrl.__super__.constructor.apply(this, arguments);
  }

  EditProductsCtrl.prototype.initialize = function(options) {
    var product, productId, productModel, products;
    if (options == null) {
      options = {};
    }
    productId = this.getParams();
    console.log(product = parseInt(productId[0]));
    console.log(products = App.currentUser.get('products'));
    if ($.inArray(product, products) > -1) {
      return $.ajax({
        method: 'GET',
        url: "" + _SITEURL + "/wp-json/trackers/" + (App.currentUser.get('ID')) + "/products/" + product,
        success: this.successHandler,
        error: this.erroraHandler
      });
    } else {
      productModel = App.productCollection.where({
        id: productId[0]
      });
      return this._showView(productModel[0]);
    }
  };

  EditProductsCtrl.prototype._showView = function(productModel) {
    console.log(productModel);
    return this.show(new EditProductsView({
      model: productModel
    }));
  };

  EditProductsCtrl.prototype.successHandler = function(response, status, xhr) {
    var model, pid;
    pid = App.productCollection.where({
      id: response.id
    });
    model = new Backbone.Model(response);
    return this._showView(model);
  };

  return EditProductsCtrl;

})(Ajency.RegionController);
