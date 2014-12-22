
class ProductItemView extends Marionette.ItemView

	template  : '<span>product1</span><button class="btn btn-primary btn-lg addProduct">Add Prodcut</button>'

	
	ui :
		addProduct : '.addProduct'


	events:
		'click @ui.addProduct':(e)->
			


class ProductListView extends Marionette.CompositeView

	template  : '<ul class="productList"><ul>'

	childView : ProductItemView

	childViewContainer : '.productList'