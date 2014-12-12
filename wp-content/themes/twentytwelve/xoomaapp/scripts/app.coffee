#start of the Application
jQuery(document).ready ($)->

	App.state 'login'
	
		.state 'xooma',
				url : '/'

		.state 'ProfilePersonalInfo',
				url : '/profile/personal-info'
				parent : 'xooma'


	App.addInitializer ->
		Backbone.history.start()
		App.navigate '/login', true
	
	App.start()
