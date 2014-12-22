
class App.ProductListCtrl extends Marionette.RegionController

	initialize:(options)->
		xhr = @_getProducts()
		xhr.done(@_showView).fail @_showView
		
	_showView:(response)=>
		newProducts = @_getNewProducts(response)
		@show new ProductListView 
					collection : newProducts


	_getProducts:->
		$.ajax
				method : 'GET'
				url : "#{_SITEURL}/wp-json/products"
				success: @successHandler
				error: @errorHandler

	successHandler : (response, status,responsecode)=>
		if responsecode.status == 200 
			App.productList = new Backbone.Collection response
			
			
		

	_getNewProducts:(response)->
		productIds = []
		#get all product ids in an array
		$.each response , (index,value) ->
			productIds.push parseInt(value.id)
		#products minus users list of products
		App.currentUser.set 'userProducts' , [142,132]
		userProducts = App.currentUser.get 'userProducts';
		newProducts = _.difference(productIds,userProducts);
		new Backbone.Collection newProducts

			