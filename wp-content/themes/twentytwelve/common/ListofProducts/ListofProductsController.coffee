
class Xoomapp.ListofProductsController extends Ajency.RegionController

	initialize:->

		@products = @_get_users_products()

		@view = new Xoomapp.ListofProductsView @products

		@show @view


	_get_users_products:->
		$.ajax
			method : 'GET',
			url : SITEURL+'/wp-json/products',
			data : '',
			success:(response)->
				console.log response
				
				

			
			error:(error)->
				$('.response_msg').text "Something went wrong" 