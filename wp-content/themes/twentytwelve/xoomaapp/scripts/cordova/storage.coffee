	#Cordova local storage using jQuery-Storage-API

	CordovaStorage = 

		setUserData : (data)->
			$.localStorage.set 'user_data', data

		getUserData : ->
			$.localStorage.get 'user_data'

		clearUserData : ->
			$.localStorage.remove 'user_data'

		setMessages : (data)->
			$.localStorage.set 'xooma_messages', data

		getMessages : ->
			$.localStorage.get 'xooma_messages'

		publishFeedDialog : (action, bool)->
			switch action
				when 'get'
					$.localStorage.get 'publish_feed_dialog'
				when 'set'
					$.localStorage.set 'publish_feed_dialog', bool
				when 'init'
					if _.isNull $.localStorage.get('publish_feed_dialog')
						$.localStorage.set 'publish_feed_dialog', true