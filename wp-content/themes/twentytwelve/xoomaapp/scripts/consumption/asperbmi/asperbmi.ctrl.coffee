App.state 'Asperbmi',
					url : '/products/:id/bmi'
					parent : 'xooma'

class AsperbmiView extends Marionette.ItemView

	template : '#asperbmi-template'
		
class App.AsperbmiCtrl extends Ajency.RegionController
	initialize : (options = {})->
		productId  = @getParams()
		product = parseInt productId[0]
		@_showView(product)

	_showView:(productModel)->
		console.log productModel
		@show new AsperbmiView
					model : productModel