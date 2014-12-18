App.LoginCtrl = Ajency.LoginCtrl
App.NothingFoundCtrl  = Ajency.NothingFoundCtrl

_.extend Ajency.CurrentUser::,

	saveMeasurements : (measurements)->

		_successHandler = (resp)=>
			@set 'measurements', measurements

		$.ajax
			method : 'PUT',
			url : "#{_SITEURL}/wp-json/users/#{App.currentUser.get('ID')}/measurements",
			data : measurements,
			success: _successHandler
