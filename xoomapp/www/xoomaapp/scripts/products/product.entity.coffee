
class ProductModel extends Backbone.Model
	defaults : ->


class ProductCollection extends Backbone.Collection
	model : ProductModel
	url : ->
		"#{APIURL}/products"

App.productCollection = new ProductCollection()

class UserProductModel extends Backbone.Model
	defaults : ->

class UserProductCollection extends Backbone.Collection
	model : UserProductModel


App.useProductColl = new UserProductCollection()





