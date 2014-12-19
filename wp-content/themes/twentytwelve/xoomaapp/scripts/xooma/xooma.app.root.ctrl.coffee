# class ProfileMeasurementsView extends Marionette.ItemView
# 	className : 'animated fadeIn'
# 	template : '#profile-measurements-template'

# class App.ProfileMeasurementsCtrl extends Marionette.RegionController
# 	initialize: (options)->
# 		@show new ProfileMeasurementsView

class ProfileCtrlView extends Marionette.LayoutView
	className : 'animated fadeIn'
	template : '#profile-template'
	ui :
		ul : '.list-inline'
	behaviors :
		ActiveLink :
			behaviorClass : Ajency.ActiveLinkBehavior

	onShow:->
		if window.location.hash is '#/profile/personal-info'
			$('#profile').parent().addClass 'active'
			$('#measurement').bind('click',@disabler)
			$('#measurement').css('cursor', 'default')
			$('#product').bind('click',@disabler)
			$('#product').css('cursor', 'default')
		else if window.location.hash is '#/profile/measurements'
			$('#measurement').parent().addClass 'active'
			$('#product').bind('click',@disabler)
			$('#product').css('cursor', 'default')
		else
			$('#product').parent().addClass 'active'

	disabler:(e)->
		e.preventDefault()
		return false


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

class HomeView extends Marionette.ItemView
	className : 'animated fadeIn clearfix'
	template : '#home-template'

class App.HomeCtrl extends Marionette.RegionController
	initialize: (options)->
		@show new HomeView







