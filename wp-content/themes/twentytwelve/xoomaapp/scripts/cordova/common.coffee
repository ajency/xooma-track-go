#Common cordova related functions used across the project

_.mixin

	isPlatformAndroid : ->
		if device.platform.toLowerCase() is "android" then true else false


	isPlatformIOS : ->
		if device.platform.toLowerCase() is "ios" then true else false


	cordovaHideSplashscreen : ->
		navigator.splashscreen.hide()


	enableCordovaBackbuttonNavigation : ->
		navigator.app.overrideBackbutton true if navigator.app
		document.addEventListener("backbutton", _.onDeviceBackButtonClick, false)


	disableCordovaBackbuttonNavigation : ->
		navigator.app.overrideBackbutton(false)


	onDeviceBackButtonClick : ->
		currentRoute = App.getCurrentRoute()
		console.log 'Fired cordova back button event for '+currentRoute

		if currentRoute is 'login' or currentRoute is 'profile/personal-info'
			navigator.app.exitApp()
		else    
			Backbone.history.history.back()

		_.removeCordovaBackbuttonEventListener()


	removeCordovaBackbuttonEventListener : ->
		document.removeEventListener("backbutton", _.onDeviceBackButtonClick, false)
		

	onlineStatus :->
		if navigator.connection.type is Connection.NONE	then false else true


