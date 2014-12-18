
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
				response_data = response
				App.currentUser.set 'xooma_member_id' , response_data.response.xooma_member_id
				App.currentUser.set 'name' , response_data.response.name
				App.currentUser.set 'email_id' , response_data.response.user_email
				App.currentUser.set 'display_name' , response_data.response.display_name
				App.currentUser.set 'gender' , response_data.response.gender
				App.currentUser.set 'phone_no' , response_data.response.phone_no
				App.currentUser.set 'timezone' , response_data.response.timezone
				App.currentUser.set 'birth_date' , response_data.response.birth_date
				App.currentUser.set 'user_products' , response_data.response.user_products
				
				
				

			
			error:(error)->
				$('.response_msg').text "Something went wrong" 


		return App.currentUser




