

class XoomaAppRootView extends Marionette.LayoutView
	template : '<div>Some extra markup here</div>
				<div ui-region></div>'

class LoginLayoutView extends Marionette.ItemView
	template : 'Universitites view'


class App.Login1Ctrl extends Ajency.RegionController
	initialize: (options)->
		@show new XoomaAppRootView

class App.UniversitiesCtrl extends Ajency.RegionController
	
	initialize : (options = {})->
		params = Marionette.getOption @, 'stateParams'
		@show new LoginLayoutView



