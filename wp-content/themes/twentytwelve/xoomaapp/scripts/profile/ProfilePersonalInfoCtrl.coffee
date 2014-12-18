
class App.ProfilePersonalInfoCtrl extends Marionette.RegionController
	initialize: (options)->
		if _.onlineStatus() is false
			window.plugins.toast.showLongBottom("Please check your internet connection.");
			# return false
		else
			@user = @_get_user_details()

		App.execute "when:fetched", [@user], =>
			console.log @user
			@show new App.ProfilePersonalInfoView 
					model: @user
					



	_get_user_details:->
		$.ajax
			method : 'GET',
			url : _SITEURL+'/wp-json/profiles/2'#+App.currentUser.get('ID'), Id changed for mobile
			data : '',
			success:(response)->
				response_data = response
				App.currentUser.set 'xooma_member_id' , response_data.response.xooma_member_id
				App.currentUser.set 'name' , response_data.response.name
				App.currentUser.set 'email_id' , response_data.response.email
				App.currentUser.set 'image' , response_data.response.image
				App.currentUser.set 'gender' , response_data.response.gender
				App.currentUser.set 'phone_no' , response_data.response.phone_no
				App.currentUser.set 'timezone' , response_data.response.timezone
				App.currentUser.set 'birth_date' , response_data.response.birth_date
				App.currentUser.set 'user_products' , response_data.response.user_products
				
				
				

			
			error:(error)->
				$('.response_msg').text "Something went wrong" 


		return App.currentUser




