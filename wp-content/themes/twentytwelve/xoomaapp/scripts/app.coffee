#start of the Application

(->
	document.addEventListener "deviceready", (->

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

		App.addInitializer ->
			Backbone.history.start()
			App.navigate '/login', true
			window.plugin.notification.local.onclick = ()->
				App.navigate "/login", true
		
		App.start()
	), false
).call()
