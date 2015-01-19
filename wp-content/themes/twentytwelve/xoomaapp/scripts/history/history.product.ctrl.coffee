App.state 'ViewProductHistory',
					url : '/product/:id/history'
					parent : 'xooma'


class ProductHistoryChildView extends Marionette.ItemView

	tagName : 'li'

	template : '<div>{{qty}}</div><div>{{date}}</div>'


class ViewProductHistoryView extends Marionette.CompositeView

	template : '#view-history-template'

	childView : ProductHistoryChildView

	childViewContainer : 'ul.viewHistory'


class App.ViewProductHistoryCtrl extends Ajency.RegionController
	initialize : (options = {})->
		productId  = @getParams()
		products = []
		@_showView(productId[0])

	_showView:(model)->
		product = model
		
		$.ajax
			method : 'GET'
			data : 'date=2015-01-13'
			url : "#{_SITEURL}/wp-json/history/#{App.currentUser.get('ID')}/products/#{product}"
			success : @successHandler
			error : @errorHandler	

	successHandler:(response,status,xhr)=>
		coll = new Backbone.Collection response
		@show new ViewProductHistoryView
				collection : coll