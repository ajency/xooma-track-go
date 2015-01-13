class App.HomeCtrl extends Ajency.RegionController

	initialize:->
		App.currentUser.getHomeProducts().done(@_showView).fail @errorHandler

	_showView:(collection)=>
		@show new Marionette.LayoutView template : '#home-template'

class HomeX2OViewChild extends Marionette.ItemView

	template : '<a href="#/products/{{id}}/bmi" ><li class="col-md-4 col-xs-4"> 
					<h5 class="text-center">Bonus</h5>
					<h4 class="text-center bold  text-primary" >{{bonus}}</h4>
				</li>
				<li class="col-md-4 col-xs-4">
					<h5 class="text-center">Daily Target</h5>
						<h4 class="text-center bold text-primary margin-none" >{{remianing}}<sup class="text-muted">/ {{qty1}}</sup></h4>
				</li>
				<li class="col-md-4 col-xs-4">
					<h5 class="text-center">Last Consume</h5>
					<h4 class="text-center bold text-primary" >{{time}}</small></h4>       
				</li></a>'

	serializeData:->
		data = super()
		occurrenceArr = []
		bonusArr = 0
		recent = '--'
		data.time = recent
		data.bonus = 0
				
		$.each @model.get('occurrence'), (ind,val)->
			occurrence = _.has(val, "occurrence");
			expected = _.has(val, "expected");
			if occurrence == true
				date = val.occurrence
				occurrenceArr.push date
				
				
			if occurrence == true && expected == false
				bonusArr++
			
			if occurrenceArr.length != 0 
				recent = _.last occurrenceArr
				data.time = moment(recent).format("ddd, hA")
			data.bonus = bonusArr
			data.occurr = occurrenceArr.length
		data.remianing = parseInt(@model.get('qty1')) - parseInt(occurrenceArr.length)
		data

	onShow:->
		occurrenceArr = []
		bonusArr = 0
		$.each @model.get('occurrence'), (ind,val)->
			occurrence = _.has(val, "occurrence")
			if occurrence == true
				date = val.occurrence
				occurrenceArr.push date
			if occurrence == true && expected == false
				bonusArr++
		consumed = occurrenceArr.length
		target = @model.get 'qty1'

		doughnutData = @drawBottle(@model.get('occurrence'))
		
		
		ctx = document.getElementById("chart-area").getContext("2d")
		window.myDoughnut = new Chart(ctx).Doughnut(doughnutData, 
			responsive : true,  
			percentageInnerCutout : 80 
		)
		
	get_occurrence:(data)->
		occurrence = _.has(data, "occurrence")
		expected = _.has(data, "expected")
		meta_value = _.has(data, "meta_value")
		value = 0
		$.each meta_value , (index,value)->
			value += parseInt value.qty
		
		if occurrence == true && expected == true
			color = "#6bbfff"
			highlight =  "#50abf1"
			value = value
			
		else if occurrence == false && expected == true
			color = "#e3e3e3"
			highlight =  "#cdcdcd"
			value = value
		else if occurrence == true && expected == false
			color = "#e3e3e3"
			highlight =  "#cdcdcd"
			value = value


	drawBottle:(data)->
		doughnutData = []
		$.each data, (ind,val)->
			@get_occurrence(val)
		
			doughnutData.push 
					value: 50
					color:"#6bbfff "
					highlight: "#50abf1"
					label: "Bottle"+i
				
		doughnutData

	


class HomeX2OView extends Marionette.CompositeView

	template : '<ul class="list-inline text-center row row-line x2oList">
			  </ul>'

	childView : HomeX2OViewChild

	ui : 
		chartArea   : '#chart-area'
		liquid		: '.liquid'

	childViewContainer : 'ul.x2oList'



	

class App.HomeX2OCtrl extends Ajency.RegionController

	initialize:->
		console.log App.useProductColl
		@_showView(App.useProductColl)

	_showView:(collection)=>
		productcollection = collection.clone()
		model = productcollection.shift() 
		console.log App.useProductColl
		modelColl = new Backbone.Collection model.get('products')
		@show new HomeX2OView
					collection : modelColl

class ProductChildView extends Marionette.ItemView

	className : 'panel panel-default'

	template  : '<div class="panel-body">
			<h5 class="bold margin-none mid-title ">{{name}}<i type="button" class="fa fa-ellipsis-v pull-right dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i>
					 <ul class="dropdown-menu pull-right" role="menu">
						<li><a href="#">View</a></li>
						<li><a href="#">History</a></li>
						
						
					  </ul>
			  </h5>

			  <ul class="list-inline text-center row dotted-line m-t-20 userProductList">
			  	<li class="col-md-4  col-xs-4"> 
							<a href="#/products/{{id}}/consume"><img src="assets/images/btn_03.png" width="100px"></a>
							<h6 class="text-center margin-none">Tap to consume</h6>
						</li>
						<li class="col-md-4  col-xs-4">
							<h5 class="text-center">Daily Target</h5>
								<div class="row">
									{{#shecule}}
									<div class="col-md-6  col-xs-6">
										 <h4 class="text-center bold text-primary margin-none" >{{occ}}<sup class="text-muted">/ {{qty}}</sup></h4>
										<h6 class="anytime">{{whendata}}</h6>
									</div>
									  {{/shecule}}
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

	ui :
		anytime     : '.anytime'


	serializeData:->
		data = super()
		recent = '--'
		data.occur = 0
		data.time = recent
		data.bonus = 0
		occurrenceArr = []
		bonusArr = 0
			
		$.each @model.get('occurrence'), (ind,val)->
			occurrence = _.has(val, "occurrence");
			expected = _.has(val, "expected");
			if occurrence == true && expected == true
				date = val.occurrence
				occurrenceArr.push date
				
				
			if occurrence == true && expected == false
				bonusArr++
			
			if occurrenceArr.length != 0 
				recent = _.last occurrenceArr
				data.time = moment(recent).format("ddd, hA")
				data.occur =  occurrenceArr.length

			data.bonus = bonusArr
			data.occurrArr = occurrenceArr
		shecule = []
		whenar = ['','Morning Before meal' , 'Morning After meal', 'Night Before Meal' , 'Night After Meal']
		$.each @model.get('qty'), (ind,val)->
			console.log occurrenceArr[ind]
			occu_data = occurrenceArr.length
			if occurrenceArr[ind] == "" || occurrenceArr[ind] == undefined
				occu_data = 0
			shecule.push
				qty : val.qty
				occ : occu_data
				whendata : whenar[val.when]

		data.shecule = shecule
		data

	onShow:->
		if @model.get('type') == 'Anytime'
			@ui.anytime.hide()



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
		console.log App.useProductColl
		@_showView(App.useProductColl)

	_showView:(collection)=>
		productcollection = collection.clone()
		productcollection.shift() 
		App.homexProductsColl = new Backbone.Collection
		App.homexProductsColl = productcollection
		@show new HomeOtherProductsView
					collection : productcollection
		


	
			
		








	
