App.state 'SignIn',
				url : '/signin'
				parent : 'xooma'


class SignInView extends Marionette.ItemView
	class : 'animated fadeIn'
	template : '#sign_in_template'
	behaviors : 
		FormBehavior :
			behaviorClass : Ajency.FormBehavior






class App.SignInCtrl extends Ajency.RegionController
	initialize : ->
		console.log "sign in"
		@show new SignInView