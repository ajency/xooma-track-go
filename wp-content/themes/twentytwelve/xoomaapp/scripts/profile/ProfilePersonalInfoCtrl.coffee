
class App.ProfilePersonalInfoCtrl extends Marionette.RegionController

	initialize: (options)->
		xhr = @_get_user_details()
		xhr.done(@_showView).fail @_showView

	_showView :=>
		@show new ProfilePersonalInfoView
								model : App.currentUser


	_get_user_details:->
		if not App.currentUser.has 'profiles'
			$.ajax
				method : 'GET'
				url : "#{_SITEURL}/wp-json/profiles/#{App.currentUser.get('ID')}"
				success:@successHandler
		else
			deferred = Marionette.Deferred()
			deferred.resolve(true)
			deferred.promise()
				
	successHandler:(response, status)=>
		App.currentUser.set 'profiles' , response.response




