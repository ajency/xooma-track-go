#start of the Application

class LoginView extends Marionette.ItemView
	template : '#login-template'
	initialize : (opts)->
		super opts
	ui : 
		fbLoginButton : '.f-login-button'
	events : 
		'click @ui.fbLoginButton' : 'loginWithFacebook'

	loginWithFacebook : (evt)=>
		FB.login (response)=>
			if response.authResponse
				FB.api '/me', (user)=>
					@triggerMethod 'facebook:login:success', user, response.authResponse.accessToken
			else
				@triggerMethod 'facebook:login:cancel'
		, scope: 'email'

class App.LoginCtrl extends Ajency.LoginCtrl
	initialize : ->
		loginView = new LoginView
		@listenTo loginView, 'facebook:login:success', @_facebookAuthSuccess
		@listenTo loginView, 'facebook:login:cancel', @_facebookAuthCancel
		@show loginView

	_facebookAuthSuccess : (args...)->
		App.currentUser.authenticate 'facebook', args...

	_facebookAuthCancel : ->
		App.currentUser.trigger 'user:auth:cancel'
  

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

		.state 'settings',
				url : '/settings'
				parent : 'xooma'

	App.addInitializer ->
		Backbone.history.start()
		App.currentUser.on 'user:auth:success', ->
			App.navigate '/profile', true
	
	App.start()
