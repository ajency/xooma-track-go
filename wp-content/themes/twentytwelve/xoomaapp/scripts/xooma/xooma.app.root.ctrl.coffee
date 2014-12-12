

class XoomaAppRootView extends Marionette.LayoutView
	className : 'animated zoomIn'
	template : '#xooma-app-template'
	
class App.PersonalInfoCtrl extends Ajency.RegionController
	initialize: (options)->
		@show new Marionette.ItemView template : '<div>Some profile screen here</div>'

class App.XoomaCtrl extends Marionette.RegionController
	initialize: (options)->
		@show new XoomaAppRootView
