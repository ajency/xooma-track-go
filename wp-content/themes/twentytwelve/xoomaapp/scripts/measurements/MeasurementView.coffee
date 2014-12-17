

class ProfileMeasurementsView extends Marionette.ItemView

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
		@ui.popoverElements.popover html: true    
		@ui.rangeSliders.each (index, ele)=> @valueOutput ele
		@ui.rangeSliders.rangeslider polyfill: false
		@ui.form.validate submitHandler: @formSubmitHandler

	formSubmitHandler : (form)=>
		_formData = Backbone.Syphon.serialize @

		$.ajax
			method : 'POST',
			url : _SITEURL+'/wp-json/measurements/2',
			data : _formData,
			success: @successHandler      
			error: @errorHandler

	successHandler : (response, status)=>
		if status is 404
			@ui.responseMessage.text "Something went wrong"
		else
			@ui.responseMessage.text "User details saved successfully"

	errorHandler : (error)=>
		@ui.responseMessage.text "Something went wrong"

	valueOutput : (element) =>
		$(element).parent().find("output").html $(element).val()

	





						
		   
					
			


				

	
				

		