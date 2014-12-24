


class ProfileMeasurementsView extends Marionette.ItemView

	template  : '#profile-measurements-template'

	className : 'animated fadeIn'

	ui :
		popoverElements : '.popover-element'
		form : '#add_measurements'
		rangeSliders : '[data-rangeslider]'
		responseMessage : '.aj-response-message'

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
		#method used for DEVICE
		@cordovaEventsForModuleDescriptionView()

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
		$('html, body').animate({
							scrollTop: 0
							}, 'slow')

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


class App.UserMeasurementCtrl extends Ajency.RegionController

	initialize: (options)->
		if _.onlineStatus() is false
			window.plugins.toast.showLongBottom("Please check your internet connection.");

		else 
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
