

class App.ProfileMeasurementsView extends Marionette.ItemView

	template  : '#profile-measurements-template'

	className : 'animated fadeIn'

	ui : 
		popoverElements : '.popover-element'
		form : '#add_measurements'
		rangeSliders : '[data-rangeslider]'
		responseMessage : '.response_msg'

	events : 
		'change @ui.rangeSliders' : (e)-> @valueOutput e.currentTarget

	onShow:->
		$('#measurement').parent().addClass 'active'
		$('#product').bind('click',@disabler)
		$('#product').css('cursor', 'default')
		@ui.popoverElements.popover html: true    
		@ui.rangeSliders.each (index, ele)=> @valueOutput ele
		@ui.rangeSliders.rangeslider polyfill: false
		@ui.form.validate submitHandler: @formSubmitHandler
		# _.enableCordovaBackbuttonNavigation()
		@cordovaEventsForModuleDescriptionView()

	disabler:(e)->
		e.preventDefault()
		return false

	formSubmitHandler : (form)=>
		_formData = $('#add_measurements').serialize()
		@model.saveMeasurements(_formData).done(@successHandler).fail(@errorHandler)
		return false
 
	successHandler : (response, status)=>
		if status is 404
			@ui.responseMessage.text "Something went wrong"
		else
			@ui.responseMessage.text "User details saved successfully"

	errorHandler : (error)=>
		@ui.responseMessage.text "Something went wrong"

	valueOutput : (element) =>
		$(element).parent().find("output").html $(element).val()

	onPauseSessionClick : =>
			console.log 'Invoked onPauseSessionClick'
			Backbone.history.history.back()

			document.removeEventListener("backbutton", @onPauseSessionClick, false)
		
	cordovaEventsForModuleDescriptionView : ->
		# Cordova backbutton event
		navigator.app.overrideBackbutton(true)
		document.addEventListener("backbutton", @onPauseSessionClick, false)

		# Cordova pause event
		document.addEventListener("pause", @onPauseSessionClick, false)

	





						
			 
					
			


				

	
				

		