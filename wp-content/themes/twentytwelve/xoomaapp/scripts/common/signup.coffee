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
		repassword : '.repassword'
		reError : '.reError'
		emailError : '.emailError'

	modelEvents :
		'change:profile_picture' : 'render'

		'keypress .form-control' :(e)->
			if(e.which == 9 )
        		e.preventDefault()


	onShow:->
		if !window.isWebView()
			$('#birth_date').datepicker({
				dateFormat : 'yy-mm-dd'
				changeYear: true,
				changeMonth: true,
				maxDate: new Date(),
				yearRange: "-100:+0",
			});

		#Changes for mobile
		if window.isWebView()
			dateObj = new Date($('#birth_date').val())

			$ '#birth_date'


			.click ->
				maxDate = if CordovaApp.isPlatformIOS() then new Date() else (new Date()).valueOf()
				options = mode: 'date', date: dateObj, maxDate: maxDate

				datePicker.show options, (selectedDate)->
					if not _.isUndefined selectedDate
						dateObj = selectedDate
						dateText = moment(dateObj).format 'YYYY-MM-DD'
						$('#birth_date').val dateText


	onFormSubmit: (_formData)->
		#console.log JSON.stringify _formData
		@ui.reError.show().text("")
		$('.loadingconusme').html '<img src="'+_SITEURL+'/wp-content/themes/twentytwelve/xoomaapp/images/ajax-loader.gif" width="40px">'
		pass = $('#password').val()
		repass = $('#repassword').val()
		if pass == repass && pass.length > 5
			$.ajax
				method : 'POST'
				url : APIURL+'/users/newprofile'
				data : JSON.stringify _formData
				success:@_successHandler
				error:@_errorHandler

		else 
			$('.loadingconusme').html ""
			$('.aj-response-message').removeClass('alert alert-success')
			@ui.reError.show().text("Passwords do not match")


	_successHandler: (response, status,xhr)->
		console.log response
		window.userData = response
		$('.loadingconusme').html ""
		$('.aj-response-message').addClass('alert alert-success').text("User Registered Successfully!")
		App.currentUser.set window.userData
		console.log window.userData
		$('.display_name').text(App.currentUser.get('display_name'));
		$('.user_email').text(App.currentUser.get('user_email'));
		App.navigate '#' + App.currentUser.get('state'), true


	_errorHandler:(response, status,xhr)=>
		console.log response + " -error"
		$('.loadingconusme').html ""
		window.removeMsg()
		if response.status == 400
			$('.aj-response-message').removeClass('alert alert-success')
			@ui.emailError.show().text("Email ID already exists")
		else
			@ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be saved due to some error!")
			$('html, body').animate({
							scrollTop: 0
							}, 'slow')






class App.SignUpCtrl extends Ajency.RegionController
	initialize : ->
		@show new SignUpView 