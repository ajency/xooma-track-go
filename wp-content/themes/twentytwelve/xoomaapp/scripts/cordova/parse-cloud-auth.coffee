	#Parse Cloud Registration/De-registration

	#Initialize Parse JS
	Parse.initialize APP_ID, JS_KEY

	
	ParseCloud = 

		register : ->

			defer = $.Deferred()
			userData = CordovaStorage.getUserData()

			# @getInstallationId()
			# .done (installationId)->

			Parse.Cloud.run 'registerXoomaUser', {
				'userId': userData.ID
				'installationId': '920d4b2e-4c39-4971-9a75-985380bd946f'
				} 

				, success: (result)-> 
					defer.resolve result
				, error: (error)-> 
					defer.reject error

			# , (error)->
			# 	defer.reject error

			defer.promise()


		deregister : ->

			defer = $.Deferred()
			userData = CordovaStorage.getUserData()

			# @getInstallationId()
			# .done (installationId)->

			Parse.Cloud.run 'unregisterXoomaUser', {
				'userId': userData.ID
				'installationId': '920d4b2e-4c39-4971-9a75-985380bd946f'
				}
				, success: (result)-> 
					defer.resolve result
				, error: (error)-> 
					defer.reject error

			# , (error)->
			# 	defer.reject error

			defer.promise()


		getInstallationId : ->

			defer = $.Deferred()

			defer.resolve '920d4b2e-4c39-4971-9a75-985380bd946f'

			# parsePlugin.getInstallationId (installationId)-> 
			# 	defer.resolve installationId
			# , (error) ->
			# 	defer.reject error

			defer.promise()

