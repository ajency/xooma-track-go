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
		App.currentUser.set userData
		if not App.currentUser.isLoggedIn()
			App.currentUser.setNotLoggedInCapabilities()

	
	App.currentUser.on 'user:auth:success', ->
		# App.trigger 'fb:status:connected'

		console.log 'USER AUTH'
		
		#Device
		CordovaStorage.setUserData App.currentUser.toJSON() 

		ParseCloud.register()
		.done ->
			App.navigate '#'+App.currentUser.get('state'), true


	App.currentUser.on 'user:logged:out', ->
		#Device
		ParseCloud.deregister()
		.done ->
			CordovaStorage.clear() 
			App.navigate '/login', true


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
			console.log 'register_GCM_APNS success'

			if not App.currentUser.isLoggedIn()
				App.navigate '/login', true
			else 
				console.log 'USER LOGGED IN'

			_.hideSplashscreen()
		
		_.enableDeviceBackNavigation()


	App.on 'fb:status:connected', ->
		if not App.currentUser.hasProfilePicture()
			App.currentUser.getFacebookPicture()


	App.start()

, false


