	#Parse Cloud Registration/De-registration

	#Initialize Parse JS
	Parse.initialize APP_ID, JS_KEY

	
	ParseCloud = 

		register : ->

			defer = $.Deferred()
			userData = CordovaStorage.getUserData()
			
			@getInstallationId()
			.then (installationId)->

				Parse.Cloud.run 'registerXoomaUser', {
					'userId': userData.ID
					'installationId': installationId
					} 

					, success: (result)-> 
						defer.resolve result
					, error: (error)-> 
						defer.reject error

			, (error)->
				defer.reject error

			defer.promise()


		deregister : ->

			defer = $.Deferred()
			userData = CordovaStorage.getUserData()

			@getInstallationId()
			.then (installationId)->

				Parse.Cloud.run 'unregisterXoomaUser', {
					'userId': userData.ID
					'installationId': installationId
					}
					, success: (result)-> 
						defer.resolve result
					, error: (error)-> 
						defer.reject error

			, (error)->
				defer.reject error

			defer.promise()


		getInstallationId : ->

			defer = $.Deferred()

			parsePlugin.getInstallationId (installationId)-> 
				defer.resolve installationId
			, (error) ->
				defer.reject error

			defer.promise()

