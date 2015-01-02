class App.HomeCtrl extends Ajency.RegionController

	initialize:->
		@show new Marionette.LayoutView template : '#home-template'

class HomeX2OViewChild extends Marionette.ItemView

	template : '<li class="col-md-4 col-xs-4"> 
					<h5 class="text-center">Bonus</h5>
					<h4 class="text-center bold  text-primary" >{{bonus}}<small class="text-muted">({{name}})</small></h4>
				</li>
				 <li class="col-md-4 col-xs-4">
					<h5 class="text-center">Target</h5>
					<h4 class="text-center bold text-primary" >{{qty1}}<small class="text-muted">({{name}})</small></h4>
				</li>
				<li class="col-md-4 col-xs-4">
					<h5 class="text-center">Last Consume</h5>
					<h4 class="text-center bold text-primary" >{{time}}</small></h4>       
				</li>'

	serializeData:->
		data = super()
		$.each @model.get('occurrence'), (ind,val)->
			occurrence = _.has(val, "occurrence");
			expected = _.has(val, "expected");
			recent = '--'
			data.time = recent
			data.bonus = 0
			occurrenceArr = []
			bonusArr = 0
			if occurrence == true
				date = val.expected
				occurrenceArr.push date
				
				
			if occurrence == true && expected == false
				bonusArr++
			
			if occurrenceArr.length != 0 
				recent = _.last occurrenceArr
				data.time = moment(recent).format("ddd, hA")
			data.bonus = bonusArr
			
		data



class HomeX2OView extends Marionette.CompositeView

	template : '<ul class="list-inline text-center row row-line x2oList">
			  </ul>'

	childView : HomeX2OViewChild

	childViewContainer : 'ul.x2oList'

	

class App.HomeX2OCtrl extends Ajency.RegionController

	initialize:->
		if App.currentUser.has 'x2o'
			console.log x2oColl = new Backbone.Collection App.currentUser.get 'x2o'
			@show new HomeX2OView
						collection : x2oColl
		else
			App.currentUser.getHomeProducts().done(@_showView).fail @errorHandler

	_showView:(collection)=>
		productcollection = new Backbone.Collection collection
		model = productcollection.shift() 
		modelColl = new Backbone.Collection model.get('products')
		@show new HomeX2OView
					collection : modelColl

class ProductChildView extends Marionette.ItemView

	className : 'panel panel-default'

	template  : '<div class="panel-body">
			<h5 class="bold margin-none mid-title ">{{name}}<i type="button" class="fa fa-ellipsis-v pull-right dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i>
					 <ul class="dropdown-menu pull-right" role="menu">
						<li><a href="#">View</a></li>
						<li><a href="#">Another action</a></li>
						<li><a href="#">Something else here</a></li>
						<li class="divider"></li>
						<li><a href="#">Delete</a></li>
					  </ul>
			  </h5>

			  <ul class="list-inline text-center row dotted-line m-t-20 userProductList">
			  	<li class="col-md-4  col-xs-4"> 
							<a ><img src="assets/images/btn_03.png" width="100px"></a>
							<h6 class="text-center margin-none">Tap to consume</h6>
						</li>
						<li class="col-md-4  col-xs-4">
							<h5 class="text-center">Daily Target</h5>
								<div class="row">
									{{#qty}}
									<div class="col-md-6  col-xs-6">
										 <h4 class="text-center bold text-primary margin-none" >5 <sup class="text-muted">/ {{qty}}</sup></h4>
										<h6 >{{when}}</h6>
									</div>
									  {{/qty}}
								</div>
						</li>
						<li class="col-md-4  col-xs-4">
							<h5 class="text-center">Status</h5>
								<i class="fa fa-smile-o"></i>  
							<h6 class="text-center margin-none">Complete the last one</h6>
						</li>
				</ul>
			  </div>
		 

				   </br> '


	serializeData:->
		data = super()
		$.each @model.get('occurrence'), (ind,val)->
			occurrence = _.has(val, "occurrence");
			expected = _.has(val, "expected");
			recent = '--'
			data.occur = 0
			data.time = recent
			data.bonus = 0
			occurrenceArr = []
			bonusArr = 0
			if occurrence == true
				date = val.expected
				occurrenceArr.push date
				
				
			if occurrence == true && expected == false
				bonusArr++
			
			if occurrenceArr.length != 0 
				recent = _.last occurrenceArr
				data.time = moment(recent).format("ddd, hA")
				data.occur =  occurrenceArr.length
			data.bonus = bonusArr
			
		data


class HomeViewChildView extends Marionette.CompositeView

	template : '<div></div>'

	childView : ProductChildView

	

	initialize:->
		products = @model.get 'products'
		@collection = new Backbone.Collection products


class HomeOtherProductsView extends Marionette.CompositeView

	
	  
	template : '<span></span>'    

	childView : HomeViewChildView

	

class App.HomeOtherProductsCtrl extends Ajency.RegionController

	initialize:->
		App.currentUser.getHomeProducts().done(@_showView).fail @errorHandler

	_showView:(collection)=>
		productcollection = new Backbone.Collection collection
		productcollection.shift() 
		@show new HomeOtherProductsView
					collection : productcollection
		


	
			
		








	
