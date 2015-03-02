#start of the Application
document.addEventListener "deviceready", ->
	
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
		
		#Device
		CordovaStorage.setUserData window.userData 
		ParseCloud.register()
		.then ->
			App.navigate '#'+App.currentUser.get('state'), trigger:true , replace :true
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
					App.navigate '#login', trigger:true , replace :true


	Offline.options = 
		interceptRequests: true
		requests: true
		checks: 
			xhr: 
				url: _SITEURL+'/'


	Offline.on 'up', ->
		$('.error-connection').css display: 'none'
	
	Offline.on 'down', ->
		$('.error-connection').css display: 'block'


	#Device
	Usage.notify.on  '$usage:notification', (event, data)->
		console.log "$usage:notification triggered at #{data.notificationTime}"
		CordovaNotification.schedule "Hey user achieve your today's health goal.", data.notificationTime
				

	App.addInitializer ->

		#Device
		CordovaApp.updateXoomaMessages()
		CordovaNotification.registerPermission()
		Usage.track days:5

		Backbone.history.start();


	App.on 'fb:status:connected', ->
		if not App.currentUser.hasProfilePicture()
			App.currentUser.getFacebookPicture()

	App.on 'cordova:register:push:notification', ->
		Push.register() if window.isWebView()

	App.on 'cordova:hide:splash:screen', ->
		CordovaApp.hideSplashscreen() if window.isWebView()


	
	App.start()


, false


