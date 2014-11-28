#start of the application
XoomApp.LoginCtrl = Ajency.LoginCtrl

class ProfileView extends Marionette.LayoutView
	template : '<a class="btn btn-primary" href="#/profile/personal-info">Personal Info</a>
				<a class="btn btn-primary" href="#/profile/measurements">Measurements</a>
				<div ui-region></div>'

class XoomApp.ProfileCtrl extends Marionette.RegionController
	initialize : ->
		@show new ProfileView
		

class PersonalInfoView extends Marionette.LayoutView
	template : 'My Personal info view'

class XoomApp.PersonalInfoCtrl extends Marionette.RegionController
	initialize : ->
		@show new PersonalInfoView

class MeasurementsView extends Marionette.LayoutView
	template : 'My Measurements'

class XoomApp.MeasurementsCtrl extends Marionette.RegionController
	initialize : ->
		@show new MeasurementsView



class AppStates extends Marionette.AppStates

	appStates : 
		'login' : true
		'profile' :
			url : '/profile' 
		'personalInfo' : 
			url : '/personal-info'
			parent : 'profile'
		'measurements' : 
			parent : 'profile'


window.App = new Marionette.Application

App.addInitializer ->
	#new kendo.mobile.Application(document.body)
	@states = new AppStates app : App
	Backbone.history.start()
	@states.navigate '#/login', true

App.start()
