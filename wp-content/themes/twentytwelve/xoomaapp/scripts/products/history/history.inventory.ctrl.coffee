App.state 'ViewInventory',
					url : '/inventory/:id/view'
					parent : 'xooma'
		

class InventoryChildView extends Marionette.CompositeView

	tagName : 'li'

	template : '<div><span>{{date}}</span></div><div><span>{{type}}</span></div><br/>
				<div><span>Stock updated(+):</span>{{stock}}</div><br/>
				<div><span>Samples to customer(-):</span>{{sales}}</div><br/>
				<div><span>Consumed(-) :</span>{{consumption}}</div><br/>'


class ViewInventoryView extends Marionette.CompositeView

	class : 'animated fadeIn'

	template : '#view-inventory-template'

	childView : InventoryChildView

	childViewContainer : 'ul.viewInventory'

class App.ViewInventoryCtrl extends Ajency.RegionController
	initialize : (options = {})->
		productId  = @getParams()
		products = []
		App.UserProductsColl.each (val)->
			$.each val.get('products') , (index,value)->
						products.push value
		
		productsColl =  new Backbone.Collection products
		productModel = productsColl.where({id:parseInt(productId[0])})
		@_showView(productModel[0])

	_showView:(model)->
		console.log product = model.get('id')
		
		$.ajax
			method : 'GET'
			url : "#{_SITEURL}/wp-json/inventory/#{App.currentUser.get('ID')}/products/#{product}"
			success : @successHandler
			error : @errorHandler	

	successHandler:(response,status,xhr)=>
		coll = new Backbone.Collection response
		@show new ViewInventoryView
				collection : coll	
					