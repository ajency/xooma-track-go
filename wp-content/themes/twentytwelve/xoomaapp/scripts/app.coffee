#start of the Application
jQuery(document).ready ($)->

	App.state 'login',

		.state 'xooma',
				url : '/'

		.state 'personalInfo',
				url : '/profile/personal-info'
				parent : 'xooma'


	App.addInitializer ->
		Backbone.history.start()
		if not App.currentUser.isLoggedIn()
			App.navigate '/login', true
		else
			App.navigate '/', true
	
	App.start()
