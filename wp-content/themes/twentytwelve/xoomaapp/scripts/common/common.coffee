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

	getFacebookPicture : ->
		facebookConnectPlugin.api "/me/picture",[],(resp)->
			if resp and not resp.error
				App.currentUser.set 'profile_picture',
					id : 0
					sizes :
						thumbnail :
							url : resp.data.url

