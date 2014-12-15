#start of the Application

(->
	document.addEventListener "deviceready", (->
		# document.addEventListener("receivedLocalNotification", _.onReceivedLocalNotification, false);
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
					ctrl : 'ProfileMeasurementsCtrl'
					parent : 'profile'

			.state 'settings',
					url : '/settings'
					parent : 'xooma'

			.state 'notification',
					url : '/notification-info'


		App.addInitializer ->
			Backbone.history.start()
			App.navigate '/login', true
			window.plugin.notification.local.onclick = (id, state, json)->
				setbadgeValue = 0
				badgeValue = window.plugin.notification.local.getDefaults().badge;
				if badgeValue isnt 0
					
					if id is '1'
						badgeValue = 0
						badge = {badge : setbadgeValue}
						window.plugin.notification.local.setDefaults(badge)
					
					else if id is '2'
						badgeValue = 0
						badge = {badge : setbadgeValue}
						window.plugin.notification.local.setDefaults(badge)

					else if id is '3'
						badgeValue = 0
						badge = {badge : setbadgeValue}
						window.plugin.notification.local.setDefaults(badge)

					else if id is '4'
						badgeValue = 0
						badge = {badge : setbadgeValue}
						window.plugin.notification.local.setDefaults(badge)


					# window.plugin.notification.local.cancel(id);
				App.navigate "/notification-info", true
				$('#time_for_notification').text(JSON.parse(json).date)
				$('#Message_for_notification').text(JSON.parse(json).test)

		App.start()
	), false
).call()
