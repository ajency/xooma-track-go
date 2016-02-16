App.state 'ViewInventory',
					url : '/inventory/:id/view'
					parent : 'xooma'
		

class InventoryChildView extends Marionette.ItemView

	tagName : 'li'

	className : '.class'

	template : '<input class="radio" id ="work{{id}}" name="works" type="radio" checked>
    <div class="relative">
      <label class="labels" for="work{{id}}">{{product_type}}</label>
      <span class="date">{{date}}</span>
      <span class="circle"></span>
    </div>
    <div class="content">
     <p>
      Stock updated(+) : <b>{{stock}}</b><br>
      Samples to customer(-) :<b>{{sales}}</b><br>
      Consumed(-) : <b>{{consumption}}</b><br>
     </p>
    </div>'
  


class ViewInventoryView extends Marionette.CompositeView

	class : 'animated fadeIn'

	template : '#view-inventory-template'

	childView : InventoryChildView

	

	childViewContainer : 'ul.viewInventory'

	onShow:->
		ID  = Marionette.getOption( @, 'ID' )
		model = App.useProductColl.findWhere({id:parseInt(ID)})
		$('.product_name').text model.get 'name'
		if parseInt(@collection.length) == 1
			$('.bottle-msg').hide()

class App.ViewInventoryCtrl extends Ajency.RegionController
	initialize : (options = {})->
		@show @parent().getLLoadingView()
		productId  = @getParams()
		products = []
		productModel = App.useProductColl.where({id:parseInt(productId[0])})
		product = productId[0]
		if productModel == undefined || productModel.length == 0
			App.currentUser.getUserProducts().done(@_showView).fail @errorHandler
		else
			@_showHistoryView(productModel[0])

	_showView:(collection)=>
		
		productId  = @getParams()
		productModel = App.useProductColl.where({id:parseInt(productId[0])})
		@_showHistoryView(productModel[0])

	_showHistoryView:(model)->
		@show @parent().getLLoadingView()
		product = model.get('id')
		$.ajax
			method : 'GET'
			url : "#{APIURL}/inventory/#{App.currentUser.get('ID')}/products/#{product}"
			success : @successHandler
			error : @errorHandler	

	successHandler:(response,status,xhr)=>
		if xhr.status == 200
			coll = new Backbone.Collection response.response
			@show new ViewInventoryView
					collection : coll
					ID : response.ID

		else
			window.removeMsg()
			$('.aj-response-message').addClass('alert alert-danger').text("Details could not be loaded!")
			$('html, body').animate({
							scrollTop: 0
							}, 'slow')

	errorHandler:(response,status,xhr)=>	
		window.removeMsg()
		$('.aj-response-message').addClass('alert alert-danger').text("Details could not be loaded!")
		$('html, body').animate({
							scrollTop: 0
							}, 'slow')