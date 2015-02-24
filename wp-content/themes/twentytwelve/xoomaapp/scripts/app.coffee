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
		, (error)->
			console.log 'ParseCloud Register Error'
			App.currentUser.logout()

	
	App.currentUser.on 'user:logged:out', ->
		#Device
		onLogout = ->
			CordovaStorage.clearUserData()
			arr = []
			App.useProductColl.reset arr
			delete window.userData

		if App.getCurrentRoute() is 'login'
			CordovaApp.facebookLogout().then onLogout
		else
			ParseCloud.deregister()
			.then ->
				CordovaApp.facebookLogout()
				.then ->
					onLogout()
					App.navigate '/login', replace: true, trigger: true


	#Device
	Usage.notify.on  '$usage:notification', (event, data)->
		console.log "$usage:notification triggered at #{data.notificationTime}"
		CordovaNotification.schedule 'Get hydrated with X2O', data.notificationTime
				

	App.addInitializer ->

		#Device
		CordovaApp.updateXoomaMessages()
		CordovaNotification.registerPermission()
		Push.register()
		Usage.track days:5

		# Offline.options = 
		# 	checks: 
		# 		xhr: 
		# 			url: "#{_SITEURL}"

		Backbone.history.start()


	App.on 'fb:status:connected', ->
		if not App.currentUser.hasProfilePicture()
			App.currentUser.getFacebookPicture()

	App.on 'cordova:hide:splash:screen', ->
		CordovaApp.hideSplashscreen() if window.isWebView()


	App.start()

, false


