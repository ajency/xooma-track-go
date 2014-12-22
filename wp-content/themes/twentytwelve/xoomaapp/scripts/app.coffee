#start of the Application
jQuery(document).ready ($)->

	App.state 'login'

		.state 'xooma',
				url : '/'

		.state 'profile',
				url : '/profile'
				parent : 'xooma'
				data:
					arule : 'SOME:ACCESS;RULES:HERE'
					trule : 'SOME:TRANSITION;RUlES:HERE'

		.state 'userPersonalInfo',
				url : '/personal-info'
				parent : 'profile'

		.state 'userMeasurement',
				url : '/measurements'
				parent : 'profile'


	App.addInitializer ->
		Backbone.history.start()
		App.currentUser.on 'user:auth:success', ->
			App.navigate App.currentUser.get('state'), true

	App.on 'fb:status:connected', ->
		if not App.currentUser.hasProfilePicture()
			App.currentUser.getFacebookPicture()

	App.on 'state:transition:start', (evt, state, params)->
		if not App.currentUser.isLoggedIn() and App.isLoggedInState stateName
			evt.preventDefault()
			App.navigate '#/login', true

		if App.currentUser.isLoggedIn() and state.get('name') is 'login'
			evt.preventDefault()
			App.navigate '#/profile/personal-info', true

	App.start()
