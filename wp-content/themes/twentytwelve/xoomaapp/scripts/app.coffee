#start of the Application
jQuery(document).ready ($)->

	App.state 'login'

		.state 'xooma',
				url : '/'


	App.addInitializer ->
		Backbone.history.start()
		App.currentUser.set userData
		App.currentUser.on 'user:auth:success', ->
			App.navigate App.currentUser.get('state'), true

	App.on 'fb:status:connected', ->
		if not App.currentUser.hasProfilePicture()
			App.currentUser.getFacebookPicture()

	App.on 'state:transition:start', (evt, state, params)->
		if not App.currentUser.isLoggedIn() and App.isLoggedInState state.get('name')
			evt.preventDefault()
			App.navigate '#/login', true

		if App.currentUser.isLoggedIn() and state.get('name') is 'login'
			evt.preventDefault()
			App.navigate '#/profile/personal-info', true

	App.start()
