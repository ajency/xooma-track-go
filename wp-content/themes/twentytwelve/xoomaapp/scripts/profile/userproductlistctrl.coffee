class ProductChildView extends Marionette.ItemView

	tagName : 'div'

	className : 'panel panel-default'

	ui :
		avail 	: '.avail'
		add		: '.add'
		update 	: '.update'
		remove   : '.remove'
		responseMessage : '.aj-response-message'

	initialize:->
		 @$el.prop("id", 'cart'+@model.get("id"))

	template  : '
          <div class="panel-body ">
            <h5 class="margin-none mid-title "> {{name}}
              <i type="button" class="fa fa-ellipsis-v pull-right dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i>
                     <ul class="dropdown-menu pull-right" role="menu">
                        <li class="add hidden"><a href="#/product/{{id}}/edit">Edit product</a></li>
                        <li class="update hidden"><a href="#/inventory/{{id}}/edit">Inventory</a></li>
                        <li class="update hidden"><a href="#/inventory/{{id}}/view">Inventory history</a></li>
                        <li class="divider"></li>
                        <li><a href="#" class="remove hidden">Remove the product</a></li>
                      </ul>
              </h5>
                      <ul class="list-inline   m-t-20">

                        <li class="col-md-7 col-xs-7">
                        	 <div class="row">
                        	{{#servings}}
                        	<div class="col-md-6 text-left">
                        	{{#serving}}
                        	<div class="{{classname}}"></div>
                        	{{/serving}}
                        	</div>	
                        	{{/servings}}	
                        </div>       
                        </li>
                        <li class="col-md-1 col-xs-1">
                    <h4>    <i class="fa fa-random text-muted m-t-20"></i></h4>
                        </li>
                        <li class="col-md-4  col-xs-4 text-center">
                          <span clas="servings_text">{{servings_text}}</span>
                          <i class="fa fa-frown-o {{frown}}"></i>
                          <h2 class="margin-none bold {{newClass}} {{hidden}} avail">{{servingsleft}}</h2>
                         <span class="{{hidden}}">{{containers}} container(s) ({{available}} {{product_type}}(s))</span>
                        </li>
                    </ul>
                </div>
                <div class="panel-footer">
          <i id="bell{{id}}" class="fa fa-bell-slash no-remiander"></i> 
           {{reminder}}
          </div>' 

	events:
		'click .remove':(e)->
			e.preventDefault()
			product = parseInt @model.get('id')
			products = App.currentUser.get 'products'
			$.ajax
					method : 'DELETE'
					url : "#{_SITEURL}/wp-json/trackers/#{App.currentUser.get('ID')}/products/#{product}"
					success: @successHandler
					error :@erroraHandler

	successHandler:(response, status, xhr)=>
		if xhr.status == 200
			products = App.currentUser.get 'products'
			products = _.without(products,parseInt(response))
			App.currentUser.set 'products' , products
			App.useProductColl.remove parseInt(response)
			listview = new UserProductListView
							collection : App.useProductColl
			region =  new Marionette.Region el : '#xoomaproduct'
			region.show listview
			
			

			if parseInt(App.useProductColl.length) == 0
				$('.add1').hide()
				$('.save_products').hide()
			
		else
			@ui.responseMessage.addClass('alert alert-danger').text("Sorry!Couldn't delete the product.")
			$('html, body').animate({
							scrollTop: 0
							}, 'slow')
		

	erroraHandler:(response, status, xhr)=>
		@ui.responseMessage.addClass('alert alert-danger').text("Sorry!Couldn't delete the product.")
		$('html, body').animate({
							scrollTop: 0
							}, 'slow')
	

                            

	onShow:->
		reminder = @model.get('reminder')
		if reminder.length != 0
			$('#bell'+@model.get('id')).removeClass 'fa-bell-slash no-remiander'
			$('#bell'+@model.get('id')).addClass 'fa-bell-o element-animation'
		product = parseInt @model.get('id')
		products = App.currentUser.get 'products'
		if parseInt($.inArray( product, products )) > -1
			@ui.avail.removeClass 'hidden'
			@ui.add.removeClass 'hidden'
			@ui.update.removeClass 'hidden'
			@ui.remove.removeClass 'hidden'

	serializeData:->
		data = super()
		qty = @model.get 'qty'
		product_type = @model.get('product_type')
		product_type = product_type.toLowerCase()
		settings = parseInt(@model.get 'settings') * parseInt(qty.length)
		reminder = @model.get 'reminder'
		type = @model.get('type') 
		name = @model.get('name')
		timezone = @model.get('timezone')
		servings = []
		reminderArr = []
		$.each qty , (index,value)->
			i = 0
			
			servingsqty = []
			while(i < value.qty)
				newClass = product_type+'_default_class'
				if  name.toUpperCase() == 'X2O'
					newClass = 'x2o_default_class'
				servingsqty.push classname : newClass
				i++
			servings.push serving : servingsqty   

		$.each reminder , (ind,val)->
			time  = moment(val.time+timezone, "HH:mm Z").format("h:ss A")
		
			reminderArr.push time

		remind  = reminderArr.join(',')
		if parseInt(reminder.length) == 0 
			remind = 'No Reminder is set'
		available = @model.get 'available'
		total = @model.get 'total'
		containers = parseInt(available)/parseInt(total)
		contacount = Math.ceil containers
		servingsleft = parseInt(available)/parseInt(qty.length)
		totalservings  = parseInt(servingsleft) / 2
		data.servings_text = 'Servings left'
		data.hidden = ''
		data.frown = 'hidden'
		if parseInt(servingsleft) <= parseInt(settings) && parseInt(servingsleft) != 0
			data.newClass = 'text-danger'
		else if parseInt(servingsleft) == 0
			data.newClass = 'text-muted'
			data.servings_text =  'Serivngs out of stock'
			data.hidden = 'hidden'
			data.frown = ''
		else if parseInt(servingsleft) <= parseInt(totalservings) && parseInt(servingsleft) != 0
			data.newClass = 'text-warning'
		else if parseInt(servingsleft) >= parseInt(totalservings) && parseInt(servingsleft) != 0
			data.newClass = 'text-success'
		data.servings = servings
		data.reminder  = remind
		data.containers = contacount
		data.servingsleft = parseInt servingsleft
		data
		
class EmptyView extends Marionette.ItemView	

	template : '<div class="alert alert-danger">Go ahead and add your first product rigt away!</div>'		

class UserProductListView extends Marionette.CompositeView

	class : 'animated fadeIn'

	template : '#produts-template'

	childView : ProductChildView

	emptyView : EmptyView

	childViewContainer : '.userproducts'

	ui :
		saveProducts : '.save_products'
		responseMessage : '.aj-response-message'
		add1			: '.add1'

	events : 
		'click @ui.saveProducts':(e)->
			$.ajax
				method : 'POST'
				url : "#{APIURL}/records/#{App.currentUser.get('ID')}"
				success: @_successHandler
				error: @_errorHandler

		
	onRender:->
		if App.currentUser.get('state') == '/home'
			@ui.saveProducts.hide()
			$('#product').parent().removeClass 'done'
			$('#product').parent().addClass 'selected'
			$('#product').parent().siblings().removeClass 'selected'
			$('#product').parent().prevAll().addClass 'done'
		
		if parseInt(App.useProductColl.length) == 0 || parseInt(App.useProductColl.length) < 10
				@ui.add1.hide()
				
			

	_successHandler:(response, status, xhr)=>
		if xhr.status == 201
			App.currentUser.set 'state' , '/home'
			App.navigate '#/home' , true
		else
			@ui.responseMessage.addClass('alert alert-danger').text("Sorry!Some error occurred.")
			$('html, body').animate({
							scrollTop: 0
							}, 'slow')


	_errorHandler:(response, status, xhr)=>
		@ui.responseMessage.addClass('alert alert-danger').text("Sorry!Some error occurred.")
		$('html, body').animate({
							scrollTop: 0
							}, 'slow')




	
	
	
		
class App.UserProductListCtrl extends Ajency.RegionController

	initialize:->
		@show @parent().parent().getLLoadingView()
		if App.useProductColl.length == 0
			App.currentUser.getUserProducts().done(@_showView).fail @errorHandler
		else
			@show new UserProductListView
						collection : App.useProductColl


	_showView:(collection)=>
		collection = collection.response
		productcollection = new Backbone.Collection collection
		@show new UserProductListView
							collection : productcollection
		
	
	

