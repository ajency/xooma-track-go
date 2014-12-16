
class App.ProfileMeasurementCtrl extends Marionette.RegionController

	initialize: (options)->

		@user = @_get_measurement_details()

		@show new ProfileMeasurementsView


	_get_measurement_details:->
		$.ajax
			method : 'GET',
			url : _SITEURL+'/wp-json/measurements/2',
			data : '',
			success:(response)->
				
				

			
			error:(error)->
				$('.response_msg').text "Something went wrong" 