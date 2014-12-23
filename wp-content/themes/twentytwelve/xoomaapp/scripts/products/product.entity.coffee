
class ProductModel extends Backbone.Model
	defaults : ->


class ProductCollection extends Backbone.Collection
	model : ProductModel
	url : ->
		"#{APIURL}/products"

App.productCollection = new ProductCollection()
