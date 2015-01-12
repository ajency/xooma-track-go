class App.HomeCtrl extends Ajency.RegionController

	initialize:->
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

		doughnutData = @drawBottle(target,consumed,bonusArr)
		
		
		ctx = document.getElementById("chart-area").getContext("2d")
		window.myDoughnut = new Chart(ctx).Doughnut(doughnutData, 
			responsive : true,  
			percentageInnerCutout : 80 
		)
		ctdx = document.getElementById("canvas").getContext("2d")
		window.myLine = new Chart(ctdx).Line(lineChartData, 
			responsive: true
		)

		@ui.liquid.each (e)->
			$(e.target)
				.data("origHeight", $(e.target).height())
				.height(0)
				.animate(
						height: $(this).data("origHeight")
					, 3000)

	drawBottle:(target,consumed,bonusArr)->
		grey = parseInt(target) - parseInt(consumed)
		i = 1 
		doughnutData = []
		while i < parseInt(consumed)
			doughnutData.push 
				value: 50
				color:"#6bbfff "
				highlight: "#50abf1"
				label: "Bottle"+i
			i++

		while i <= parseInt(grey)
			doughnutData.push 
				value: 50
				color:"#e3e3e3"
				highlight: "#cdcdcd"
				label: "Bottle"+i
			i++

		while i <= bonusArr
			doughnutData.push 
				value: 50
				color:"#e3e3e3"
				highlight: "#cdcdcd"
				label: "Bottle"+i
			i++
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
						<li><a href="#">History</a></li>
						
						
					  </ul>
			  </h5>

			  <ul class="list-inline text-center row dotted-line m-t-20 userProductList">
			  	<li class="col-md-4  col-xs-4"> 
							<a href="/products/{{id}}/consume"><img src="assets/images/btn_03.png" width="100px"></a>
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
			shecule.push
				qty : val.qty
				occ : occurrenceArr[ind]
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
		App.currentUser.getHomeProducts().done(@_showView).fail @errorHandler

	_showView:(collection)=>
		productcollection = new Backbone.Collection collection
		productcollection.shift() 
		@show new HomeOtherProductsView
					collection : productcollection
		


	
			
		








	
