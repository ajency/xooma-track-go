#start of the Application
jQuery(document).ready ($)->

	App.state 'login'

		.state 'xooma',
				url : '/'


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

	

	App.start()
