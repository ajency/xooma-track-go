#start of the application

window.App = new Marionette.Application


@mainRegion =  new Marionette.Region el : '#main-region'
@profileapp = new Xoomapp.ProfilePersonalInfoController region : @mainRegion

App.start()
new kendo.mobile.Application(document.body)