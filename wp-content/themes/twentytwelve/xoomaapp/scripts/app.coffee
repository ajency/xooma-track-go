#start of the Application
jQuery(document).ready ($)->

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


	App.addInitializer ->
		Backbone.history.start()
		App.currentUser.on 'user:auth:success', ->
			App.navigate App.currentUser.get('state'), true

	App.on 'before:state:change', (args...)->
		console.log args...

	App.start()
