#start of the Application
jQuery(document).ready ($)->
	
	App.state 'login'

		.state 'xooma',
				url : '/'

		
						
	

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


	Offline.options = 
		interceptRequests: true
		requests: true
		checks: 
			xhr: 
				url: "#{_SITEURL}/"


	Offline.on 'confirmed-up', ->
		$('.error-connection').css display: 'none'
	
	Offline.on 'confirmed-down', ->
		$('.error-connection').css display: 'block'
				

	App.addInitializer ->
		Backbone.history.start();


	App.on 'fb:status:connected', ->
		if not App.currentUser.hasProfilePicture()
			App.currentUser.getFacebookPicture()

	App.on 'cordova:register:push:notification', ->
		Push.register() if window.isWebView()

	App.on 'cordova:set:user:data', ->
		CordovaStorage.setUserData(App.currentUser.toJSON()) if window.isWebView()

	App.on 'cordova:hide:splash:screen', ->
		CordovaApp.hideSplashscreen() if window.isWebView()


	
	App.start()

