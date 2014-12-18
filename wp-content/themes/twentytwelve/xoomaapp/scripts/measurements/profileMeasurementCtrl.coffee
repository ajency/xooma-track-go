
class App.ProfileMeasurementCtrl extends Marionette.RegionController

	initialize: (options)->
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
			console.log deferred = Marionette.Deferred
			deferred.resolve()

	errorHandler : (error)->
		@show new Ajency.HTTPRequestFailView

	successHandler : (response, status)=>
		App.currentUser.set 'measurements', response