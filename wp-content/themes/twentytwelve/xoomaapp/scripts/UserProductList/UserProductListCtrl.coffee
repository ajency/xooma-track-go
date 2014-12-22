
class App.UserProductListCtrl extends Marionette.RegionController

	initialize:->

		@show new UserProductListView 


	_get_users_products:->
		$.ajax
			method : 'GET',
			url : SITEURL+'/wp-json/products',
			data : '',
			success:(response)->
				console.log response
				
				

			
			error:(error)->
				$('.response_msg').text "Something went wrong" 