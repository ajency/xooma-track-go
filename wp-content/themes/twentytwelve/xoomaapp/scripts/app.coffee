(->
	document.addEventListener "deviceready", (->
		notificationIdAndBadgeValue = []
		cordova.plugins.notification.badge
		_.enableCordovaBackbuttonNavigation()

		App.state 'login'

			.state 'xooma',
					url : '/'


		App.addInitializer ->
			Backbone.history.start()
			_.cordovaHideSplashscreen()
			App.currentUser.on 'user:auth:success', ->
				App.navigate App.currentUser.get('state'), true

		App.on 'fb:status:connected', ->
			if not App.currentUser.hasProfilePicture()
				App.currentUser.getFacebookPicture()

		# App.on 'state:transition:start', (evt, state, params)->
		# 	if not App.currentUser.isLoggedIn() and App.isLoggedInState stateName
		# 		evt.preventDefault()
		# 		App.navigate '#/login', true

		# 	if App.currentUser.isLoggedIn() and state.get('name') is 'login'
		# 		evt.preventDefault()
		# 		App.navigate '#/profile/personal-info', true

		App.start()


		# App.addInitializer ->
		# 	Backbone.history.start()
		# 	_.cordovaHideSplashscreen()
			
		# 	App.navigate '/login', true
		# 	# App.currentUser.on 'user:auth:success', ->
		# 		# App.navigate '/login', true
		# 		# App.navigate App.currentUser.get('state'), true

		# 	window.plugin.notification.local.onclick = (id, state, json)->
		# 		setbadgeValue = 0
		# 		ids = []
		# 		badgeValues = []
		# 		value = _.getNotificationBadgeNumber()
		# 		# badgeValue = window.plugin.notification.local.getDefaults().badge;

		# 		option = JSON.parse(value)
		# 		for i in [0..option.length-1] by 1
				
		# 			if id is option[i].ids
		# 				badgeValue = 0
		# 				badge = {badge : badgeValue}
		# 				# ids = ids[i]
		# 				# badgeValues = badgeValues[i]
		# 				# window.plugin.notification.local.setDefaults(badge)
						
		# 				notificationIdAndBadgeValue.push { ids : id, badgeValues : badgeValue}
		# 				# delete option[i];
		# 				# notificationIdAndBadgeValue.splice(i, 1);

		# 				_.setNotificationBadgeNumber(notificationIdAndBadgeValue)
					
		# 			if id is '4'
		# 				badgeValue = 0
		# 				badge = {badge : setbadgeValue}
		# 				window.plugin.notification.local.setDefaults(badge)
				
		# 		# if badgeValue isnt 0
					
		# 		# 	if id is '1'
		# 		# 		badgeValue = 0
		# 		# 		badge = {badge : setbadgeValue}
		# 		# 		window.plugin.notification.local.setDefaults(badge)
					
		# 		# 	else if id is '2'
		# 		# 		badgeValue = 0
		# 		# 		badge = {badge : setbadgeValue}
		# 		# 		window.plugin.notification.local.setDefaults(badge)

		# 		# 	else if id is '3'
		# 		# 		badgeValue = 0
		# 		# 		badge = {badge : setbadgeValue}
		# 		# 		window.plugin.notification.local.setDefaults(badge)

		# 		# 	else if id is '4'
		# 		# 		badgeValue = 0
		# 		# 		badge = {badge : setbadgeValue}
		# 		# 		window.plugin.notification.local.setDefaults(badge)


		# 			# window.plugin.notification.local.cancel(id);
		# 		App.navigate "/notification-info", true
		# 		$('#time_for_notification').text(JSON.parse(json).date)
		# 		$('#Message_for_notification').text(JSON.parse(json).test)

		# App.start()
	), false
).call()