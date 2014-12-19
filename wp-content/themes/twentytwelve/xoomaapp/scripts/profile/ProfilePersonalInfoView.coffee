

class ProfilePersonalInfoView extends Marionette.ItemView
	className : 'animated fadeIn'
	template : '#profile-personal-info-template'
	behaviors :
		FormBehavior :
			behaviorClass : Ajency.FormBehavior
	ui :
		form : '.update_user_details'
		responseMessage : '.response_msg'
		dateElement : 'input[name="profile[birth_date]"]'

	onShow:->
		Backbone.Syphon.deserialize @, @model.toJSON()
		@ui.dateElement.pickadate()

	#to initialize validate plugin
	onFormSubmit: (_formData)=>
		console.log _formData
		@model.saveProfiles(_formData.profile).done(@successHandler).fail(@errorHandler)

	successHandler:(response, status)=>
		@showSuccessMessage()

	errorHandler:(error)=>





















