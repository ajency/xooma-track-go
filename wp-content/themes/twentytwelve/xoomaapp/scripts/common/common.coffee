App.LoginCtrl = Ajency.LoginCtrl
App.NothingFoundCtrl  = Ajency.NothingFoundCtrl
#Ajency.CurrentUserView::template = '#current-user-template'

_.extend Marionette.Application::,

	isLoggedInState : (stateName)->
		notLoggedInStates = [
			'login'
		]
		notLoggedInStates.indexOf(stateName) is -1

_.extend Ajency.CurrentUser::,

	_getUrl : (property)->
		"#{APIURL}/users/#{App.currentUser.get('ID')}/#{property}"

	saveMeasurements : (measurements)->

		_successHandler = (resp)=>
			@set 'measurements', measurements

		$.ajax
			method : 'POST'
			url : @_getUrl 'measurements'
			data : measurements
			success: _successHandler

	getProfile : ()->
		deferred = Marionette.Deferred()

		_successHandler = (response, status,responseCode)=>
			@set 'profile', response
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
			data : JSON.stringify profile
			success:_successHandler


	hasProfilePicture : ->
		return false unless @has 'profile_picture'
		profilePicture = @get 'profile_picture'
		(parseInt(profilePicture.id) isnt 0) or not _.isUndefined profilePicture.type

	addProduct : (id)->
		_successHandler = (response, status, xhr)=>
			if xhr.status is 201
				products = @get 'products'
				if typeof products == 'undefined'
					products = []
				products = _.union products, [response]
				@set 'products', products

		$.ajax
			method : 'POST'
			url : @_getUrl 'products'
			data : 'productId='+id
			success: _successHandler

	getUserProducts : ->
		_successHandler = (response, status, xhr)=>
			if xhr.status is 200
				console.log response

		$.ajax
			method : 'GET'
			url : @_getUrl 'products'
			success: _successHandler



class Ajency.HTTPRequestFailView extends Marionette.ItemView
	template : 'Requested page not  Found'


class Ajency.HTTPRequestCtrl extends Marionette.RegionController
	initialize: (options)->
		@show new Ajency.HTTPRequestFailView

