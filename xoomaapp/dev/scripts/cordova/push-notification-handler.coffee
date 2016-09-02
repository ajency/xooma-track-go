	#Push Notification Handler

	cordovaPushNavigation = (data)->
		switch data.type
			when 'consume'
				homeDate = App.currentUser.get 'homeDate'
				if data.title.toUpperCase() is 'X2O'
					App.navigate "#/products/#{data.productId}/bmi/#{homeDate}", true
				else
					App.navigate "#/products/#{data.productId}/consume/#{homeDate}", true

			when 'inventory'
				App.navigate "#/inventory/#{data.productId}/edit", true
			when 'New Product'
				App.navigate '#products', true


	onNotificationGCM = (e)->
		console.log 'Received notification for Android'
		console.log e
		if e.event is 'message'
			if not e.foreground
				payload = e.payload.data
				data = 
					title: payload.header
					alert: payload.message
					productId: payload.productId
					type: payload.type

				cordovaPushNavigation data

	
	onNotificationAPN = (e)->
		console.log 'Received notification for iOS'
		console.log e
		if e.foreground is "0"
			cordovaPushNavigation e


	Push = 

		register : ->
			defer = $.Deferred()
			if window.ParsePushPlugin
				ParsePushPlugin.getInstallationId ((id) ->
					# note that the javascript client has its own installation id,
					# which is different from the device installation id.
					console.log 'device installationId: ' + id
					defer.resolve Push.bindPushNotificationEvents()
				), (e) ->
					console.log 'error'
					defer.reject e
				defer.promise()
			# defer = $.Deferred()

			# Parse.initialize APP_ID, CLIENT_KEY, ->
			# 	defer.resolve Push.bindPushNotificationEvents()
			# , (e)->
			# 	defer.reject e

			# defer.promise()


		bindPushNotificationEvents : ->
			@pushNotification = window.ParsePushPlugin

			if CordovaApp.isPlatformAndroid() then @bindGCMEventListener()
			else if CordovaApp.isPlatformIOS() then @bindAPNSEventListener()
			else console.log "Unknown Platform"


		bindGCMEventListener : ->
			@pushNotification.register (result)->
				console.log 'Android event success',result
			, (error)->
				console.log 'Android event error'

			,{ "senderID":"dummy", "ecb":"onNotificationGCM","forceShow":"true" }


		bindAPNSEventListener : ->
			@pushNotification.register (result)->
				console.log 'iOS event success'
			, (error)->
				console.log 'iOS event error'
				
			,{ "badge":"true", "sound":"true", "alert":"true", "ecb":"onNotificationAPN" }

