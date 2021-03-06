var FaqView,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

App.state('Faq', {
  url: '/faq',
  parent: 'xooma'
});

FaqView = (function(_super) {
  __extends(FaqView, _super);

  function FaqView() {
    return FaqView.__super__.constructor.apply(this, arguments);
  }

  FaqView.prototype.template = '#faq-template';

  FaqView.prototype.ui = {
    faqlink: '.faqlink'
  };

  FaqView.prototype.events = {
    'click @ui.faqlink': function(e) {
      var state;
      e.preventDefault();
      state = App.currentUser.get('state');
      if (state === '/home') {
        return App.navigate('#/home', {
          trigger: true,
          replace: true
        });
      } else {
        return App.navigate('#' + App.currentUser.get('state'), {
          trigger: true,
          replace: true
        });
      }
    }
  };

  return FaqView;

})(Marionette.ItemView);

App.FaqCtrl = (function(_super) {
  __extends(FaqCtrl, _super);

  function FaqCtrl() {
    return FaqCtrl.__super__.constructor.apply(this, arguments);
  }

  FaqCtrl.prototype.initialize = function(options) {
    if (options == null) {
      options = {};
    }
    console.log("aaaaaaaaaaaaaaaa");
    return this.show(new FaqView);
  };

  return FaqCtrl;

})(Ajency.RegionController);
