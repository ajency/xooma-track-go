class XoomaAppRootView extends Marionette.LayoutView
	className : 'animated fadeIn'
	template : '#xooma-app-template'
	ui :
		ul : '.list-inline'
		link : '.link'
		logolink : '.logo_link'
	behaviors :
		ActiveLink :
			behaviorClass : Ajency.ActiveLinkBehavior

	events:
		'click a.linkhref':(e)->
			e.preventDefault()

		'click @ui.logolink':(e)->
			e.preventDefault()
			computed_url = '#'+window.location.hash.split('#')[1]
			App.navigate computed_url ,  true


	
	onShow : ->
		state = App.currentUser.get 'state'
		if state != '/home'
			@ui.link.hide()
		else
			@ui.link.show()
		@currentUserRegion.show new Ajency.CurrentUserView
											model : App.currentUser

	
	

class App.XoomaCtrl extends Ajency.RegionController
	initialize: (options)->
		@show new XoomaAppRootView


	getLLoadingView:->
		new Loading

