

class XoomaAppRootView extends Marionette.LayoutView
	className : 'animated bounceInLeft'
	template : '#xooma-app-template'
	
class App.PersonalInfoCtrl extends Ajency.RegionController
	initialize: (options)->
		@show new Marionette.ItemView template : '<div>Some profile screen here</div>'

class App.XoomaCtrl extends Ajency.RegionController
	initialize: (options)->
		@show new XoomaAppRootView
