#start of the application

window.App = new Marionette.Application



@mainRegion =  new Marionette.Region el : '#main-region'
@profileapp = new Xoomapp.ProfilePersonalInfoController region : @mainRegion
console.log Xoomapp








App.start()