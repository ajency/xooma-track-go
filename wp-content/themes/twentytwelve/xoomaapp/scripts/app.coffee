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
				ctrl : 'ProfileMeasurementsCtrl'
				parent : 'profile'


	App.addInitializer ->
		Backbone.history.start()
		#App.navigate '/login', true
	
	App.start()
