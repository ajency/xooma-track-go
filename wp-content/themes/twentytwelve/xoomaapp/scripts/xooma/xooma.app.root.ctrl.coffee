class XoomaAppRootView extends Marionette.LayoutView
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


	serializeData:->
		data = super()
		data.display_name = App.currentUser.get 'display_name'
		data.user_email  = App.currentUser.get 'user_email'
		data


	onShow:->
		if window.location.hash == ''
			App.currentUser.set {}
			@ui.link.hide()
			$('.user-data').hide()
			App.navigate('#/login',true)		
	
		
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

