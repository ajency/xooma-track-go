
class App.ProfileMeasurementCtrl extends Marionette.RegionController

	initialize: (options)->

		@user = @_get_measurement_details()

		App.execute "when:fetched", [@user], =>
			@show new ProfileMeasurementsView
				model : @user


	_get_measurement_details:->
		$.ajax
			method : 'GET',
			url : _SITEURL+'/wp-json/measurements/128',
			data : '',
			success:(response)->
				App.currentUser.set 'height' , response.response.height
				App.currentUser.set 'weight' , response.response.weight
				App.currentUser.set 'neck' , response.response.neck
				App.currentUser.set 'chest' , response.response.chest
				App.currentUser.set 'arm' , response.response.arm
				App.currentUser.set 'waist' , response.response.waist
				App.currentUser.set 'hips' , response.response.hips
				App.currentUser.set 'thigh' , response.response.thigh
				App.currentUser.set 'midcalf' , response.response.midcalf
				
			error:(error)->
				$('.response_msg').text "Something went wrong" 

		return App.currentUser