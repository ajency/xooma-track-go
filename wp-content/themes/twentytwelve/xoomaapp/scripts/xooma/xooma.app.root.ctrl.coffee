

	
class ProfilePersonalInfoView extends Marionette.ItemView
	className : 'animated fadeIn'
	template : '#profile-personal-info-template'
	modelEvents : 
		'change:profile_picture' : 'updatePicture'
	updatePicture : (model)=>
		@$('.profile-picture').attr 'src', model.get('profile_picture').sizes.thumbnail.url

class App.ProfilePersonalInfoCtrl extends Marionette.RegionController
	initialize: (options)->
		@show new ProfilePersonalInfoView model : App.currentUser

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


