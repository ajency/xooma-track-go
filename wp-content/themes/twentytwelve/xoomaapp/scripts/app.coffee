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

		.state 'UserProductList',
				url : '/my-products'
				parent : 'profile'

		.state 'ProductList',
				url : '/products'
				parent : 'xooma'
				


	App.addInitializer ->
		Backbone.history.start()
		App.currentUser.on 'user:auth:success', ->
			App.navigate App.currentUser.get('state'), true

	App.on 'fb:status:connected', ->
		if not App.currentUser.hasProfilePicture()
			App.currentUser.getFacebookPicture()

	App.on 'state:transition:start', (evt, stateName, params)->
		if not App.currentUser.isLoggedIn() and App.isLoggedInState stateName
			evt.preventDefault()
			App.navigate '/login', true

		if App.currentUser.isLoggedIn() and stateName is 'login'
			evt.preventDefault()
			App.navigate '/profile/personal-info', true

	App.start()
