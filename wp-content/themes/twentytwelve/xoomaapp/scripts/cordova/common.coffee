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
