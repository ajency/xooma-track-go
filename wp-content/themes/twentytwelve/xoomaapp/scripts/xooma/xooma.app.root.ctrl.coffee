

class XoomaAppRootView extends Marionette.LayoutView
	template : '<div>Some extra markup here</div>
				<div ui-region></div>'


class App.Login1Ctrl extends Ajency.RegionController

	initialize : ->
		console.log arguments

App.controller 'XoomaAppRootCtrl', 
		
		initialize : (options)->
			@show new XoomaAppRootView

	.controller 'Root1Ctrl', 

		initialize : ->
			console.log 'Root1Ctrl'

