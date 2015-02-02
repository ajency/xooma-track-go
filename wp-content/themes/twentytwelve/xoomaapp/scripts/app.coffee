#start of the Application
document.addEventListener "deviceready", ->
	
	App.state 'login'

		.state 'xooma',
				url : '/'
		.state 'home',
				url : '/home'
				parent : 'xooma'
				sections : 
					'x2o' : 
						ctrl : 'HomeX2OCtrl'
					'other-products' : 
						ctrl : 'HomeOtherProductsCtrl'
						
			

	App.onBeforeStart = ->
		console.log App.currentUser
		App.currentUser.set userData
		if not App.currentUser.isLoggedIn()
			App.currentUser.setNotLoggedInCapabilities()

	App.currentUser.on 'user:auth:success', ->
		# App.trigger 'fb:status:connected'
		
		#Device
		CordovaStorage.setUserData App.currentUser.toJSON() 
		ParseCloud.register()
		.done ->
			App.navigate '#'+App.currentUser.get('state'), replace: true, trigger: true

	App.currentUser.on 'user:logged:out', ->
		#Device
		ParseCloud.deregister()
		.done ->
			CordovaStorage.clear() 
			App.navigate '/login', replace: true, trigger: true
			userData = {}


	App.state 'settings',
				url : '/settings'
				parent : 'xooma'

		.state 'home',
				url : '/home'
				parent : 'xooma'
				sections : 
					'x2o' : 
						ctrl : 'HomeX2OCtrl'
					'other-products' : 
						ctrl : 'HomeOtherProductsCtrl'

		
				

	App.addInitializer ->
		Backbone.history.start()

		#Device
		Push.register()
		.done ->

			if not App.currentUser.isLoggedIn()
				App.navigate '/login', replace: true, trigger: true
				_.hideSplashscreen()
			else 
				App.navigate '#'+App.currentUser.get('state'), replace: true, trigger: true


	App.on 'fb:status:connected', ->
		if not App.currentUser.hasProfilePicture()
			App.currentUser.getFacebookPicture()

	App.on 'cordova:hide:splash:screen', ->
		console.log "triggered"


	App.start()

, false

