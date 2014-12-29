class ProductChildView extends Marionette.ItemView

	tagName : 'div'

	className : 'list-title'

	template  : '
                <h5 class="bold text-primary">{{name}}</h5>
                <h6>{{servings}} times a day <b> {{qty}} {{product_type}} </b></h6>'
                                              

	

class homeViewChildView extends Marionette.CompositeView
	tagName : 'li'
	className : 'productlist'
	template : '<b class="text-success">{{type}}</b>'
	childView : ProductChildView
	
	initialize:->
		products = @model.get 'products'
		@collection = new Backbone.Collection products

class homeView extends Marionette.CompositeView

	class : 'animated fadeIn'

	template : '#produts-template'

	childView : homeViewChildView

	childViewContainer : 'ul.userProductList'

class App.HomeCtrl extends Ajency.RegionController

	initialize:->
		App.currentUser.getUserProducts().done(@_showView).fail @errorHandler


	_showView:(collection)=>
		productcollection = new Backbone.Collection collection
		@show new homeView
					collection : productcollection
		