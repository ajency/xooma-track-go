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
            <h5 class=" mid-title margin-none"><div> {{name}}</div>
              <i type="button" class="fa fa-bars pull-right dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i>
                     <ul class="dropdown-menu pull-right" role="menu">
                        <li class="add hidden"><a href="#/product/{{id}}/edit">Edit product</a></li>
                        <li class="update hidden"><a href="#/inventory/{{id}}/edit">Inventory</a></li>
                        <li class="update hidden"><a href="#/inventory/{{id}}/view">Inventory history</a></li>
                        <li class="divider"></li>
                        <li class="remove hidden"><div>Remove</div></li>
                      </ul>
              </h5>
                      <ul class="list-inline  ">
                      	 <li class="col-md-6 col-xs-6 col-sm-6 dotted-line">
                      	 	<ul class="list-inline no-dotted responsive">
                        
                        	
                        	{{#servings}}
                        	<li>
                        	<h3 class="bold margin-none"><div class="cap {{classname}}"></div><span class="badge badge-primary">{{qty}}</span></h3>
                                
							 </li>
                        	{{/servings}}	
                          
                       
                        </ul>
                        <div class="end-bar"></div>
                        </li>
                        <li class="col-md-6 col-xs-6  col-sm-6 dotted">
                        	<div class="row">
                        		<div class="col-sm-5"> <img src="{{image}}" class="hidden-xs pull-left product-medium"/>
                        		 <h3 class="bold {{newClass}} {{hidden}} avail m-t-10">{{servingsleft}}</h3></div>
                        		<div class="col-sm-7"> <small> <span class="servings_text center-block">{{servings_text}}</span>
                          <i class="fa fa-frown-o {{frown}}"></i>
                         <span class="center-block {{hidden}}">{{containers}} container(s) ({{available}} {{product_type}}(s))</span> </small></div>
                        	</div>
                        
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
			window.removeMsg()
			@ui.responseMessage.addClass('alert alert-danger').text("Sorry!Couldn't delete the product.")
			$('html, body').animate({
							scrollTop: 0
							}, 'slow')
		

	erroraHandler:(response, status, xhr)=>
		window.removeMsg()
		@ui.responseMessage.addClass('alert alert-danger').text("Sorry!Couldn't delete the product.")
		$('html, body').animate({
							scrollTop: 0
							}, 'slow')
	

                            

	onShow:->
		App.trigger 'cordova:hide:splash:screen'
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

		$('.responsive').slick(
				dots: false,
				infinite: false,
				speed: 300,
				slidesToShow: 4,
				slidesToScroll: 4,
				responsive:
					breakpoint: 1024,
					settings: 
						slidesToShow: 3,
						slidesToScroll: 3,
						infinite: true,
						dots: false
					breakpoint: 600,
					settings: 
						slidesToShow: 2,
						slidesToScroll: 2
					breakpoint: 480,
					settings: 
						slidesToShow: 1,
						slidesToScroll: 1



				
			);


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
		totalqty = 0
		$.each qty , (index,value)->
			servingsqty = []
			newClass = product_type+'_default_class'
			if  name.toUpperCase() == 'X2O'
				newClass = 'x2o_default_class'
			totalqty += parseInt(value.qty)
			servings.push classname : newClass , qty : value.qty
		console.log reminder
		$.each reminder , (ind,val)->
			console.log val.time
			d = new Date(val.time)
			timestamp = d.getTime()
			time = moment(timestamp).zone(timezone).format("h:mm A")
			
			reminderArr.push time

		remind  = reminderArr.join(',')
		if parseInt(reminder.length) == 0 
			remind = 'No Reminder is set'
		available = @model.get 'available'
		
		total = @model.get 'total'
		containers = parseInt(available)/parseInt(total)
		contacount = Math.ceil containers
		servingsleft = Math.round(parseInt(available)*parseInt(qty.length)/parseInt(totalqty))
		totalservings  = parseInt(servingsleft) / 2
		data.servings_text = 'Servings left'
		data.hidden = ''
		data.frown = 'hidden'
		if parseInt(servingsleft) <= parseInt(settings) && parseInt(servingsleft) != 0
			data.newClass = 'text-danger'
		else if parseInt(servingsleft) == 0
			data.newClass = 'text-muted'
			data.servings_text =  'Servings out of stock'
			data.hidden = 'hidden'
			data.frown = 'hidden'
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

	template : '<div></div>'	

	ui :
		responseMessage : '.aj-response-message'


	onShow:->
		$('.save_products').hide()
		$('.aj-response-message').addClass('alert alert-danger').text("Please add your products")
		$('html, body').animate({
						scrollTop: 0
						}, 'slow')


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
			# @ui.saveProducts.hide()
			$('#product').parent().removeClass 'done'
			$('#product').parent().addClass 'selected'
			$('#product').parent().siblings().removeClass 'selected'
			$('#product').parent().prevAll().addClass 'done'
		
		if parseInt(App.useProductColl.length) == 0 || parseInt(App.useProductColl.length) < 10
				@ui.add1.hide()
				
			

	_successHandler:(response, status, xhr)=>
		console.log xhr.status
		if xhr.status == 201
			App.currentUser.set 'state' , '/home'
			App.navigate '#/home' , true
			listview = new XoomaAppRootView
			region =  new Marionette.Region el : '#xoomaapptemplate'
			region.show listview
		else
			window.removeMsg()
			@ui.responseMessage.addClass('alert alert-danger').text("Sorry!Some error occurred.")
			$('html, body').animate({
							scrollTop: 0
							}, 'slow')


	_errorHandler:(response, status, xhr)=>
		window.removeMsg()
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
		
	
	

