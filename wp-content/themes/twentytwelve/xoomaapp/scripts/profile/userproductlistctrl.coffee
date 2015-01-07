class ProductChildView extends Marionette.ItemView

	tagName : 'div'

	className : 'list-title'

	template  : '<a href="#/products/{{id}}/edit">
                <h5 class="bold text-primary">{{name}}</h5>
                <h6>{{servings}} times a day <b> {{qty}} {{product_type}} </b></h6></a>'
                                              

	

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
		productcollection = new Backbone.Collection collection
		@show new UserProductListView
							collection : productcollection
		


	

