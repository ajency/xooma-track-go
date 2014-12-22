class XoomaAppRootView extends Marionette.LayoutView
	className : 'animated fadeIn'
	template : '#xooma-app-template'
	ui :
		ul : '.list-inline'
	behaviors :
		ActiveLink :
			behaviorClass : Ajency.ActiveLinkBehavior
	onShow : ->
		@currentUserRegion.show new Ajency.CurrentUserView
											model : App.currentUser

class App.XoomaCtrl extends Ajency.RegionController
	initialize: (options)->
		@show new XoomaAppRootView
