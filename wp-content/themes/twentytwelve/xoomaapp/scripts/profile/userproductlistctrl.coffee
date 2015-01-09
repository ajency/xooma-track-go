class ProductChildView extends Marionette.ItemView

	tagName : 'div'

	className : 'list-title'

	ui :
		avail 	: '.avail'
		add		: '.add'
		update 	: '.update'

	template  : '
                <h5 class="bold text-primary">{{name}}</h5>
                <h6>{{servings}} times a day <b> {{product_type}} </b></h6><br/>
                <div class="avail hidden"><span>Available with me </span>{{available}}</div>
                <div><a href="#/products/{{id}}/edit" class="btn btn-primary btn-lg center-block add hidden" >Edit</a>
                <a href="#/inventory/{{id}}/edit" class="btn btn-primary btn-lg center-block update hidden" >Update</a>	
                 </div>'                             

	onShow:->
		product = parseInt @model.get('id')
		products = App.currentUser.get 'products'
		if $.inArray( product, products ) > -1
			@ui.avail.removeClass 'hidden'
			@ui.add.removeClass 'hidden'
			@ui.update.removeClass 'hidden'
		
			

class UserProductChildView extends Marionette.CompositeView
	tagName : 'li'
	className : 'productlist'
	template : '<b class="text-success">{{type}}</b>'
	childView : ProductChildView
	
	initialize:->
		products = @model.get 'products'
		@collection = new Backbone.Collection products

class UserProductListView extends Marionette.CompositeView

	class : 'animated fadeIn'

	template : '#produts-template'

	childView : UserProductChildView

	emptyView : UserProductChildView

	childViewContainer : 'ul.userProductList'

	ui :
		saveProducts : '.save_products'
		responseMessage : '.aj-response-message'

	events : 
		'click @ui.saveProducts':(e)->
			$.ajax
				method : 'POST'
				url : "#{APIURL}/records/#{App.currentUser.get('ID')}"
				success: @_successHandler

	onShow:->
		if App.currentUser.get('state') == '/home'
			@ui.saveProducts.hide()

	_successHandler:(response, status, xhr)=>
		if xhr.status == 201
			console.log response
			App.navigate '#/home' , true
		else
			@ui.responseMessage.text "Something went wrong"




	
	
	
		
class App.UserProductListCtrl extends Ajency.RegionController

	initialize:->
		App.currentUser.getUserProducts().done(@_showView).fail @errorHandler


	_showView:(collection)=>
		App.UserProductsColl = new Backbone.Collection collection
		productcollection = new Backbone.Collection collection
		@show new UserProductListView
							collection : productcollection
		


	

