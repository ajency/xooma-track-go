#start of the Application
jQuery(document).ready ($)->

	App.state 'login'

		.state 'xooma',
				url : '/'

		.state 'faq',
				url : 'faq'
				parent : 'xooma'
						
	

	App.onBeforeStart = ->
		App.currentUser.set window.userData
		if not App.currentUser.isLoggedIn()
			App.currentUser.setNotLoggedInCapabilities()

	App.currentUser.on 'user:auth:success', ->
		if window.isWebView()
			window.userData = App.currentUser.toJSON()
		App.trigger 'fb:status:connected'
		App.navigate '#'+App.currentUser.get('state'), trigger:true , replace :true

	App.currentUser.on 'user:logged:out', ->
		arr = []
		App.useProductColl.reset arr
		delete window.userData
		App.navigate '#login',trigger:true , replace :true


	Offline.on 'confirmed-up', ->
		$('.error-connection').hide()
	
	Offline.on 'confirmed-down', ->
		$('.error-connection').show()
				

	App.addInitializer ->

		Offline.options = 
			interceptRequests: true
			requests: true
			checks: 
				xhr: 
					url: _SITEURL

		Backbone.history.start();


	App.on 'fb:status:connected', ->
		if not App.currentUser.hasProfilePicture()
			App.currentUser.getFacebookPicture()

	App.on 'cordova:hide:splash:screen', ->
		console.log "triggered"


	
	App.start()

