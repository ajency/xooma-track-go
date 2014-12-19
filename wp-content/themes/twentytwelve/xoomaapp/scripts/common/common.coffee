App.LoginCtrl = Ajency.LoginCtrl
App.NothingFoundCtrl  = Ajency.NothingFoundCtrl

_.extend Ajency.CurrentUser::,

	saveMeasurements : (measurements)->

		_successHandler = (resp)=>
			@set 'measurements', measurements

		$.ajax
			method : 'POST',
			url : "#{_SITEURL}/wp-json/users/#{App.currentUser.get('ID')}/measurements",
			data : measurements,
			success: _successHandler

	hasProfilePicture : ->
		profilePicture = @get 'profile_picture'
		(parseInt(profilePicture.id) isnt 0) or not _.isUndefined profilePicture.type


class Ajency.HTTPRequestFailView extends Marionette.ItemView
	template : 'Request page not  Found'



