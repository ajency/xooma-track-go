class HomeLayoutView extends Marionette.LayoutView

	template : '#home-template'

	behaviors :
		FormBehavior :
			behaviorClass : Ajency.FormBehavior

	ui :
		time_period  : '.time_period'
		start_date 	 : '#start_date'
		end_date 	 : '#end_date'
		generate 	 : 'input[name="generate"]'
		form 		: '#generate_graph'
		param 		: 'input[name="param"]'

	events:
		'change @ui.time_period':(e)->
			id = $(e.target).val()
			date =  moment().subtract(id, 'days')
			previous = date.format('YYYY-MM-DD')
			today = moment().format('YYYY-MM-DD')
			picker = @ui.start_date.pickadate('picker')
			picker.set('select', previous, { format: 'yyyy-mm-dd' })
			
			if id == 'all'
				reg_date = App.graph.get 'reg_date'
				picker = @ui.start_date.pickadate('picker')
				picker.set('select', reg_date, { format: 'yyyy-mm-dd' })
			picker1 = @ui.end_date.pickadate('picker')
			picker1.set('select', today, { format: 'yyyy-mm-dd' })

	onFormSubmit: (_formData)=>
		$.ajax
			method : 'GET'
			data : _formData
			url : "#{APIURL}/graphs/#{App.currentUser.get('ID')}"
			success: @_successHandler

	_successHandler: (response, status,xhr)=>
		dates = _.has(response, "dates")
		if dates == true && xhr.status == 200
			App.graph.set 'dates' , response.dates
			App.graph.set 'param' , response.param
			@generateGraph()

		else if dates == false && xhr.status == 200
			@generateBMIGraph(response)

		


	onShow:->
		@ui.start_date.pickadate(
			formatSubmit: 'yyyy-mm-dd'
			hiddenName: true
			)
		@ui.end_date.pickadate(
			formatSubmit: 'yyyy-mm-dd'
			hiddenName: true
			)

	generateBMIGraph:(response)->
		dates = [response['st_date'],response['et_date']]

		bmi_start_ht = parseFloat(response['st_height']) *  12
		bmi_end_ht = parseFloat(response['et_height']) *  12
		st_square = parseFloat(bmi_start_ht) * parseFloat(bmi_start_ht)
		et_square = parseFloat(bmi_end_ht) * parseFloat(bmi_end_ht)
		bmi_start = (parseFloat(response['st_weight'])/parseFloat(st_square))* 703
		bmi_end = (parseFloat(response['et_weight'])/parseFloat(et_square))* 703
		lineChartData = 
			labels : dates,
			datasets : [
				
					label: "My Second dataset",
					fillColor : "rgba(151,187,205,0.2)",
					strokeColor : "rgba(151,187,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(151,187,205,1)",
					data : [bmi_start,bmi_end]
				
				
			]

		ctdx = document.getElementById("canvas").getContext("2d");
		window.myLine = new Chart(ctdx).Line(lineChartData, 
			responsive: true
		);

	generateGraph:->
		dates = App.graph.get 'dates'
		param = App.graph.get 'param'
		lineChartData = 
			labels : dates,
			datasets : [
			
				
					label: "My Second dataset",
					fillColor : "rgba(151,187,205,0.2)",
					strokeColor : "rgba(151,187,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(151,187,205,1)",
					data : param
				
			]

		ctdx = document.getElementById("canvas").getContext("2d");
		window.myLine = new Chart(ctdx).Line(lineChartData, 
			responsive: true
		);

		




class App.HomeCtrl extends Ajency.RegionController

	initialize:->
		App.currentUser.getHomeProducts().done(@_showView).fail @errorHandler

	_showView:(collection)=>
		@show new HomeLayoutView

class HomeX2OViewChild extends Marionette.ItemView

	template : '<a href="#/products/{{id}}/bmi" ><li class="col-md-4 col-xs-4"> 
					<h5 class="text-center">Bonus</h5>
					<h4 class="text-center bold  text-primary" >{{bonus}}</h4>
				</li>
				<li class="col-md-4 col-xs-4">
					<h5 class="text-center">Daily Target</h5>
						<h4 class="text-center bold text-primary margin-none" >{{remianing}}<sup class="text-muted">/ {{qty}}</sup></h4>
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
		data.remianing = parseInt(@model.get('qty').length) - parseInt(occurrenceArr.length)
		data.qty = @model.get('qty').length
		data

	onShow:->
		HomeLayoutView::generateGraph()
		occurrenceArr = []
		bonusArr = 0
		$.each @model.get('occurrence'), (ind,val)->
			occurrence = _.has(val, "occurrence")
			expected = _.has(val, "expected")
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
		console.log data
		console.log occurrence = _.has(data, "occurrence")
		console.log expected = _.has(data, "expected")
		console.log meta_value = _.has(data, "meta_value")
		value = 0
		arr = []
		$.each meta_value , (index,value)->
			value += parseInt value.qty
		
		if occurrence == true && expected == true
			arr['color'] = "#6bbfff"
			arr['highlight'] =  "#50abf1"
			arr['value'] = value
			
		else if occurrence == false && expected == true
			arr['color'] = "#e3e3e3"
			arr['highlight'] =  "#cdcdcd"
			arr['value'] = value
		else if occurrence == true && expected == false
			arr['color'] = "#e3e3e3"
			arr['highlight'] =  "#cdcdcd"
			arr['value'] = value

		arr


	drawBottle:(data)->
		doughnutData = []
		$.each data, (ind,val)->
			occurrence = HomeX2OViewChild::get_occurrence(val)
			i = parseInt(ind) + 1
			if occurrence['value'] == 0
				occurrence['value'] = 1
			doughnutData.push 
					value: occurrence['value']
					color:occurrence['color']
					highlight:occurrence['highlight']
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
		modelColl = new Backbone.Collection model
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



# class HomeViewChildView extends Marionette.CompositeView

# 	template : '<div></div>'

# 	childView : ProductChildView

	

# 	initialize:->
# 		products = @model.get 'products'
# 		@collection = new Backbone.Collection products


class HomeOtherProductsView extends Marionette.CompositeView

	
	  
	template : '<span></span>'    

	childView : ProductChildView

	

class App.HomeOtherProductsCtrl extends Ajency.RegionController

	initialize:->
		console.log App.useProductColl
		@_showView(App.useProductColl)

	_showView:(collection)=>
		productcollection = collection.clone()
		productcollection.shift() 
		@show new HomeOtherProductsView
					collection : productcollection
		


	
			
		








	
