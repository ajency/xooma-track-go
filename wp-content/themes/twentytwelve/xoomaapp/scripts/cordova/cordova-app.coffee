#Common cordova related functions used across the project

	CordovaApp = 

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


		facebookLogout : ->

			defer = $.Deferred()

			facebookConnectPlugin.logout (success)->
				defer.resolve success
			, (error)->
				console.log 'facebookLogout error'
				console.log error
				defer.resolve error

			defer.promise()