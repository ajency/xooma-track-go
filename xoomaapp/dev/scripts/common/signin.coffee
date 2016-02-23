App.state 'SignIn',
			url : '/signIn'
			parent : 'xooma'


class SignInView extends Marionette.ItemView
	template : '#sign_in_template'
	class : 'animated fadeIn'


class App.SignInCtrl extends Ajency.RegionController
	@show new SignInView