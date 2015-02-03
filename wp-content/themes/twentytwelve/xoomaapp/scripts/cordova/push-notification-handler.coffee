	#Push Notification Handler

	onNotificationGCM = (e)->

		console.log 'Received notification for Android'
		console.log e


	onNotificationAPN = (e)->

		console.log 'Received notification for iOS'
		alert JSON.stringify(e)


	Push = 


		register : ->

			defer = $.Deferred()

			parsePlugin.initialize APP_ID, CLIENT_KEY, ->
				defer.resolve Push.bindPushNotificationEvents()
			, (e)->
				defer.reject e

			defer.promise()


		bindPushNotificationEvents : ->

			@pushNotification = window.plugins.pushNotification

			if CordovaApp.isPlatformAndroid() then @bindGCMEventListener()
			else if CordovaApp.isPlatformIOS() then @bindAPNSEventListener()
			else console.log "Unknown Platform"


		bindGCMEventListener : ->

			@pushNotification.register (result)->
				console.log 'Android event success'
			, (error)->
				console.log 'Android event error'

			,{ "senderID":"dummy", "ecb":"onNotificationGCM" }


		bindAPNSEventListener : ->

			@pushNotification.register (result)->
				console.log 'iOS event success'
			, (error)->
				console.log 'iOS event error'
				
			,{ "badge":"true", "sound":"true", "alert":"true", "ecb":"onNotificationAPN" }

