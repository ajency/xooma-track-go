App.state 'SignIn',
				url : '/signin'
				parent : 'xooma'


class SignInView extends Marionette.ItemView
	class : 'animated fadeIn'
	template : '#sign_in_template'
	behaviors : 
		FormBehavior :
			behaviorClass : Ajency.FormBehavior
	ui :
		form : '.sign-in-user'
		responseMessage : '.aj-response-message'
		reError : '.creError'

	modelEvents :
		'change:profile_picture' : 'render'

		'keypress .form-control' :(e)->
			if(e.which == 9 )
        		e.preventDefault()



	onFormSubmit: (_formData)->
		#console.log JSON.stringify _formData
		$('.loadingconusme').html '<img src="'+_SITEURL+'/wp-content/themes/twentytwelve/xoomaapp/images/ajax-loader.gif" width="40px">'
		$.ajax
			method : 'POST'
			url : APIURL+'/users/login'
			data : JSON.stringify _formData
			success:@_successHandler
			error:@_errorHandler



	_successHandler: (response)->
		#console.log response+ " - response"
		window.userData = response
		#console.log window.userData
		$('.loadingconusme').html ""
		$('.aj-response-message').addClass('alert alert-success').text("User Logged In Successfully!")
		App.currentUser.set window.userData
		display_name = App.currentUser.get('display_name')
		$('.display_name').text(App.currentUser.get('display_name'))
		$('.user_email').text(App.currentUser.get('user_email'))
		if window.isWebView()
			localforage.setItem('user_reg_id', App.currentUser.get('ID'))
		#localStorage.setItem('user_reg_id', App.currentUser.get('ID'))
		#console.log App.currentUser.get('ID') + "ID"
		#console.log App.currentUser.get('caps').administrator
		App.navigate '#' + App.currentUser.get('state'), true



	_errorHandler:(response)=>
		console.log response+" -error"
		console.log response.status+" -error"
		$('.loadingconusme').html ""
		window.removeMsg()
		@ui.responseMessage.addClass('alert alert-danger').text("Invalid Login Credentials")
		$('html, body').animate({
							scrollTop: 0
							}, 'slow')




class App.SignInCtrl extends Ajency.RegionController
	initialize : ->
		console.log "sign in"
		@show new SignInView