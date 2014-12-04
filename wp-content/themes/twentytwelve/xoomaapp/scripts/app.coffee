#start of the Application
jQuery(document).ready ($)->

	App.state 'login'

		.state 'xooma',
				url : '/'

		.state 'personalInfo',
				url : '/profile/personal-info'
				parent : 'xooma'


	App.addInitializer ->
		App.currentUser.set 'caps', 
							'access_login' : true
							'access_personalInfo' : true
							'access_xooma' : true
		Backbone.history.start()
	
	App.start()
