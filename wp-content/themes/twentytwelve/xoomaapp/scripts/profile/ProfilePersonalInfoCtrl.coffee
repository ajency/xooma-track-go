
class App.ProfilePersonalInfoCtrl extends Marionette.RegionController
	initialize: (options)->
		@user = @_get_user_details()

		App.execute "when:fetched", [@user], =>
			console.log @user
			@show new ProfilePersonalInfoView 
					model: @user
					



	_get_user_details:->
		$.ajax
			method : 'GET',
			url : _SITEURL+'/wp-json/profiles/'+App.currentUser.get('ID'),
			data : '',
			success:(response)->
				
				
				
				

			
			error:(error)->
				# $('.response_msg').text "Something went wrong" 


		return response.response




