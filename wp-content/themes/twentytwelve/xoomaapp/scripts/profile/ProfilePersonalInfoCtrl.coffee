
class App.ProfilePersonalInfoCtrl extends Marionette.RegionController

	initialize: (options)->
		xhr = @_get_user_details()
		xhr.done(@_showView).fail @errorHandler

	_showView :=>
		@show new ProfilePersonalInfoView
						model : App.currentUser


	_get_user_details:->
		if not App.currentUser.has 'profile'
			$.ajax
				method : 'GET'
				url : "#{_SITEURL}/wp-json/profiles/#{App.currentUser.get('ID')}"
				success:@successHandler
		else
			deferred = Marionette.Deferred()
			deferred.resolve(true)
			deferred.promise()

	errorHandler : (error)->
		@region =  new Marionette.Region el : '#nofound-template'
		new Ajency.HTTPRequestCtrl region : @region

	successHandler:(response, status,responseCode)=>
		if responseCode.status is 404
			@region =  new Marionette.Region el : '#nofound-template'
			new Ajency.HTTPRequestCtrl region : @region
		else
			App.currentUser.set 'profile' , response




