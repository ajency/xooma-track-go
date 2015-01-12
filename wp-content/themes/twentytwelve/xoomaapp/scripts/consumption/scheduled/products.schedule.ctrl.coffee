App.state 'Schedule',
					url : '/products/:id/consume'
					parent : 'xooma'

class ScheduleView extends Marionette.ItemView

	template : '#asperbmi-template'
		
class App.ScheduleCtrl extends Ajency.RegionController
	initialize : (options = {})->
		productId  = @getParams()
		product = parseInt productId[0]
		@_showView(product)

	_showView:(productModel)->
		console.log productModel
		@show new ScheduleView
					model : productModel