
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

	initialize : ->
		@listenTo App, 'fb:status:connected', ->
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



	onShow:->

		App.trigger 'cordova:hide:splash:screen'
		if !window.isWebView()
			$('#birth_date').datepicker({
			    dateFormat : 'yy-mm-dd'
			    changeYear: true,
			    changeMonth: true,
			    maxDate: new Date(),
			    yearRange: "-100:+0",
				     
				   
			    
			});
		state = App.currentUser.get 'state'
		if state == '/home'
			$('.measurements_update').removeClass 'hidden'
			$('#profile').parent().removeClass 'done'
			$('#profile').parent().addClass 'selected'
			$('#profile').parent().siblings().removeClass 'selected'
			$('#profile').parent().nextAll().addClass 'done'
		
		if App.currentUser.get('timezone') == null
			$('#timezone option[value="'+$('#timezone').val()+'"]').prop("selected",true)

		
		
		    
		


		

	#to initialize validate plugin
	onFormSubmit: (_formData)=>
		@model.saveProfile _formData['profile']
			.done @successHandler
			.fail @errorHandler

	successHandler:(response, status,xhr)=>
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
		window.removeMsg()
		@ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be saved due to some error!")
		$('html, body').animate({
							scrollTop: 0
							}, 'slow')

class App.UserPersonalInfoCtrl extends Ajency.RegionController

	initialize: (options)->
		@show @parent().parent().getLLoadingView()
		App.currentUser.getProfile().done(@_showView).fail @errorHandler

	_showView : (userModel)=>
		@show new ProfilePersonalInfoView
							model : userModel

	errorHandler : (error)=>
		@region =  new Marionette.Region el : '#404-template'
		new Ajency.HTTPRequestCtrl region : @region

	
		