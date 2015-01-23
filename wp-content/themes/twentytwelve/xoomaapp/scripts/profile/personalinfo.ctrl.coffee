
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
	modelEvents :
		'change:profile_picture' : 'render'

	initialize : ->
		@listenTo App, 'fb:status:connected', ->
			if not App.currentUser.hasProfilePicture()
				App.currentUser.getFacebookPicture()

	
		


	onShow:->
		Backbone.Syphon.deserialize @, @model.toJSON()
		@ui.dateElement.pickadate(
			formatSubmit: 'yyyy-mm-dd'
			hiddenName: true
			max: new Date()
			selectYears: 70
			)
		birth_date = @model.get('profile').birth_date
		picker = @ui.dateElement.pickadate('picker')
		picker.set('select', birth_date, { format: 'yyyy-mm-dd' })
		

	#to initialize validate plugin
	onFormSubmit: (_formData)=>
		@model.saveProfile _formData['profile']
			.done @successHandler
			.fail @errorHandler

	successHandler:(response, status,xhr)=>
		state = App.currentUser.get 'state'
		if xhr.status is 404
			$('.alert').remove()
			@ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be saved due to some error!")
			$('html, body').animate({
							scrollTop: 0
							}, 'slow')
		else
			if state == '/home'
				$('.alert').remove()
				@ui.responseMessage.addClass('alert alert-success').text("Profile Personal Information successfully updated!")
				
				
			else
				App.currentUser.set 'state' , '/profile/measurements'
				App.navigate '#'+App.currentUser.get('state') , true
		

	errorHandler:(error)=>
		$('.alert').remove()
		@ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be saved due to some error!")
		$('html, body').animate({
							scrollTop: 0
							}, 'slow')

class App.UserPersonalInfoCtrl extends Ajency.RegionController

	initialize: (options)->
		App.currentUser.getProfile().done(@_showView).fail @errorHandler

	_showView : (userModel)=>
		@show new ProfilePersonalInfoView
							model : userModel

	errorHandler : (error)->
		@region =  new Marionette.Region el : '#nofound-template'
		new Ajency.HTTPRequestCtrl region : @region
