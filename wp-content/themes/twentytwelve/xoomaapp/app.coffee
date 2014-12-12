#start of the application

window.App = new Marionette.Application


@mainRegion =  new Marionette.Region el : '#main-region'
@profileapp = new Xoomapp.ProfilePersonalInfoCtrl region : @mainRegion









App.start()