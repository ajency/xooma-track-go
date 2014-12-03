
class Xoomapp.MeasurementController extends Ajency.RegionController

	initialize:->

		@user = @_get_measurement_details()

		@view = new Xoomapp.MeasurementView 

		@show @view


	_get_measurement_details:->
		$.ajax
			method : 'GET',
			url : SITEURL+'/wp-json/measurements/2',
			data : '',
			success:(response)->
				
				

			
			error:(error)->
				$('.response_msg').text "Something went wrong" 