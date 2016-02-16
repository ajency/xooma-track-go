App.state 'AddProducts',
					url : '/products'
					parent : 'xooma'
	

class ProductChildView extends Marionette.ItemView

	tagName : 'li'

	template : '<div class="cbp-vm-image" ><img src="{{image}}"></div>
							<h3 class="cbp-vm-title">{{name}}</h3>
							<div class="cbp-vm-details">
								{{description}}
							</div>
						<a id="{{id}}"  class="cbp-vm-icon cbp-vm-add add-product" href="#/product/{{id}}/edit">Add</a>'


	ui :
    	addProduct : '.add-product'

    initialize:->
    	@$el.prop("id", 'product'+@model.get("id"))

   


   
		

	
    		

class NoProductsChildView extends Marionette.ItemView
	template : 'Awesome. You have added all products. Have fun'

class AddProductsView extends Marionette.CompositeView
	class : 'animated fadeIn'
	template : '#add-product-template'
	childView : ProductChildView
	childViewContainer : 'ul.products-list'
	emptyView : NoProductsChildView

	events:
    	'click .grid':(e)->
    		e.preventDefault()

    onShow:->
    	@trigger "remove:loader"
	    $.getScript(_SITEURL+"/html/html/assets/js/cbpViewModeSwitch.js", (item)->
	        )

    

	
		


class App.AddProductsCtrl extends Ajency.RegionController
	initialize : (options = {})->

		@listenTo @, "remove:loader" , @removeLoader

		url = '#'+App.currentUser.get 'state'
		computed_url = '#'+window.location.hash.split('#')[1]
		if url!= '#/profile/my-products'  && url != '#/home' 
			@show new workflow
		else
			if App.productCollection.length is 0
				App.productCollection.fetch().done(@_showProducts).fail(@errorHandler)
			else
				@_showProducts()

	removeLoader:=>
		@show @parent().getLLoadingView()
		

	_showProducts : =>
		userProducts = App.currentUser.get 'products'
		collectionArr = App.productCollection.where({active_value:'1'})
		temp = []
		$.each collectionArr , (ind,val)->
			if $.inArray(parseInt(val.get('id')),userProducts) == -1
				temp.push val
		filteredCollection = App.productCollection.clone()
		filteredCollection.reset temp
		@show new AddProductsView
						collection : filteredCollection

	
		