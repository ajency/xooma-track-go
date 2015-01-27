


class ProfileMeasurementsView extends Marionette.ItemView

	template  : '#profile-measurements-template'

	className : 'animated fadeIn'

	ui :
		form : '#add_measurements'
		rangeSliders : '[data-rangeslider]'
		responseMessage : '.aj-response-message'
		link : '.link'
		inpt_el   : '.inpt_el'
		update : '.update'
		

	behaviors :
		FormBehavior :
			behaviorClass : Ajency.FormBehavior

	initialize:->
		$(document).on('keyup', _.bind(@keyup, @));
		$(document).on('keypress', _.bind(@keydown, @));

	events :
		'change @ui.rangeSliders' : (e)-> @valueOutput e.currentTarget

	keydown:(e)->
		if  e.charCode == 46
			console.log inputVal = $(e.target).val().split('.').length
			if parseInt(inputVal) >= 2
				return  false
		e.charCode >= 48 && e.charCode <= 57 || e.charCode == 46 ||	e.charCode == 44 
	


		
	keyup:(e)->
		@measurements[e.target.id] = $('#'+e.target.id).val()
		

	onShow:->
		date = moment(App.currentUser.get('user_registered')).format('YYYY-MM-DD')
		$('#update').datepicker(
		    dateFormat : 'yy-mm-dd'
		    changeYear: true,
		    changeMonth: true,
		    maxDate: new Date()
		    minDate : new Date(date)
		    onSelect: (dateText, inst)->
		    	$('#date_field').val dateText


		     
		   
	    
		)
		@ui.rangeSliders.each (index, ele)=> @valueOutput ele
		@ui.rangeSliders.rangeslider polyfill: false
		@measurements = {'arm' :'', 'chest':'','neck':'','waist':'','abdomen':'','midcalf':'','thigh':'','hips':''} 
		
		state = App.currentUser.get 'state'
		if state == '/home'
			$('.measurements_update').removeClass 'hidden'
			$('#measurement').parent().removeClass 'done'
			$('#measurement').parent().addClass 'selected'
			$('#measurement').parent().siblings().removeClass 'selected'
			$('#measurement').parent().prevAll().addClass 'done'
			$('#measurement').parent().nextAll().addClass 'done'
		
		
		
		

	onFormSubmit : (_formData)=>
		@measurements['weight'] = $('#weight').val()
		@measurements['height'] = $('#height').val()
		@measurements['date'] = $('#date_field').val()
		formdata = @measurements
		@model.saveMeasurements(formdata).done(@successHandler).fail(@errorHandler)

	    

	successHandler : (response, status,xhr)=>
		if xhr.status is 404
			@ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be saved due to some error!")
			$('html, body').animate({
							scrollTop: 0
							}, 'slow')
		else
			state = App.currentUser.get 'state'
			if state == '/home'
				@ui.responseMessage.addClass('alert alert-success').text("Measurements successfully updated!")
				$('html, body').animate({
							scrollTop: 0
							}, 'slow')
			else
				App.currentUser.set 'state' , '/profile/my-products'
				App.navigate '#'+App.currentUser.get('state') , true
			

	errorHandler : (error)=>
		@ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be saved due to some error!")
			
		$('html, body').animate({
							scrollTop: 0
							}, 'slow')

	valueOutput : (element) =>
		$(element).parent().find("output").html $(element).val()


class App.UserMeasurementCtrl extends Ajency.RegionController

	initialize: (options)->
		@show @parent().parent().getLLoadingView()
		xhr = @_get_measurement_details()
		xhr.done(@_showView).fail @errorHandler

	

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
		deferred = Marionette.Deferred()
		deferred.resolve(true)
		deferred.promise()