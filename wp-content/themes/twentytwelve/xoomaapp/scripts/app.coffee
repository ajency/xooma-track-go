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
		App.currentUser.set window.userData
		if not App.currentUser.isLoggedIn()
			App.currentUser.setNotLoggedInCapabilities()

	App.currentUser.on 'user:auth:success', ->
		App.trigger 'fb:status:connected'
		#Device
		CordovaStorage.setUserData App.currentUser.toJSON() 
		ParseCloud.register()
		.then ->
			App.navigate '#'+App.currentUser.get('state'), replace: true, trigger: true

	App.currentUser.on 'user:logged:out', ->
		arr = []
		App.useProductColl.reset arr
		delete window.userData

		#Device
		# CordovaApp.facebookLogout()
		# .then ->
		# 	ParseCloud.deregister()
		# 	.then ->
		# 		CordovaStorage.clear()
		# 		App.currentUser.set {}
		# 		App.currentUser.loginCheck()
		# 		App.navigate '/login', replace: true, trigger: true
		
		
		


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
		# CordovaNotification.schedule 'X2O', '17:00'

		# Usage.notify.on  '$usage:notification', (event, data)->
		# 	console.log 'Event triggered'
		# 	console.log data.notificationTime
		# 	#Check condition for user login

		# Usage.track()
		
		Push.register()
		.then ->
			if not App.currentUser.isLoggedIn()
				App.navigate '/login', replace: true, trigger: true
				App.trigger 'cordova:hide:splash:screen'
			else
				App.trigger 'fb:status:connected'
				App.navigate '#'+App.currentUser.get('state'), replace: true, trigger: true


	App.on 'fb:status:connected', ->
		if not App.currentUser.hasProfilePicture()
			App.currentUser.getFacebookPicture()

	App.on 'cordova:hide:splash:screen', ->
		CordovaApp.hideSplashscreen() if window.isWebView()

	
	


	App.start()


, false


