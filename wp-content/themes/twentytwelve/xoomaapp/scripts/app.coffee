#start of the Application
(->
	document.addEventListener "deviceready", (->
		notificationIdAndBadgeValue = []
		cordova.plugins.notification.badge
		_.cordovaLocalStorage()
		_.enableCordovaBackbuttonNavigation()


		App.state 'login'
		
			.state 'xooma',
					url : '/'

			.state 'profile',
					url : '/profile'
					parent : 'xooma'

			.state 'ProfilePersonalInfo',
					url : '/personal-info'
					parent : 'profile'

			.state 'profileMeasurement',
					url : '/measurements'
					parent : 'profile'

			.state 'settings',
					url : '/settings'
					parent : 'xooma'

			.state 'home',
					url : '/home'

			.state 'notification',
					url : '/notification-info'

		# App.addInitializer ->
		# 	Backbone.history.start()
		# 	App.currentUser.on 'user:auth:success', ->
		# 		App.navigate '/profile', true

		App.addInitializer ->
			Backbone.history.start()
			# App.navigate '/login', true
			_.cordovaHideSplashscreen()
			
			App.navigate '/login', true

			window.plugin.notification.local.onclick = (id, state, json)->
				setbadgeValue = 0
				ids = []
				badgeValues = []
				value = _.getNotificationBadgeNumber()
				# badgeValue = window.plugin.notification.local.getDefaults().badge;

				option = JSON.parse(value)
				for i in [0..option.length-1] by 1
				
					if id is option[i].ids
						badgeValue = 0
						badge = {badge : badgeValue}
						# ids = ids[i]
						# badgeValues = badgeValues[i]
						# window.plugin.notification.local.setDefaults(badge)
						
						notificationIdAndBadgeValue.push { ids : id, badgeValues : badgeValue}
						# delete option[i];
						# notificationIdAndBadgeValue.splice(i, 1);

						_.setNotificationBadgeNumber(notificationIdAndBadgeValue)
					
					if id is '4'
						badgeValue = 0
						badge = {badge : setbadgeValue}
						window.plugin.notification.local.setDefaults(badge)
				
				# if badgeValue isnt 0
					
				# 	if id is '1'
				# 		badgeValue = 0
				# 		badge = {badge : setbadgeValue}
				# 		window.plugin.notification.local.setDefaults(badge)
					
				# 	else if id is '2'
				# 		badgeValue = 0
				# 		badge = {badge : setbadgeValue}
				# 		window.plugin.notification.local.setDefaults(badge)

				# 	else if id is '3'
				# 		badgeValue = 0
				# 		badge = {badge : setbadgeValue}
				# 		window.plugin.notification.local.setDefaults(badge)

				# 	else if id is '4'
				# 		badgeValue = 0
				# 		badge = {badge : setbadgeValue}
				# 		window.plugin.notification.local.setDefaults(badge)


					# window.plugin.notification.local.cancel(id);
				App.navigate "/notification-info", true
				$('#time_for_notification').text(JSON.parse(json).date)
				$('#Message_for_notification').text(JSON.parse(json).test)

		App.start()
	), false
).call()
	
	
