

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
		console.log "aaaaaaaaaaaa"
		_formData = $('#add_measurements').serialize()
		console.log  _formData
		$.ajax
			method : 'POST',
			url : _SITEURL+'/wp-json/measurements/'+App.currentUser.get('ID'),
			data : _formData,
			success: @successHandler      
			error: @errorHandler

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

	





						
		   
					
			


				

	
				

		