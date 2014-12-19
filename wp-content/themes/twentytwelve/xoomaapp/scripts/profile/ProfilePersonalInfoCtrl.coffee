
class App.ProfilePersonalInfoCtrl extends Marionette.RegionController

	initialize: (options)->
		if _.onlineStatus() is false
			window.plugins.toast.showLongBottom("Please check your internet connection.");
			# return false
		else
			xhr = @_get_user_details()
			xhr.done(@_showView).fail @errorHandler

	_showView :=>
		@show new App.ProfilePersonalInfoView
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


	errorHandler : (error)->
		@region =  new Marionette.Region el : '#nofound-template'
		new Ajency.HTTPRequestCtrl region : @region
				
	successHandler:(response, status)=>
		App.currentUser.set 'profiles' , response.response




