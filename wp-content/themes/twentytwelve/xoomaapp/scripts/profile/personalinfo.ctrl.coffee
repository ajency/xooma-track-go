
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

	onRender:->
		Backbone.Syphon.deserialize @, @model.toJSON()
		@ui.dateElement.pickadate()

	#to initialize validate plugin
	onFormSubmit: (_formData)=>
		@model.saveProfile _formData['profile']
			.done @successHandler
			.fail @errorHandler

	successHandler:(response, status)=>
		App.navigate '/profile/measurements' , true
		$('#product').css('cursor:default')
		$('#product').bind('click',@disableEvent)

	errorHandler:(error)=>
		@ui.responseMessage.text "Data couldn't be saved due to some error."
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
