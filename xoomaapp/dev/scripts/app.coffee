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
		App.currentUser.set window.userData
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
		else if App.getCurrentRoute() is 'signin'
				CordovaStorage.clearUserData()				
		else
			ParseCloud.deregister()
			.then ->
				CordovaApp.facebookLogout()
				.then ->
					onLogout()
					App.navigate '#login', trigger:true , replace :true
	

	if window.isWebView()
		document.addEventListener "online", ->
			if window.offlineOnAppStart
				#Hack to reload home view when app is offline at start
				window.offlineOnAppStart = false
				App.navigate '#settings', trigger:true , replace :true
				App.navigate '#home', trigger:true , replace :true
				
			$('.mm-page').removeAttr 'style'	
			$('.error-connection').css display: 'none'
		, false

		document.addEventListener "offline", ->
			if App.getCurrentRoute() is 'settings'
				$('.mm-page').css height: '100%'
				
			$('.error-connection').css display: 'block'
		, false


	#Device
	Usage.notify.on  '$usage:notification', (event, data)->
		console.log "$usage:notification triggered at #{data.notificationTime}"
		CordovaNotification.schedule "Hey user achieve your today's health goal.", data.notificationTime
				

	App.addInitializer ->

		#Device
		FastClick.attach document.body
		CordovaApp.updateXoomaMessages()
		CordovaNotification.registerPermission()
		Usage.track days:5
		if !CordovaApp.isDeviceOnline()
			window.offlineOnAppStart = true
			$('.mm-page').css height: '100%'
			$('.error-connection').css display: 'block'
			App.trigger 'cordova:hide:splash:screen'

		Backbone.history.start();


	App.on 'fb:status:connected', ->
		if not App.currentUser.hasProfilePicture()
			App.currentUser.getFacebookPicture()

	App.on 'cordova:register:push:notification', ->
		console.log 'In push notification'
		Push.register() if window.isWebView()
	# ParsePushPlugin.on 'receivePN', (pn) ->
	# 	console.log 'yo i got this push notification:' + JSON.stringify(pn)
	# 	Push.register() if window.isWebView()
		
	App.on 'cordova:set:user:data', ->
		CordovaStorage.setUserData(App.currentUser.toJSON()) if window.isWebView()

	App.on 'cordova:hide:splash:screen', ->
		CordovaApp.hideSplashscreen() if window.isWebView()

	App.on 'ios:header:footer:fix', ->
		CordovaApp.headerFooterIOSFix() if window.isWebView()

	App.on 'fb:publish:feed', (model)->
		CordovaApp.publishFbFeed(model) if window.isWebView()

	
	App.start()


, false


