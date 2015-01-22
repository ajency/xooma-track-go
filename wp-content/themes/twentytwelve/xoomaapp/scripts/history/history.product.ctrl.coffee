App.state 'ViewProductHistory',
					url : '/product/:id/history'
					parent : 'xooma'


class ProductHistoryChildView extends Marionette.ItemView

	tagName : 'li'

	className : '.class'

	template : '<input class="radio" id ="work{{meta_id}}" name="works" type="radio" checked>
				    <div class="relative">
				      <label class="labels" for="work{{meta_id}}">{{product_type}}</label>
				      <span class="date">{{date}}</span>
				      <span class="circle"></span>
				    </div>
				    <div class="content">
				     <p>
				      Consumed : <b>{{qty}}</b><br>
				      Time : <b>{{time}}</b><br>
				      </p>
				    </div>'
	serializeData:->
		data = super()
		meta_value = @model.get 'meta_value'
		timezone = App.currentUser.get 'timezone'
		data.time = moment(meta_value.date+timezone, "HH:mm Z").format("hA")
		data.qty = meta_value.qty
		data


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
		date = moment().format("YYYY-MM-DD")
		$.ajax
			method : 'GET'
			data : 'date='+date
			url : "#{_SITEURL}/wp-json/history/#{App.currentUser.get('ID')}/products/#{product}"
			success : @successHandler
			error : @errorHandler	

	successHandler:(response,status,xhr)=>
		coll = new Backbone.Collection response
		@show new ViewProductHistoryView
				collection : coll