
class App.ProfileMeasurementCtrl extends Marionette.RegionController

	initialize: (options)->

		@user = @_get_measurement_details()

		App.execute "when:fetched", [@user], =>
			@show new ProfileMeasurementsView
				model : @user


	_get_measurement_details:->
		$.ajax
			method : 'GET',
			url : _SITEURL+'/wp-json/measurements/2',
			data : '',
			success:(response)->
				App.currentUser.set 'height' , response.response.height
				App.currentUser.set 'weight' , response.response.weight
				

			
			error:(error)->
				$('.response_msg').text "Something went wrong" 

		return App.currentUser