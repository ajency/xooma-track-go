#start of the application

window.App = new Marionette.Application



@mainRegion =  new Marionette.Region el : '#main-region'
@profileapp = new Xoomapp.MeasurementController region : @mainRegion









App.start()