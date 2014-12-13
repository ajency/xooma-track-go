#start of the Application


jQuery(document).ready ($)->

	App.state 'login'
	
		.state 'xooma',
				url : '/'

		.state 'ProfilePersonalInfo',
				url : '/profile/personal-info'
				parent : 'xooma'

		.state 'profileMeasurement',
				url : '/profile/measurements'
				ctrl : 'ProfileMeasurementsCtrl'
				parent : 'xooma'


	App.addInitializer ->
		Backbone.history.start()
		#App.navigate '/login', true
	
	App.start()
