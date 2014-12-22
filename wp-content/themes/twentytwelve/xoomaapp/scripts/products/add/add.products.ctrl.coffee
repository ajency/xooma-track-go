

class ProductChildView extends Marionette.ItemView

	tagName : 'li'

	template : '<span>{{name}}</span><button data-del="{{id}}" class="btn btn-primary btn-lg add-product">Add Product</button>'


	ui :
    	addProduct : '.add-product'

    events:
    	'click @ui.addProduct':(e)->
    		console.log $('#'+e.target.id).attr('data-del')

class NoProductsChildView extends Marionette.ItemView
	template : 'Awesome. You have added all products. Have fun'

class AddProductsView extends Marionette.CompositeView
	class : 'animated fadeIn'
	template : '<ul class="products-list"></ul>'
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
		filteredCollection = new Backbone.Collection

		c = App.productCollection.without userProducts
		@show new AddProductsView
						collection : App.productCollection
