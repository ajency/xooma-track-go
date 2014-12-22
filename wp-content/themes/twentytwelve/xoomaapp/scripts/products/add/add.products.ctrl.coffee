

class ProductChildView extends Marionette.ItemView
	template : 'Single product view here'

class NoProductsChildView extends Marionette.ItemView
	template : 'Awesome. You have added all products. Have fun'

class AddProductsView extends Marionette.CompositeView
	class : 'animated fadeIn'
	template : '<ul class="products-list"></ul>'
	childView : ProductChildView
	childViewContainer : 'ul.products-list'
	emptyView : NoProductsChildView


class App.AddProductsCtrl extends Marionette.RegionController
	initialize : (options = {})->
		if App.productCollection.length is 0
			App.productCollection.fetch().done @_showProducts
		else
			@_showProducts()

	_showProducts : ->
		userProducts = App.currentUser.get 'products'
		filteredCollection = new Backbone.Collection

		c = App.productCollection.without userProducts
		console.log c
		@show new AddProductsView
						collection : App.productCollection
