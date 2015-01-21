class XoomaAppRootView extends Marionette.LayoutView
	className : 'animated fadeIn'
	template : '#xooma-app-template'
	ui :
		ul : '.list-inline'
		link : '.link'
	behaviors :
		ActiveLink :
			behaviorClass : Ajency.ActiveLinkBehavior

	events:
		'click a.linkhref':(e)->
			e.preventDefault()


	initialize:->
		@showLoader()
		@hideLoader()

	
		
	onShow : ->
		state = App.currentUser.get 'state'
		if state != '/home'
			@ui.link.hide()
		else
			@ui.link.show()
		@currentUserRegion.show new Ajency.CurrentUserView
											model : App.currentUser

	showLoader:->
		$( document ).ajaxStart  ()->
		  console.log "suru"
		  $('#loader').addClass "loader"

	hideLoader:->
		$( document ).ajaxComplete  ()->
		  console.log "surustop"
		  $('#loader').removeClass "loader"
	

class App.XoomaCtrl extends Ajency.RegionController
	initialize: (options)->
		@show new XoomaAppRootView
