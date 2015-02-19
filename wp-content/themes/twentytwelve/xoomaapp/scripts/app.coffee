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
		if window.isWebView()
			window.userData = App.currentUser.toJSON()

		App.trigger 'fb:status:connected'
		
		#Device
		CordovaStorage.setUserData window.userData 
		ParseCloud.register()
		.then ->
			App.navigate '#'+App.currentUser.get('state'), replace: true, trigger: true

	
	App.currentUser.on 'user:logged:out', ->
		#Device
		CordovaApp.facebookLogout()
		.then ->
			ParseCloud.deregister()
			.then ->
				CordovaStorage.clear()
				arr = []
				App.useProductColl.reset arr
				delete window.userData
				App.navigate '/login', replace: true, trigger: true
		


	
		
				

	App.addInitializer ->

		#Device
		CordovaApp.updateXoomaMessages()
		Push.register()
		
		# CordovaNotification.schedule 'X2O', '17:00'

		# Usage.notify.on  '$usage:notification', (event, data)->
		# 	console.log 'Event triggered'
		# 	console.log data.notificationTime
		# 	#Check condition for user login

		# Usage.track()

		Backbone.history.start()
		
		


	App.on 'fb:status:connected', ->
		if not App.currentUser.hasProfilePicture()
			App.currentUser.getFacebookPicture()

	App.on 'cordova:hide:splash:screen', ->
		CordovaApp.hideSplashscreen() if window.isWebView()

	
	


	App.start()

, false


