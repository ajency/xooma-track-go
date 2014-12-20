
class App.ProfilePersonalInfoCtrl extends Marionette.RegionController

	initialize: (options)->
		App.currentUser.getProfile().done(@_showView).fail @errorHandler

	_showView : (userModel)=>
		@show new ProfilePersonalInfoView
							model : userModel

	errorHandler : (error)->
		@region =  new Marionette.Region el : '#nofound-template'
		new Ajency.HTTPRequestCtrl region : @region
