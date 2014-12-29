#start of the Application
jQuery(document).ready ($)->

	App.state 'login'

		.state 'xooma',
				url : '/'
		.state 'AddProducts',
					url : '/products'
					parent : 'xooma'
		.state 'UserProductList',
					url : '/my-products'
					parent : 'profile'
		.state 'home',
					url : '/home'
					parent : 'xooma'

			

	App.onBeforeStart = ->
		App.currentUser.set userData
		if not App.currentUser.isLoggedIn()
			App.currentUser.set 'caps', notLoggedInCaps

	App.currentUser.on 'user:auth:success', ->
		App.navigate App.currentUser.get('state'), true

	App.currentUser.on 'user:logged:out', ->
		App.currentUser.clear slient : true
		App.currentUser.set 'caps', notLoggedInCaps
		App.navigate '/login', true

		App.state 'settings',
					url : '/settings'
					parent : 'xooma'

			.state 'home',
					url : '/home'
					parent : 'xooma'

			.state 'UserProductList',
					url : '/my-products'
					parent : 'profile'

			.state 'AddProducts',
					url : '/products'
					parent : 'xooma'
				



	App.addInitializer ->
		Backbone.history.start()


	App.on 'fb:status:connected', ->
		if not App.currentUser.hasProfilePicture()
			App.currentUser.getFacebookPicture()




	App.start()
