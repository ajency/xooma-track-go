


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
			inputVal = $(e.target).val().split('.').length
			if parseInt(inputVal) >= 2
				return  false
		e.charCode >= 48 && e.charCode <= 57 || e.charCode == 46 
	


		
	keyup:(e)->
		@measurements[e.target.id] = $('#'+e.target.id).val()
		

	onShow:->
		

			

		App.trigger 'cordova:hide:splash:screen'
		$('#update').val moment().format('YYYY-MM-DD')
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
		console.log App.currentUser.get('measurements')
		if App.currentUser.get('measurements') != undefined
			obj = App.currentUser.get('measurements')
			@measurements.arm = obj.arm
			@measurements.neck = obj.neck
			@measurements.waist = obj.waist
			@measurements.abdomen = obj.abdomen
			@measurements.midcalf = obj.midcalf
			@measurements.thigh = obj.thigh
			@measurements.hips = obj.hips
		console.log @measurements
		state = App.currentUser.get 'state'
		if state == '/home'
			$('.measurements_update').removeClass 'hidden'
			$('#measurement').parent().removeClass 'done'
			$('#measurement').parent().addClass 'selected'
			$('#measurement').parent().siblings().removeClass 'selected'
			$('#measurement').parent().prevAll().addClass 'done'
			$('#measurement').parent().nextAll().addClass 'done'
		
		
		
		

	onFormSubmit : (_formData)=>
		count = 0
		$.each @measurements , (ind,val)->
			if (!($.isNumeric(val))) && val!="" && ind != 'date' 
				count++ 
				window.removeMsg()
				$('.aj-response-message').addClass('alert alert-danger').text("Data entered in tooltips is not in the proper format!")
				$('html, body').animate({
								scrollTop: 0
								}, 'slow')
				return
		
		if count == 0
			@measurements['weight'] = $('#weight').val()
			@measurements['height'] = $('#height').val()
			@measurements['date'] = $('#date_field').val()
		
			formdata = @measurements
			@model.saveMeasurements(formdata).done(@successHandler).fail(@errorHandler)

	    

	successHandler : (response, status,xhr)=>
		if xhr.status is 404
			window.removeMsg()
			@ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be saved due to some error!")
			$('html, body').animate({
							scrollTop: 0
							}, 'slow')
		else
			state = App.currentUser.get 'state'
			if state == '/home'
				window.removeMsg()
				@ui.responseMessage.addClass('alert alert-success').text("Measurements successfully updated!")
				$('html, body').animate({
							scrollTop: 0
							}, 'slow')
			else
				App.currentUser.set 'state' , '/profile/my-products'
				App.navigate '#'+App.currentUser.get('state') , true
			

	errorHandler : (error)=>
		window.removeMsg()
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
		$.ajax
			method : 'GET'
			url : "#{_SITEURL}/wp-json/users/#{App.currentUser.get('ID')}/measurements"
			success: @successHandler
		

	errorHandler : (error)->
		@region =  new Marionette.Region el : '#nofound-template'
		new Ajency.HTTPRequestCtrl region : @region

	successHandler : (response, status)=>
		App.currentUser.set 'measurements', response.response
		deferred = Marionette.Deferred()
		deferred.resolve(true)
		deferred.promise()