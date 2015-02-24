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



	Offline.on 'confirmed-up', ->
		$('.error-connection').hide()

	Offline.on 'confirmed-down', ->
		$('.error-connection').show()


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

		Offline.options = 
			interceptRequests: true
			requests: true
			checks: 
				xhr: 
					url: "#{_SITEURL}"

		Backbone.history.start()


	App.on 'fb:status:connected', ->
		if not App.currentUser.hasProfilePicture()
			App.currentUser.getFacebookPicture()

	App.on 'cordova:hide:splash:screen', ->
		CordovaApp.hideSplashscreen() if window.isWebView()


	App.start()

, false



