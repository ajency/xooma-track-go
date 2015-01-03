
class EditProductsView extends Marionette.ItemView

	template : '#edit-product-template'

	


class App.EditProductsCtrl extends Ajency.RegionController
	initialize : (options = {})->
		productId  = @getParams()
		console.log productModel = App.productCollection.where({id:productId[0]})
		@show new EditProductsView
					model : productModel[0]

	