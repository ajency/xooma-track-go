App.state 'Admin',
				url : '/user_id/:id'
				parent : 'xooma'
				


class AdminView extends Marionette.ItemView

	template  : '#admin-template'




	
				
	onShow:->
		$('.menulink').hide()




	








class App.AdminCtrl extends Ajency.RegionController
	initialize : (options = {})->

		$('.menulink').hide()
		user_id = @getParams()
		id = user_id[0]
		
		
		$.ajax
				method : 'GET'
				url : "#{APIURL}/users/#{id}/profile"
				success: @_successHandler


	_successHandler:(response,status,xhr)=>
		model =  new Ajency.CurrentUser
		console.log 'in admin ctrl',response
		model.set 'display_name' ,  response.display_name
		model.set 'user_email' ,  response.user_email
		model.set 'profile', response
		@show new ProfilePersonalInfoView
							model : model
	
		






		
		