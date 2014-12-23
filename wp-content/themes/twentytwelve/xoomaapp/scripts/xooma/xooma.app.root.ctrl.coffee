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

#Changes done for platform DEVICE
class NotificationDisplayView extends Marionette.ItemView
	className : 'animated fadeIn'
	template : '#notification-display-template'

class App.NotificationDisplayCtrl extends Marionette.RegionController
	initialize: (options)->
		@show new NotificationDisplayView

class NotificationView extends Marionette.ItemView
	className : 'animated fadeIn'
	template : '#notification-info-template'

class App.NotificationCtrl extends Marionette.RegionController
	initialize: (options)->
		@show new NotificationView