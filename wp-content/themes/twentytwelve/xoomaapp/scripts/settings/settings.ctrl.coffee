App.state 'Settings',
					url : '/settings'
					parent : 'xooma'

class SettingsView extends Marionette.LayoutView
	className : 'animated fadeIn'
	template : '#settings-template'
	


class App.SettingsCtrl extends Ajency.RegionController
	initialize: (options)->
		@show new SettingsView
