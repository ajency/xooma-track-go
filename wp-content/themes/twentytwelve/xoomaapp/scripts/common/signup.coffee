App.state 'SignUp',
			url : '/signup'
			parent : 'xooma'


class SignUpView extends Marionette.ItemView
	template : '#sign_up_template'
	class : 'animated fadeIn'
	behaviors : 
		FormBehavior :
			behaviorClass : Ajency.FormBehavior
	ui :
		form : '.user-sign-up'
		responseMessage : '.aj-response-message'
		dateElement : 'input[name="profile[birth_date]"]'
		xooma_member_id : '.xooma_member_id'






class App.SignUpCtrl extends Ajency.RegionController
	initialize : ->
		@show new SignUpView 