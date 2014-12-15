
class App.ProfilePersonalInfoCtrl extends Marionette.RegionController
	initialize: (options)->

		@user = @_get_user_details()

		@show new ProfilePersonalInfoView @user



	_get_user_details:->
		$.ajax
			method : 'GET',
			url : _SITEURL+'/wp-json/profiles/2',
			data : '',
			success:(response)->
				response_data = response
				user_model = App.currentUser
				user_model.set 'xooma_member_id' , response_data.response.xooma_member_id
				user_model.set 'name' , response_data.response.name
				user_model.set 'email_id' , response_data.response.email
				user_model.set 'image' , response_data.response.image
				user_model.set 'gender' , response_data.response.gender
				user_model.set 'phone_no' , response_data.response.phone_no
				user_model.set 'timezone' , response_data.response.timezone
				user_model.set 'attachment_id' , response_data.response.attachment_id
				user_model.set 'user_products' , response_data.response.user_products
				return user_model
				

			
			error:(error)->
				$('.response_msg').text "Something went wrong" 