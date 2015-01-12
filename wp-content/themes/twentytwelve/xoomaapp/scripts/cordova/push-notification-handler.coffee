	#Push Notification Handler

	onNotificationGCM = (e)->

		console.log 'Received notification for Android'
		console.log e


	onNotificationAPN = (e)->

		console.log 'Received notification for iOS'
		alert JSON.stringify(e)


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

			@pushNotification.register (result)->
				console.log 'registerIOS success'
			, (error)->
				console.log 'registerAndroid error'
				
			,{ "badge":"true", "sound":"true", "alert":"true", "ecb":"onNotificationAPN" }

