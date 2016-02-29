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
		console.log JSON.stringify _formData
		$('.loadingconusme').html '<img src="'+_SITEURL+'/wp-content/themes/twentytwelve/xoomaapp/images/ajax-loader.gif" width="40px">'
		$.ajax
			method : 'POST'
			url : APIURL+'/users/login'
			data : JSON.stringify _formData
			success:@_successHandler
			error:@_errorHandler



	_successHandler: (response)->
		console.log response+ " - response"
		$('.loadingconusme').html ""
		$('.aj-response-message').addClass('alert alert-success').text("User Logged In Successfully!")
		$('html, body').animate({
						scrollTop: 0
						}, 'slow')

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