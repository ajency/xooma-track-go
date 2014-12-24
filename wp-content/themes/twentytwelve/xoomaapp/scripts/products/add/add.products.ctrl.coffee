

class ProductChildView extends Marionette.ItemView

	tagName : 'li'

	template : '<span>{{name}}</span><button id="{{id}}"  class="btn btn-primary btn-lg add-product">Add Product</button>'


	ui :
    	addProduct : '.add-product'

    initialize:->
    	@$el.prop("id", 'product'+@model.get("id"))

    events:
    	'click @ui.addProduct':(e)->
    		id = e.target.id
    		App.currentUser.addProduct(id).done(@successHandler).fail @errorHandler

    successHandler:(response, status, xhr)=>
    	console.log status
    	if xhr.status == 201
    		$('#product'+response).hide()
		

	
    		

class NoProductsChildView extends Marionette.ItemView
	template : 'Awesome. You have added all products. Have fun'

class AddProductsView extends Marionette.CompositeView
	class : 'animated fadeIn'
	template : '<ul class="products-list">
			</ul><a href="#/profile/my-products" class="btn btn-primary btn-lg center-block" >
				<i class="fa fa-plus-circle"></i>Next</a>'
	childView : ProductChildView
	childViewContainer : 'ul.products-list'
	emptyView : NoProductsChildView


class App.AddProductsCtrl extends Ajency.RegionController
	initialize : (options = {})->
		if App.productCollection.length is 0
			App.productCollection.fetch().done @_showProducts
		else
			@_showProducts()

	_showProducts : =>
		userProducts = App.currentUser.get 'products'
		filteredCollection = App.productCollection.clone()
		
			
		c = filteredCollection.remove userProducts
		@show new AddProductsView
						collection : filteredCollection
