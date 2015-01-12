#start of the Application
document.addEventListener "deviceready", ->

	_.enableCordovaBackbuttonNavigation()
	Push.initialize()

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
		# store the user model data in local storage here
		_.setUserData App.currentUser.toJSON()
		App.navigate '#'+App.currentUser.get('state'), true

	App.currentUser.on 'user:logged:out', ->
		window.localStorage.removeItem("user_data");
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
		_.cordovaHideSplashscreen()


	App.on 'fb:status:connected', ->
		if not App.currentUser.hasProfilePicture()
			App.currentUser.getFacebookPicture()

	App.start()

, false

