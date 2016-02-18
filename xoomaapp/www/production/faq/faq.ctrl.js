var FaqView,
  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  hasProp = {}.hasOwnProperty;

App.state('Faq', {
  url: '/faq',
  parent: 'xooma'
});

FaqView = (function(superClass) {
  extend(FaqView, superClass);

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

App.FaqCtrl = (function(superClass) {
  extend(FaqCtrl, superClass);

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
