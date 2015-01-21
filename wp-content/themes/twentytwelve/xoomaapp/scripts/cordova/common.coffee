#Common cordova related functions used across the project

_.mixin
	
	isDeviceOnline : ->
		if navigator.connection.type is Connection.NONE	then false else true


	isPlatformAndroid : ->
		if device.platform.toLowerCase() is "android" then true else false


	isPlatformIOS : ->
		if device.platform.toLowerCase() is "ios" then true else false


	hideSplashscreen : ->
		setTimeout ->
			navigator.splashscreen.hide()
		, 500


	enableDeviceBackNavigation : ->

		onDeviceBackClick = ->
			currentRoute = App.getCurrentRoute()
			console.log 'Fired cordova back button event for '+currentRoute

			if currentRoute is 'login' or currentRoute is 'profile/personal-info'
				navigator.app.exitApp() if navigator.app
			else 
				Backbone.history.history.back()

			document.removeEventListener "backbutton", onDeviceBackClick, false


		navigator.app.overrideBackbutton(true) if navigator.app
		document.addEventListener "backbutton", onDeviceBackClick, false


	disableDeviceBackNavigation : ->
		navigator.app.overrideBackbutton(false) if navigator.app