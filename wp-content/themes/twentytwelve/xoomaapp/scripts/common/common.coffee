App.LoginCtrl = Ajency.LoginCtrl
App.NothingFoundCtrl  = Ajency.NothingFoundCtrl

_.extend Ajency.CurrentUser::,

	_getUrl : (property)->
		"#{_SITEURL}/wp-json/users/#{App.currentUser.get('ID')}/#{property}"

	saveMeasurements : (measurements)->

		_successHandler = (resp)=>
			@set 'measurements', measurements

		$.ajax
			method : 'PUT'
			url : @_getUrl 'measurements'
			data : measurements
			success: _successHandler

	getProfile : ()->
		deferred = Marionette.Deferred()

		_successHandler = (response, status,responseCode)=>
			@profile.set 'profile', response
			deferred.resolve @

		if not @has 'profile'
			$.ajax
				method : 'GET'
				url : @_getUrl 'profile'
				success: _successHandler
		else
			deferred.resolve @

		deferred.promise()

	saveProfile : (profile)->

		_successHandler = (resp)=>
			@set 'profile', profile

		$.ajax
			method : 'PUT'
			url : @_getUrl 'profile'
			data : profiles
			success:_successHandler


	hasProfilePicture : ->
		return false unless @has 'profile_picture'
		profilePicture = @get 'profile_picture'
		(parseInt(profilePicture.id) isnt 0) or not _.isUndefined profilePicture.type



class Ajency.HTTPRequestFailView extends Marionette.ItemView
	template : 'Request page not  Found'


class Ajency.HTTPRequestCtrl extends Marionette.RegionController
	initialize: (options)->
		@show new Ajency.HTTPRequestFailView

