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


		updateXoomaMessages : ->
			update = false
			date = CordovaStorage.getMessages().date

			if _.isNull date
				update = true
			else
				today = moment().format 'DD/MM/YYYY'
				today = moment today, 'DD/MM/YYYY'
				message_set_date = moment date, 'DD/MM/YYYY'
				difference = today.diff message_set_date, 'days'
				update = true if difference > 7

			if update
				$.get APIURL + "/messages", (messages)->
					console.log 'Xooma Messages Updated'
					# CordovaStorage.setMessages
					# 	other: messages.other
					# 	x2o: messages.x2o
					# 	date: moment().format 'DD/MM/YYYY'

					# window.Messages = messages.other
					# window.x2oMessages = messages.x2o


		facebookLogout : ->

			defer = $.Deferred()

			facebookConnectPlugin.logout (success)->
				defer.resolve success
			, (error)->
				console.log 'facebookLogout error'
				console.log error
				defer.resolve error

			defer.promise()


