	#Push Notification Handler

	onNotificationGCM = (e)->

		console.log 'Received notification'
		console.log e


	Push = 

		initialize : ->

			@pushNotification = window.plugins.pushNotification

			if _.isPlatformAndroid()
				@registerAndroid()
			else if _.isPlatformIOS()
				@registerIOS()


		registerAndroid : ->

			@pushNotification.register (result)->
				console.log 'registerAndroid success'
			, (error)->
				console.log 'registerAndroid error'

			,{ "senderID":"dummy", "ecb":"onNotificationGCM" }


		registerIOS : ->

