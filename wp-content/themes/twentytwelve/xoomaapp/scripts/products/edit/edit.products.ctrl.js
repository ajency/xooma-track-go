var EditProductsView,
  bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  hasProp = {}.hasOwnProperty;

App.state('EditProducts', {
  url: '/product/:id/edit',
  parent: 'xooma'
});

EditProductsView = (function(superClass) {
  extend(EditProductsView, superClass);

  function EditProductsView() {
    this.valueOutput = bind(this.valueOutput, this);
    this.errorSave = bind(this.errorSave, this);
    this.successSave = bind(this.successSave, this);
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
      $(e.target).attr("clicked", "true");
      return this.saveEdit();
    },
    'keypress @ui.subtract': function(e) {
      return e.charCode >= 48 && e.charCode <= 57 || e.charCode === 44;
    },
    'change @ui.rangeSliders': function(e) {
      $('#servings_per_day_value').val($(e.target).val());
      this.valueOutput(e.currentTarget);
      return this.showReminders();
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
      $('.input-small').each(function(ind, val) {
        val.name = 'reminder_time' + ind;
        return val.id = 'reminder_time' + ind;
      });
      if (parseInt(this.model.get('frequency_value')) === 2) {
        this.selectSchdule(this.model);
      }
      return this.showReminders();
    },
    'click .save': function(e) {
      e.preventDefault();
      $(e.target).attr("clicked", "true");
      return this.saveEdit();
    },
    'click @ui.schedule': function(e) {
      $(this.ui.schedule).removeClass('btn-primary');
      $(e.target).addClass('btn-primary');
      $('#timeset').val($(e.target).attr('data-time'));
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
        $('.input-small').each(function(ind, val) {
          val.name = 'reminder_time' + ind;
          return val.id = 'reminder_time' + ind;
        });
      } else {
        $(this.ui.servings_diff).prop('disabled', false);
        this.showReminders();
      }
      this.loadCheckedData();
      if (!window.isWebView()) {
        return $('.input-small').timepicker({
          defaultTime: false
        });
      }
    },
    'change .no_of_container': function(e) {
      var cnt;
      cnt = parseInt($(e.target).val()) * parseInt(this.model.get('total'));
      $('#available').val(cnt);
      return $('.available').text(cnt);
    }
  };

  EditProductsView.prototype.saveEdit = function() {
    var check, data, product, products, sub;
    $('.loadingconusme').html('<img src="' + _SITEURL + '/wp-content/themes/twentytwelve/xoomaapp/images/ajax-loader.gif" width="40px">');
    product = parseInt(this.model.get('id'));
    products = App.currentUser.get('products');
    if ($.inArray(product, products) > -1) {
      this.saveData(this.model);
      return;
    }
    check = this.checkreminder();
    if (check === false) {
      $('.loadingconusme').html("");
      window.removeMsg();
      this.ui.responseMessage.addClass('alert alert-danger').text("Reminders data not saved!");
      $('html, body').animate({
        scrollTop: 0
      }, 'slow');
      return;
    }
    sub = this.ui.subtract.val();
    if (sub === "") {
      sub = 0;
    }
    if (parseInt($('#available').val()) > parseInt(sub)) {
      data = this.ui.form.serialize();
      product = this.model.get('id');
      return $.ajax({
        method: 'POST',
        url: APIURL + "/trackers/" + (App.currentUser.get('ID')) + "/products/" + product,
        data: data,
        success: this.successSave,
        error: this.errorSave
      });
    } else {
      $('.loadingconusme').html("");
      window.removeMsg();
      this.ui.responseMessage.addClass('alert alert-danger').text("Samples given to the customer should be less than the available size!");
      return $('html, body').animate({
        scrollTop: 0
      }, 'slow');
    }
  };

  EditProductsView.prototype.saveData = function(model) {
    var check, data, product;
    check = this.checkreminder();
    if (check === false) {
      $('.loadingconusme').html("");
      window.removeMsg();
      this.ui.responseMessage.addClass('alert alert-danger').text("Reminders data not saved!");
      $('html, body').animate({
        scrollTop: 0
      }, 'slow');
      return;
    }
    data = this.ui.form.serialize();
    product = model.get('id');
    return $.ajax({
      method: 'POST',
      url: APIURL + "/trackers/" + (App.currentUser.get('ID')) + "/products/" + product,
      data: data,
      success: this.successSave,
      error: this.errorSave
    });
  };

  EditProductsView.prototype.checkreminder = function() {
    var i, servings;
    servings = $('.servings_per_day').val();
    if ($('.servings_per_day').val() === "") {
      servings = $('#x2o').val();
    }
    i = 0;
    while (i < servings) {
      if ($('#reminder_time' + i).val() === "" && parseInt($('#reminder').val()) === 1) {
        return false;
      }
      i++;
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
        val.name = 'qty_per_servings' + ind;
        return val.id = 'qty_per_servings' + ind;
      });
      return this.showReminders();
    }
  };

  EditProductsView.prototype.selectSchdule = function(model) {
    if ($('#timeset').val() === 'Once') {
      return $('.servings_per_day option[value="1"]').prop("selected", true);
    } else {
      return $('.servings_per_day option[value="2"]').prop("selected", true);
    }
  };

  EditProductsView.prototype.showReminders = function() {
    var html1, i, servings;
    console.log($('.servings_per_day').val());
    if (parseInt($('#reminder').val()) === 1) {
      $('.reminder_div').show();
      $(this.ui.servings_diff).prop('disabled', false);
      $('#reminder_time0').removeAttr('disabled');
      servings = $('.servings_per_day').val();
      if ($('.servings_per_day').val() === "") {
        servings = $('#x2o').val();
      }
      console.log(servings);
      html1 = "";
      i = 1;
      while (i <= servings) {
        html1 += '<div class="reminder">' + $('.reminder').first().html() + '</div>';
        i++;
      }
      $('.reminder_div').text("");
      $('.reminder_div').append(html1);
      $('.input-small').each(function(ind, val) {
        val.name = 'reminder_time' + ind;
        val.id = 'reminder_time' + ind;
        if (window.isWebView()) {
          return $('#reminder_time' + ind).click(function() {
            var defaultTime, options;
            defaultTime = '1:00 AM';
            $('#reminder_time' + ind).val(defaultTime);
            options = {
              date: moment(defaultTime, 'hh:mm A').toDate(),
              mode: 'time'
            };
            return datePicker.show(options, function(time) {
              if (!_.isUndefined(time)) {
                return $('#reminder_time' + ind).val(moment(time).format('hh:mm A'));
              }
            });
          });
        }
      });
    } else {
      $('.reminder_div').hide();
      $('#reminder_time0').attr('disabled', true);
      html1 = '<div class="reminder">' + $('.reminder').first().html() + '</div>';
      $('#reminder_time0').attr('disabled', true);
      $('.reminder_div').text("");
      $('.reminder_div').append(html1);
      $('.input-small').each(function(ind, val) {
        val.name = 'reminder_time' + ind;
        val.id = 'reminder_time' + ind;
        return val.value = "";
      });
    }
    if (!window.isWebView()) {
      $('.input-small').timepicker({
        defaultTime: false
      });
    }
    if (window.isWebView()) {
      return $('.input-small').prop('readonly', true);
    }
  };

  EditProductsView.prototype.successSave = function(response, status, xhr) {
    var model, product, products;
    $('.loadingconusme').html("");
    if (xhr.status === 201) {
      product = parseInt(response[0].id);
      products = App.currentUser.get('products');
      if (typeof products === 'undefined') {
        products = [];
      }
      products = _.union(products, [product]);
      App.currentUser.set('products', _.uniq(products));
      model = new UserProductModel;
      model.set(response[0]);
      App.useProductColl.add(model, {
        merge: true
      });
    }
    if ($(".save_another").attr('clicked')) {
      App.navigate('#/products', true);
    } else {
      App.navigate('#/profile/my-products', true);
    }
    return App.trigger('cordova:set:user:data');
  };

  EditProductsView.prototype.errorSave = function(response, status, xhr) {
    $('.loadingconusme').html("");
    window.removeMsg();
    this.ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be saved due to some error!");
    return $('html, body').animate({
      scrollTop: 0
    }, 'slow');
  };

  EditProductsView.prototype.serializeData = function() {
    var data, frequecy, product, products, qty, reminder_flag, reminders, weightbmi;
    data = EditProductsView.__super__.serializeData.call(this);
    product = parseInt(this.model.get('id'));
    weightbmi = this.get_weight_bmi(this.model.get('bmi'));
    data.x2o = Math.ceil(weightbmi);
    data.defaultbmi = Math.ceil(weightbmi);
    products = App.currentUser.get('products');
    if (this.model.get('time_set') === 'asperbmi' && this.model.get('qty') !== void 0) {
      qty = this.model.get('qty');
      reminders = this.model.get('reminders');
      data.defaultbmi = qty.length;
    }
    frequecy = this.model.get('frequency_value');
    if (this.model.get('time_set') === 'Once') {
      data.anytime = '';
      data.schedule = 'disabled';
      data.once = 'btn-primary';
      data.scheduleclass = '';
    } else {
      data.anytime = 'disabled';
      data.schedule = '';
      data.anytimeclass = '';
      data.twice = 'btn-primary';
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
    weight = App.currentUser.get('weight');
    actual = 1;
    if (bmi !== void 0) {
      $.each(bmi, function(index, value) {
        var bmi_val;
        bmi_val = value['range'].split('<');
        if (parseInt(bmi_val[0]) <= parseInt(weight) && parseInt(weight) <= parseInt(bmi_val[1])) {
          return actual = value['quantity'];
        }
      });
    }
    return actual;
  };

  EditProductsView.prototype.onShow = function() {
    var container, product, products, qty, reminder_flag, weight, weightbmi;
    console.log(this.model.get('id'));
    product = parseInt(this.model.get('id'));
    products = App.currentUser.get('products');
    $('#homeDate').val(App.currentUser.get('homeDate'));
    this.checkMode();
    App.trigger('ios:header:footer:fix');
    if (!window.isWebView()) {
      $('.input-small').timepicker({
        defaultTime: false
      });
    }
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
      this.showReminders();
      this.showAnytimeData(this.model);
    } else if (parseInt(this.model.get('frequency_value')) === 2) {
      $('.anytime').hide();
      $('.asperbmi').hide();
      $('#check').val('1');
      this.selectSchdule(this.model);
      this.showReminders();
      this.showScheduleData(this.model);
    } else {
      this.ui.rangeSliders.each((function(_this) {
        return function(index, ele) {
          return _this.valueOutput(ele);
        };
      })(this));
      this.ui.rangeSliders.rangeslider({
        polyfill: false
      });
      $('.schedule_data').hide();
      $('.anytime').hide();
      if ($.inArray(product, products) === -1) {
        console.log(weightbmi = this.get_weight_bmi(this.model.get('bmi')));
        weight = Math.ceil(weightbmi);
      } else {
        qty = this.model.get('qty');
        weight = qty.length;
      }
      this.showReminders();
      this.showAnytimeData(this.model);
    }
    if ($.inArray(product, products) === -1) {
      $('.remove').hide();
      return $('.reminder_div').hide();
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
    var qty, reminders, time, timezone;
    timezone = App.currentUser.get('offset');
    qty = model.get('qty');
    reminders = model.get('reminders');
    $('.qty0 option[value="' + qty[0].qty + '"]').prop("selected", true);
    $('.when0 option[value="' + qty[0].when + '"]').prop("selected", true);
    time = moment.utc(reminders[0].time).zone(timezone).format("h:mm A");
    if (parseInt(this.model.get('reminder_flag')) !== 0) {
      $('#reminder_time0').val(time);
    }
    if (this.model.get('time_set') === 'Once') {
      return $('.second').hide();
    } else {
      $('.qty1 option[value="' + qty[1].qty + '"]').prop("selected", true);
      $('.when1 option[value="' + qty[1].when + '"]').prop("selected", true);
      time = moment.utc(reminders[1].time).zone(timezone).format("h:mm A");
      if (parseInt(this.model.get('reminder_flag')) !== 0) {
        return $('#reminder_time1').val(time);
      }
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
    var qty, reminders, timezone;
    timezone = App.currentUser.get('offset');
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
    if (parseInt(this.model.get('reminder_flag')) !== 0) {
      return $.each(reminders, function(ind, val) {
        var time;
        time = moment.utc(val.time).zone(timezone).format("h:mm A");
        return $('#reminder_time' + ind).val(time);
      });
    }
  };

  return EditProductsView;

})(Marionette.ItemView);

App.EditProductsCtrl = (function(superClass) {
  extend(EditProductsCtrl, superClass);

  function EditProductsCtrl() {
    this.erroraHandler = bind(this.erroraHandler, this);
    this.successHandler = bind(this.successHandler, this);
    return EditProductsCtrl.__super__.constructor.apply(this, arguments);
  }

  console.log("EditProductsCtrl");

  EditProductsCtrl.prototype.initialize = function(options) {
    var product, productId, productModel, products;
    if (options == null) {
      options = {};
    }
    this.show(this.parent().getLLoadingView());
    productId = this.getParams();
    product = parseInt(productId[0]);
    console.log("this is product id" + product);
    console.log("ede" + productId);
    products = App.currentUser.get('products');
    if ($.inArray(product, products) > -1 || App.productCollection.length === 0) {
      console.log("if loop");
      return $.ajax({
        method: 'GET',
        url: APIURL + "/trackers/" + (App.currentUser.get('ID')) + "/products/" + product,
        success: this.successHandler,
        error: this.erroraHandler
      });
    } else {
      console.log("else loop here: ");
      productModel = App.productCollection.where({
        id: product
      });
      console.log(productModel);
      return this._showView(productModel[0]);
    }
  };

  EditProductsCtrl.prototype._showView = function(productModel) {
    console.log("product model array");
    console.log(productModel);
    return this.show(new EditProductsView({
      model: productModel
    }));
  };

  EditProductsCtrl.prototype.successHandler = function(response, status, xhr) {
    var model, pid;
    console.log("navigates here");
    if (xhr.status === 200) {
      pid = App.productCollection.where({
        id: response.id
      });
      model = new Backbone.Model(response);
      return this._showView(model);
    } else {
      console.log("else of success handler");
      this.region = new Marionette.Region({
        el: '#edit-product-template'
      });
      return new Ajency.NothingFoundCtrl({
        region: this.region
      });
    }
  };

  EditProductsCtrl.prototype.erroraHandler = function(response, status, xhr) {
    console.log("erroraHandler here");
    return App.navigate("#/products", true);
  };

  return EditProductsCtrl;

})(Ajency.RegionController);
