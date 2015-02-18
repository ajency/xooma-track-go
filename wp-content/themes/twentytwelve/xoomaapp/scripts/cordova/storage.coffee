	#Cordova local storage using jQuery-Storage-API

	CordovaStorage = 

		setUserData : (data)->
			$.localStorage.set 'user_data', data

		getUserData : ->
			$.localStorage.get 'user_data'

		setMessages : (data)->
			$.localStorage.set 'xooma_messages', data

		getMessages : ->
			$.localStorage.get 'xooma_messages'

		clear : ->
			$.localStorage.removeAll()
