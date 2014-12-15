
class App.ProfilePersonalInfoCtrl extends Ajency.RegionController

	initialize:->
		console.log "sssssssssss"
		@user = @_get_user_details()

		@view = new ProfilePersonalInfoView @user

		@show @view


	_get_user_details:->
		$.ajax
			method : 'GET',
			url : SITEURL+'/wp-json/profiles/2',
			data : '',
			success:(response)->
				user_model = new Backbone.Model 
				user_model.set 'xooma_member_id' , response.xooma_member_id
				user_model.set 'name' , response.name
				user_model.set 'email_id' , response.email
				user_model.set 'image' , response.image
				user_model.set 'gender' , response.gender
				user_model.set 'phone_no' , response.phone_no
				user_model.set 'timezone' , response.timezone
				user_model.set 'attachment_id' , response.attachment_id
				user_model.set 'user_products' , response.user_products
				return user_model
				

			
			error:(error)->
				$('.response_msg').text "Something went wrong" 