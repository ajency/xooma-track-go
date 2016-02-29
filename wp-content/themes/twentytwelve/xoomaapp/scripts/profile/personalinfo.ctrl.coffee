
class ProfilePersonalInfoView extends Marionette.ItemView
	className : 'animated fadeIn'
	template : '#profile-personal-info-template'
	behaviors :
		FormBehavior :
			behaviorClass : Ajency.FormBehavior
	ui :
		form : '.update_user_details'
		responseMessage : '.aj-response-message'
		dateElement : 'input[name="profile[birth_date]"]'
		xooma_member_id : '.xooma_member_id'
		timezone : 'input[name="profile[timezone]"]'
	modelEvents :
		'change:profile_picture' : 'render'

		'keypress .form-control' :(e)->
			if(e.which == 9 )
        		e.preventDefault()
    

	initialize : ->
		@listenTo App, 'fb:status:connected', ->
			if not App.currentUser.hasProfilePicture()
				App.currentUser.getFacebookPicture()
				
		@listenTo App, 'user:status:connected', ->
			if not App.currentUser.hasProfilePicture()
				App.currentUser.getFacebookPicture()	
		
	onRender:->
		
		Backbone.Syphon.deserialize @, @model.toJSON()
		if !window.isWebView()
			$('#birth_date').datepicker({
				dateFormat : 'yy-mm-dd'
				changeYear: true,
				changeMonth: true,
				maxDate: new Date(),
				yearRange: "-100:+0",
			});

		$('.data1').hide()
		



	onShow:->
		$('.data1').hide()
		if App.currentUser.get('caps').administrator == true
			$('.profile-template').hide()
			$('.tabelements').attr('disabled', true)
			$('.data').hide()
			$('.data1').show()
		
		App.trigger 'cordova:hide:splash:screen'
		
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
			.prop 'readonly', true
			.click ->
				maxDate = if CordovaApp.isPlatformIOS() then new Date() else (new Date()).valueOf()
				options = mode: 'date', date: dateObj, maxDate: maxDate

				datePicker.show options, (selectedDate)->
					if not _.isUndefined selectedDate
						dateObj = selectedDate
						dateText = moment(dateObj).format 'YYYY-MM-DD'
						$('#birth_date').val dateText
		
		
		state = App.currentUser.get 'state'
		if state == '/home'
			$('.measurements_update').removeClass 'hidden'
			$('#profile').parent().removeClass 'done'
			$('#profile').parent().addClass 'selected'
			$('#profile').parent().siblings().removeClass 'selected'
			$('#profile').parent().nextAll().addClass 'done'
		
		if App.currentUser.get('timezone') == null
			@$el.find('#timezone option[value="'+$('#timezone').val()+'"]').prop("selected",true)
			# $("#timezone").val($("#timezone option:first").val());


		

	#to initialize validate plugin
	onFormSubmit: (_formData)=>
		$('.loadingconusme').html '<img src="'+_SITEURL+'/wp-content/themes/twentytwelve/xoomaapp/images/ajax-loader.gif" width="40px">'
		if App.currentUser.get('caps').administrator == true
			console.log id = @model.get('profile').user_id
		
			$.ajax
				method : 'PUT'
				url : APIURL+'/users/'+id+'/profile'
				data : JSON.stringify _formData['profile']
				success:@_successHandler
		else
			@model.saveProfile _formData['profile']
				.done @successHandler
				.fail @errorHandler

	_successHandler:(response, status,xhr)=>
		$('.loadingconusme').html ""
		@ui.responseMessage.addClass('alert alert-success').text("Personal Information successfully updated!")
		$('html, body').animate({
						scrollTop: 0
						}, 'slow')
		

	successHandler:(response, status,xhr)=>
		$('.loadingconusme').html ""
		state = App.currentUser.get 'state'
		if xhr.status is 404
			window.removeMsg()
			@ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be saved due to some error!")
			$('html, body').animate({
							scrollTop: 0
							}, 'slow')
		else
			if state == '/home' 
				window.removeMsg()
				App.currentUser.set 'profile', response
				App.currentUser.set 'timezone', response.timezone
				App.currentUser.set 'offset', response.offset
				
				@ui.responseMessage.addClass('alert alert-success').text("Personal Information successfully updated!")
				$('html, body').animate({
							scrollTop: 0
							}, 'slow')
				
			else
				App.currentUser.set 'profile', response
				App.currentUser.set 'timezone', response.timezone
				App.currentUser.set 'state' , '/profile/measurements'
				App.navigate '#'+App.currentUser.get('state') , true
		

	errorHandler:(error)=>
		$('.loadingconusme').html ""
		window.removeMsg()
		@ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be saved due to some error!")
		$('html, body').animate({
							scrollTop: 0
							}, 'slow')

class App.UserPersonalInfoCtrl extends Ajency.RegionController

	initialize: (options)->
		url = '#'+App.currentUser.get 'state'
		computed_url = '#'+window.location.hash.split('#')[1]
		@show @parent().parent().getLLoadingView()

		App.currentUser.getProfile().done(@_showView).fail @errorHandler

	_showView : (userModel)=>
		@show new ProfilePersonalInfoView
							model : userModel

	errorHandler : (error)=>
		@region =  new Marionette.Region el : '#404-template'
		new Ajency.HTTPRequestCtrl region : @region

	
		