


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
		$('#measurement').parent().addClass 'active'
		$('#product').bind('click',@disabler)
		$('#product').css('cursor', 'default')
		@ui.popoverElements.popover html: true
		@ui.rangeSliders.each (index, ele)=> @valueOutput ele
		@ui.rangeSliders.rangeslider polyfill: false
		@ui.form.validate submitHandler: @formSubmitHandler

	disabler:(e)->
		e.preventDefault()
		return false

	formSubmitHandler : (form)=>
		_formData = $('#add_measurements').serialize()
		@model.saveMeasurements(_formData).done(@successHandler).fail(@errorHandler)
		return false

	successHandler : (response, status,responseCode)=>
		if responseCode.status is 404
			@ui.responseMessage.text "Something went wrong"
		else
			App.navigate '/profile/my-products' , true

	errorHandler : (error)=>
		@ui.responseMessage.text "Something went wrong"

	valueOutput : (element) =>
		$(element).parent().find("output").html $(element).val()


class App.UserMeasurementCtrl extends Ajency.RegionController

	initialize: (options)->
		xhr = @_get_measurement_details()
		xhr.done(@_showView).fail @_showView

	_showView :=>
		@show new ProfileMeasurementsView
								model : App.currentUser

	_get_measurement_details:->
		if not App.currentUser.has 'measurements'
			$.ajax
				method : 'GET'
				url : "#{_SITEURL}/wp-json/users/#{App.currentUser.get('ID')}/measurements"
				success: @successHandler
		else
			deferred = Marionette.Deferred()
			deferred.resolve(true)
			deferred.promise()

	errorHandler : (error)->
		@region =  new Marionette.Region el : '#nofound-template'
		new Ajency.HTTPRequestCtrl region : @region

	successHandler : (response, status)=>
		App.currentUser.set 'measurements', response.response
