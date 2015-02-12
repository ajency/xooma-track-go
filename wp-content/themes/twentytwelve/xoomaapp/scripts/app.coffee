#start of the Application
jQuery(document).ready ($)->
	
	App.state 'login'

		.state 'xooma',
				url : '/'
		.state 'home',
				url : '/home'
				parent : 'xooma'
				sections : 
					'x2o' : 
						ctrl : 'HomeX2OCtrl'
					'other-products' : 
						ctrl : 'HomeOtherProductsCtrl'
						
			

	App.onBeforeStart = ->
		App.currentUser.set userData
		if not App.currentUser.isLoggedIn()
			App.currentUser.setNotLoggedInCapabilities()

	App.currentUser.on 'user:auth:success', ->
		App.trigger 'fb:status:connected'
		App.currentUser.set 'homeDate' , moment().format('YYYY-MM-DD')
		console.log App.currentUser.get 'homeDate'
		App.navigate '#'+App.currentUser.get('state'), true

	App.currentUser.on 'user:logged:out', ->
		App.navigate '/login', true
		`userData = {}`


	App.state 'settings',
				url : '/settings'
				parent : 'xooma'

		.state 'home',
				url : '/home'
				parent : 'xooma'
				sections : 
					'x2o' : 
						ctrl : 'HomeX2OCtrl'
					'other-products' : 
						ctrl : 'HomeOtherProductsCtrl'

		
				

	App.addInitializer ->
		Backbone.history.start()


	App.on 'fb:status:connected', ->
		if not App.currentUser.hasProfilePicture()
			App.currentUser.getFacebookPicture()

	App.on 'cordova:hide:splash:screen', ->
		console.log "triggered"


	App.start()

