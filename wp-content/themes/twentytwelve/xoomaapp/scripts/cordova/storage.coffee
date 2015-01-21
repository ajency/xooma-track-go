	#Cordova local storage using jQuery-Storage-API

	CordovaStorage = 

		setUserData : (data)->
			$.localStorage.set 'user_data', data

		getUserData : ->
			$.localStorage.get 'user_data'

		clear : ->
			$.localStorage.removeAll()
