
class App.ProductListCtrl extends Marionette.RegionController

	initialize:->

		@productList = @_get_products()

		@show new ProductListView 


	_get_products:->
		$.ajax
				method : 'GET'
				url : "#{_SITEURL}/wp-json/products"
				success: @successHandler
				error: @errorHandler

	successHandler : (response, status,responsecode)=>
		if responsecode.status == 200 
			newProducts = @_get_new_products(response)
		

	_get_new_products:(response)->
		productIds = []
		$.each response , (index,value) ->
			productIds.push parseInt(value.id)
		console.log productIds
			