#start of the Application
jQuery(document).ready ($)->

	App.state 'login'

		.state 'xooma',
				url : '/'

	App.onBeforeStart = ->
		App.currentUser.set userData
		if not App.currentUser.isLoggedIn()
			App.currentUser.set 'caps', notLoggedInCaps

		App.currentUser.on 'user:auth:success', ->
			App.navigate App.currentUser.get('state'), true

	App.addInitializer ->
		Backbone.history.start()

	App.on 'fb:status:connected', ->
		if not App.currentUser.hasProfilePicture()
			App.currentUser.getFacebookPicture()


	App.start()
