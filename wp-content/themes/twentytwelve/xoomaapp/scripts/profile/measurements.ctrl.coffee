


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

		'change #height':(e)->
			temparr = $(e.target).val().split('.')
			if temparr.length == 1
				temparr.push 0
			$('.heightcms').text temparr[0]+"'"+temparr[1]+'"'
			
			ftcm = 30.48 * parseFloat(temparr[0])
			inchcm = 2.54 * parseFloat(temparr[1])
			cms  = parseFloat(ftcm) + parseFloat(inchcm)
			$('.convertheight').text cms.toFixed(2)+ ' Cms'

		'change #weight':(e)->
			pounds = $(e.target).val()
			onepound = 0.4535
			xpound = parseFloat(onepound) * parseFloat(pounds)
			$('.convertweight').text xpound.toFixed(2)+' Kgs'
			$('.weightcms').text $(e.target).val()


	keydown:(e)->
		if(e.which == 9)
        	e.preventDefault()
		if (e.which == 13)
			$('#mcttCloseButton').trigger('click')
		

		if  e.which == 46
			inputVal = $(e.target).val().split('.').length
			if parseInt(inputVal) >= 2
				return  false
		e.which >= 48 && e.which <= 57 || e.which == 46 || e.which == 8
	


		
	keyup:(e)->
		if(e.which == 9)
        	e.preventDefault()
        	return 
		
		@measurements[e.target.id] = $('#'+e.target.id).val()
		

	onShow:->
		select = document.getElementById('weight')
		select.options.length = 0
		i = 30
		while (i <= 500)
			select.options.add(new Option(i,i))
			i++
		
		if App.currentUser.get('measurements') != undefined
			height = App.currentUser.get('measurements').height
			weight = App.currentUser.get('measurements').weight
			$('#height option[value="'+height+'"]').prop("selected",true)
			$('#weight option[value="'+weight+'"]').prop("selected",true)
			

		$( '#height' ).trigger( "change" )
		$( '#weight').trigger( "change" )
		App.trigger 'cordova:hide:splash:screen'
			
		timezone = App.currentUser.get('timezone')
		$('#date_field').val moment().zone(timezone).format('YYYY-MM-DD')

		date = moment(App.currentUser.get('user_registered')).format('YYYY-MM-DD')

		if !window.isWebView()
			$('#update').val 'TODAY'
			
			$('#update').datepicker(
				dateFormat : 'yy-mm-dd'
				changeYear: true,
				changeMonth: true,
				maxDate: new Date()
				minDate : new Date(date)
				onSelect: (dateText, inst)->
					$('#date_field').val dateText
			)

		#Changes for Mobile
		if window.isWebView()
			$('#update').val moment().format 'YYYY-MM-DD'

			$('#update')
			.attr
				max: moment().format 'YYYY-MM-DD'
				min: date
			.change ->
				$('#date_field').val $('#update').val()


		@ui.rangeSliders.each (index, ele)=> @valueOutput ele
		@ui.rangeSliders.rangeslider polyfill: false
		@measurements = {'arm' :'', 'chest':'','neck':'','waist':'','abdomen':'','midcalf':'','thigh':'','hips':''} 
		
		if App.currentUser.get('measurements') != undefined
			obj = App.currentUser.get('measurements')
			@measurements.arm = obj.arm
			@measurements.neck = obj.neck
			@measurements.waist = obj.waist
			@measurements.abdomen = obj.abdomen
			@measurements.midcalf = obj.midcalf
			@measurements.thigh = obj.thigh
			@measurements.hips = obj.hips
		
		state = App.currentUser.get 'state'
		if state == '/home'
			$('.measurements_update').removeClass 'hidden'
			$('#measurement').parent().removeClass 'done'
			$('#measurement').parent().addClass 'selected'
			$('#measurement').parent().siblings().removeClass 'selected'
			$('#measurement').parent().prevAll().addClass 'done'
			$('#measurement').parent().nextAll().addClass 'done'
		
		
		
		

	onFormSubmit : (_formData)=>
		$('.loadingconusme').html '<img src="'+_SITEURL+'/wp-content/themes/twentytwelve/xoomaapp/images/ajax-loader.gif" width="40px">'
		
		count = 0
		$.each @measurements , (ind,val)->
			if (!($.isNumeric(val))) && val!="" && ind != 'date' 
				count++ 
				$('.loadingconusme').html ""
				window.removeMsg()
				$('.aj-response-message').addClass('alert alert-danger').text("Measurement entered for part of the body is incorrect")
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
		$('.loadingconusme').html ""
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
		$('.loadingconusme').html ""
		window.removeMsg()
		@ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be saved due to some error!")
			
		$('html, body').animate({
							scrollTop: 0
							}, 'slow')

	valueOutput : (element) =>
		if element.id == 'height'

			temparr = $(element).val().split('.')
			if temparr.length == 1
				temparr.push 0
			$('.heightcms').text temparr[0]+"'"+temparr[1]+'"'
			
			ftcm = 30.48 * parseFloat(temparr[0])
			inchcm = 2.54 * parseFloat(temparr[1])
			cms  = parseFloat(ftcm) + parseFloat(inchcm)
			$('.convertheight').text cms.toFixed(2)+ ' Cms'
		else
			pounds = $(element).val()
			onepound = 0.4535
			xpound = parseFloat(onepound) * parseFloat(pounds)
			$('.convertweight').text xpound.toFixed(2)+' Kgs'
			$('.weightcms').text $(element).val()


class App.UserMeasurementCtrl extends Ajency.RegionController

	initialize: (options)->

		@show @parent().parent().getLLoadingView()
		url = '#'+App.currentUser.get 'state'
		computed_url = '#'+window.location.hash.split('#')[1]
		if url != computed_url && url != '#/home' && App.currentUser.get('measurements') == undefined

			@show new workflow


		else
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