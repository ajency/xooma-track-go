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

class App.ViewInventoryCtrl extends Ajency.RegionController
	initialize : (options = {})->
		@show @parent().getLLoadingView()
		productId  = @getParams()
		products = []
		productModel = App.UserProductsColl.where({id:parseInt(productId[0])})
		@_showView(productModel[0])

	_showView:(model)->
		product = model.get('id')
		
		$.ajax
			method : 'GET'
			url : "#{_SITEURL}/wp-json/inventory/#{App.currentUser.get('ID')}/products/#{product}"
			success : @successHandler
			error : @errorHandler	

	successHandler:(response,status,xhr)=>
		if xhr.status == 200
			coll = new Backbone.Collection response
			@show new ViewInventoryView
					collection : coll
		else
			$('.alert').remove()
			$('.aj-response-message').addClass('alert alert-danger').text("Details could not be loaded!")
			
	errorHandler:(response,status,xhr)=>	
		$('.alert').remove()
		$('.aj-response-message').addClass('alert alert-danger').text("Details could not be loaded!")
		