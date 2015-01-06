(->
	document.addEventListener "deviceready", (->
		
		notificationIdAndBadgeValue = []
		_.enableCordovaBackbuttonNavigation()
		

		App.state 'login'

			.state 'xooma',
					url : '/'

			.state 'home',
				url : '/home'
				parent : 'xooma'
				sections : 
					'x2o' : 
						ctrl : 'HomeX2OCtrl'
					'other-products' : 
						ctrl : 'HomeOtherProductsCtrl'

			.state 'AddProducts',
					url : '/products'
					parent : 'xooma'

			.state 'UserProductList',
					url : '/my-products'
					parent : 'profile'

			.state 'notificationDisplay',
					url : '/notification-display'

			.state 'notification',
					url : '/notification-info'

		App.onBeforeStart = ->
			App.currentUser.set userData
			if not App.currentUser.isLoggedIn()
				App.currentUser.setNotLoggedInCapabilities()
				
				# App.currentUser.set 'caps', notLoggedInCaps


		App.currentUser.on 'user:auth:success', ->
			# App.trigger 'fb:status:connected'
			# store the user model data in local storage here
			current_user_data = App.currentUser.toJSON()
			_.setUserData(current_user_data)
			App.navigate '#'+App.currentUser.get('state'), true

		App.currentUser.on 'user:logged:out', ->
			App.navigate '/login', true
			window.localStorage.removeItem("user_data");
			userData = {}

			App.state 'settings',
					url : '/settings'
					parent : 'xooma'

				.state 'home',
					url : '/home'
					parent : 'xooma'
					sections : 
						'x2o' : 
							ctrl : 'HomeX2OCtrl'
						'other-products' : 
							ctrl : 'HomeOtherProductsCtrl'

				.state 'UserProductList',
						url : '/my-products'
						parent : 'profile'

				.state 'AddProducts',
						url : '/products'
						parent : 'xooma'

		

		App.addInitializer ->
			Backbone.history.start()
			_.cordovaHideSplashscreen()
			# App.navigate '/notification-display', true


			#this is a call back function for the notification here according to the action the user is
			#navigated to specific page
			window.plugin.notification.local.onclick = (id, state, action, json)->
				# alert("clicked on button: " + action);
				window.plugin.notification.local.clear(id);
				if action is "Action 1"
					# App.navigate '/', true
					window.plugin.notification.local.cancel(id);
					window.plugin.notification.local.add
						id:'200'
						message: "Great job! You have consumed your supplement"
					return

				else if action is "Action 2"
						window.plugin.notification.local.cancel(id);
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
						App.navigate "/notification-info", true
						$('#time_for_notification').text(JSON.parse(json).date)
						$('#Message_for_notification').text(JSON.parse(json).test)
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


							window.plugin.notification.local.cancel(id);
							App.navigate "/notification-info", true
							$('#time_for_notification').text(JSON.parse(json).date)
							$('#Message_for_notification').text(JSON.parse(json).test)

		App.on '2fb:status:connected', ->
			if not App.currentUser.hasProfilePicture()
				App.currentUser.getFacebookPicture()

		App.start()
	), false
).call()