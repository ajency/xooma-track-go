class XoomaAppRootView extends Marionette.LayoutView
	className : 'animated fadeIn'
	template : '#xooma-app-template'
	ui :
		ul : '.list-inline'
		link : '.link'
	behaviors :
		ActiveLink :
			behaviorClass : Ajency.ActiveLinkBehavior

	
		
	onShow : ->
		state = App.currentUser.get 'state'
		if state != '/home'
			@ui.link.hide()
		@currentUserRegion.show new Ajency.CurrentUserView
											model : App.currentUser

class App.XoomaCtrl extends Ajency.RegionController
	initialize: (options)->
		@show new XoomaAppRootView
