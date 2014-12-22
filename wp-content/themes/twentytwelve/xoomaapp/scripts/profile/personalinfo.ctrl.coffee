
class App.ProfilePersonalInfoView extends Marionette.ItemView
	className : 'animated fadeIn'
	template : '#profile-personal-info-template'
	behaviors :
		FormBehavior :
			behaviorClass : Ajency.FormBehavior
	ui :
		form : '.update_user_details'
		responseMessage : '.aj-response-message'
		dateElement : 'input[name="profile[birth_date]"]'
	modelEvents :
		'change:profile_picture' : 'render'

	onShow:->
		_.enableCordovaBackbuttonNavigation()
	onRender:->
		Backbone.Syphon.deserialize @, @model.toJSON()
		@ui.dateElement.pickadate()

	#to initialize validate plugin
	onFormSubmit: (_formData)=>
		@model.saveProfile _formData['profile']
			.done @successHandler
			.fail @errorHandler

	successHandler:(response, status)=>
		@showSuccessMessage()

	errorHandler:(error)=>

class App.UserPersonalInfoCtrl extends Marionette.RegionController

	initialize: (options)->
		if _.onlineStatus() is false
			window.plugins.toast.showLongBottom("Please check your internet connection.");
			# return false
		else 
			App.currentUser.getProfile().done(@_showView).fail @errorHandler

	_showView : (userModel)=>
		@show new App.ProfilePersonalInfoView
							model : userModel

	errorHandler : (error)->
		@region =  new Marionette.Region el : '#nofound-template'
		new Ajency.HTTPRequestCtrl region : @region
