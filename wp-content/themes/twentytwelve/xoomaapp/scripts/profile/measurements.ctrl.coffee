


class ProfileMeasurementsView extends Marionette.ItemView

	template  : '#profile-measurements-template'

	className : 'animated fadeIn'

	ui :
		form : '#add_measurements'
		rangeSliders : '[data-rangeslider]'
		responseMessage : '.aj-response-message'
		link : '.link'
		fa   : '.fa'
		

	behaviors :
		FormBehavior :
			behaviorClass : Ajency.FormBehavior
	events :
		'change @ui.rangeSliders' : (e)-> @valueOutput e.currentTarget
		
		
			
	$(document).on 'keypress' , (e)->
		if  e.charCode == 46
			console.log inputVal = $(e.target).val().split('.').length
			if parseInt(inputVal) >= 2
				return  false
		e.charCode >= 48 && e.charCode <= 57 || e.charCode == 46 ||	e.charCode == 44 
	

	onShow:->
		@ui.rangeSliders.each (index, ele)=> @valueOutput ele
		@ui.rangeSliders.rangeslider polyfill: false
		$("img#body").on("load",  () ->
  			$.getScript(_SITEURL+"/wp-content/themes/twentytwelve/js/tooltip.js")
		)
		
		
		

	onFormSubmit : (_formData)=>
		@model.saveMeasurements(_formData).done(@successHandler).fail(@errorHandler)

	    

	successHandler : (response, status,xhr)=>
		if xhr.status is 404
			@ui.responseMessage.text "Something went wrong"
			$('html, body').animate({
							scrollTop: 0
							}, 'slow')
		else
			state = App.currentUser.get 'state'
			if state == '/home'
				@ui.responseMessage.text "profile successfully updated"
			else
				App.currentUser.set 'state' , '/profile/my-products'
				App.navigate '#'+App.currentUser.get('state') , true
			

	errorHandler : (error)=>
		@ui.responseMessage.text "Something went wrong"
		$('html, body').animate({
							scrollTop: 0
							}, 'slow')

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
