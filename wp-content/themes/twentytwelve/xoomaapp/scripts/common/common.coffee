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

	saveProfiles : (profiles)->

		_successHandler = (resp)=>
			@set 'profiles', profiles

		$.ajax
			method : 'POST'
			url : "#{_SITEURL}/wp-json/profiles/#{App.currentUser.get('ID')}"
			data : profiles
			success:_successHandler

			   

	getFacebookPicture : ->
		options =
			"redirect": false
			"height": "200"
			"type": "normal"
			"width": "200"

		FB.api "/me/picture",options,(resp)->
			if resp and not resp.error
				App.currentUser.set 'profile_picture',
					id : 0
					sizes :
						thumbnail :
							url : resp.data.url


	hasProfilePicture : ->
		profilePicture = @get 'profile_picture'
		(parseInt(profilePicture.id) isnt 0) or not _.isUndefined profilePicture.type



class Ajency.HTTPRequestFailView extends Marionette.ItemView
	template : 'Request page not  Found'


class Ajency.HTTPRequestCtrl extends Marionette.RegionController
	initialize: (options)->
		@show new Ajency.HTTPRequestFailView

