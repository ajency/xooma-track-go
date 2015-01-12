App.state 'AddProducts',
					url : '/products'
					parent : 'xooma'
	

class ProductChildView extends Marionette.ItemView

	tagName : 'li'

	template : '<a class="cbp-vm-image" href="#"><img src="{{image}}"></a>
							<h3 class="cbp-vm-title">{{name}}</h3>
							<div class="cbp-vm-details">
								{{description}}
							</div>
						<a id="{{id}}"  class="cbp-vm-icon cbp-vm-add add-product" href="#/products/{{id}}/edit">Add Product</a>'


	ui :
    	addProduct : '.add-product'

    initialize:->
    	@$el.prop("id", 'product'+@model.get("id"))

    # events:
    # 	'click @ui.addProduct':(e)->
    # 		e.preventDefault()
    # 		id = e.target.id
    		# App.currentUser.addProduct(id).done(@successHandler).fail @errorHandler

    successHandler:(response, status, xhr)=>
    	console.log status
    	if xhr.status == 201
    		$('#product'+response).hide()
		

	
    		

class NoProductsChildView extends Marionette.ItemView
	template : 'Awesome. You have added all products. Have fun'

class AddProductsView extends Marionette.CompositeView
	class : 'animated fadeIn'
	template : '#add-product-template'
	childView : ProductChildView
	childViewContainer : 'ul.products-list'
	emptyView : NoProductsChildView

	onShow:->
		$.getScript(_SITEURL+"/html/html/assets/js/cbpViewModeSwitch.js", (item)->
			console.log "loaded"
			)
		


class App.AddProductsCtrl extends Ajency.RegionController
	initialize : (options = {})->
		if App.productCollection.length is 0
			App.productCollection.fetch().done @_showProducts
		else
			@_showProducts()

	_showProducts : =>
		userProducts = App.currentUser.get 'products'
		collectionArr = App.productCollection.where({active_value:'1'})
		App.productCollection.reset collectionArr
		filteredCollection = App.productCollection.clone()
		
			
		c = filteredCollection.remove userProducts
		@show new AddProductsView
						collection : filteredCollection
