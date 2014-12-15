

	
class ProfilePersonalInfoView extends Marionette.ItemView
	className : 'animated fadeIn'
	template : '#profile-personal-info-template'
	onShow : ->
		FB.api "/me/picture", {
				"redirect": false,
				"height": "200",
				"type": "normal",
				"width": "200"
			}, @displayProfilePicture

	displayProfilePicture :(resp)=>
		console.log resp
		@$('.profile-picture').attr 'src', resp.data.url
				
					



class App.ProfilePersonalInfoCtrl extends Marionette.RegionController
	initialize: (options)->
		@show new ProfilePersonalInfoView

class ProfileMeasurementsView extends Marionette.ItemView
	className : 'animated fadeIn'
	template : '#profile-measurements-template'

class App.ProfileMeasurementsCtrl extends Marionette.RegionController
	initialize: (options)->
		@show new ProfileMeasurementsView

class ProfileCtrlView extends Marionette.LayoutView
	className : 'animated fadeIn'
	template : '#profile-template'
	ui :
		ul : '.list-inline'
	behaviors :
		ActiveLink :
			behaviorClass : Ajency.ActiveLinkBehavior

class App.ProfileCtrl extends Marionette.RegionController
	initialize: (options)->
		@show new ProfileCtrlView

class XoomaAppRootView extends Marionette.LayoutView
	className : 'animated fadeIn'
	template : '#xooma-app-template'
	ui :
		ul : '.list-inline'
	behaviors :
		ActiveLink :
			behaviorClass : Ajency.ActiveLinkBehavior

class App.XoomaCtrl extends Marionette.RegionController
	initialize: (options)->
		@show new XoomaAppRootView


class SettingsView extends Marionette.ItemView
	className : 'animated fadeIn clearfix'
	template : '#settings-template'

class App.SettingsCtrl extends Marionette.RegionController
	initialize: (options)->
		@show new SettingsView


