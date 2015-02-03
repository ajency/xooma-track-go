App.state 'home',
				url : '/home'
				parent : 'xooma'
				sections : 
					'x2o' : 
						ctrl : 'HomeX2OCtrl'
					'other-products' : 
						ctrl : 'HomeOtherProductsCtrl'

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
		history 	: '.history'
		update 	: '.update'
		responseMessage : '.aj-response-message'
		param 			: '#param'

	events:
		'change @ui.param':(e)->
			if $(e.target).val() == 'bmi'
				@ui.time_period.hide()
			else 
				@ui.time_period.show()

		'click @ui.history':(e)->
			e.preventDefault()
			App.navigate '#/measurements/'+App.currentUser.get('ID')+'/history' , true

		'click @ui.update':(e)->
			e.preventDefault()
			App.navigate '#/profile/measurements' , true

		'change @ui.time_period':(e)->
			id = $(e.target).val()
			date =  moment().subtract(id, 'days')
			previous = date.format('YYYY-MM-DD')
			today = moment().format('YYYY-MM-DD')
			@ui.start_date.val previous
			
			
			if id == 'all'
				reg_date = App.graph.get 'reg_date'
				@ui.start_date.val reg_date
			@ui.end_date.val today
			

	onFormSubmit: (_formData)=>
		$.ajax
			method : 'GET'
			data : _formData
			url : "#{APIURL}/graphs/#{App.currentUser.get('ID')}"
			success: @_successHandler
			error: @_errorHandler

	_successHandler: (response, status,xhr)=>
		dates = _.has(response, "dates")
		if dates == true && xhr.status == 200
			App.graph.set 'dates' , response.dates
			App.graph.set 'param' , response.param
			@generateGraph()

		else if dates == false && xhr.status == 200
			@generateBMIGraph(response)
		else
			@showErrorMsg()

	_errorHandler: (response, status,xhr)=>
		@showErrorMsg()

	showErrorMsg:->
		@ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be loaded!")
		$('html, body').animate({
							scrollTop: 0
							}, 'slow')
		


	onShow:->
		App.trigger 'cordova:hide:splash:screen'
		if parseInt(App.useProductColl.length) == 0
			@ui.responseMessage.addClass('alert alert-danger').text("No products added by the user!")
			$('html, body').animate({
								scrollTop: 0
								}, 'slow')

		@generateGraph()
		# @ui.start_date.pickadate(
		# 	formatSubmit: 'yyyy-mm-dd'
		# 	hiddenName: true
		# 	)
		# @ui.end_date.pickadate(
		# 	formatSubmit: 'yyyy-mm-dd'
		# 	hiddenName: true
		# 	)

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
		console.log state = App.currentUser.get 'state'
		if App.useProductColl.length == 0 && state == '/home'
			App.currentUser.getHomeProducts().done(@_showView).fail(@errorHandler)
		else
			if state != '/home'
				new workflow
			else


				@show new HomeLayoutView

	_showView:(collection)=>
		@show @parent().getLLoadingView()
		response = collection.response
		App.useProductColl.reset response
		
		state = App.currentUser.get 'state'
		@show new HomeLayoutView

	errorHandler:=>
		$('.aj-response-message').addClass('alert alert-danger').text("Data couldn't be loaded!")
		$('html, body').animate({
							scrollTop: 0
							}, 'slow')

class HomeX2OView extends Marionette.ItemView

	template : '<div class="row">
			<div class="col-md-4 col-xs-4"></div>
			<div class="col-md-4 col-xs-4"> <h4 class="text-center">TODAY </h4></div>
			<div class="col-md-4 col-xs-4"> <h5 class="text-center">HISTORY <i class="fa fa-angle-right"></i></h5> </div>
		</div>
		<div class="panel panel-default">
			<div class="panel-body">
				<h5 class="margin-none mid-title ">{{name}}<i type="button" class="fa fa-ellipsis-v pull-right dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i>
					 <ul class="dropdown-menu pull-right" role="menu">
						<li><a href="#/product/{{id}}/history">Consumption History</a></li>
						
						
					  </ul>
			  </h5>
		<div class="row">
			<div class="col-md-12">
				  <div class="fill-bottle">        
					<div class="glass">
							<span class="liquid" style="height: 100%"></span>
					 </div>
				  </div>
					<div id="canvas-holder">
						<canvas id="chart-area" width="500" height="500"/>
					</div>
			
			</div>
		</div><ul class="list-inline text-center row row-line x2oList">
			 <a href="#/products/{{id}}/bmi" ><li class="col-md-4 col-xs-4"> 
					<h5 class="text-center">Daily Target</h5>
					<h4 class="text-center bold  text-primary" >{{qty}}</h4>
				</li>
				<li class="col-md-4 col-xs-4">
					<h5 class="text-center">Consumed</h5>
						<h4 class="text-center bold text-primary margin-none" >{{remianing}}</h4>
				</li>
				<li class="col-md-4 col-xs-4">
					<h5 class="text-center">Last consumed at</h5>
					<h4 class="text-center bold text-primary" >{{time}}</small></h4>       
				</li></a> </ul></div></div>'
	ui :
		liquid : '.liquid'

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
			if occurrence == true && expected == true
				date = val.occurrence
				occurrenceArr.push date
				
				
			if occurrence == true && expected == false
				bonusArr++
			
			if occurrenceArr.length != 0 
				recent = _.last occurrenceArr
				data.time = moment(recent).format("ddd, hA")
			data.bonus = bonusArr
			data.occurr = occurrenceArr.length
		data.remianing = occurrenceArr.length
		data.qty = @model.get('qty').length
		data

	onShow:->
		occurrenceArr = []
		bonusArr = 0
		$.each @model.get('occurrence'), (ind,val)->
			occurrence = _.has(val, "occurrence")
			expected = _.has(val, "expected")
			if occurrence == true && expected == true
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
			animateRotate : false
		)
		@ui.liquid.each (e)->
			$(e.target)
				.data("origHeight", $(e.target).height())
				.height(0)
				.animate(
						height: $(this).data("origHeight")
					, 3000)


	getCount:(val)->
		count = 0
		if!(_.isArray(val)) 
			count += parseFloat val.qty
		else
			$.each val , (ind,val1)->
				if!(_.isArray(val1)) 
					count += parseFloat val1.qty
				else
					$.each val1 , (ind,val2)->
						if _.isArray(val2)
							$.each val2 ,  (ind,value)->
								count += parseFloat value.qty
						else
							count += parseFloat val2.qty

		count	

	
		
		
	get_occurrence:(data)->
		occurrence = _.has(data, "occurrence")
		expected = _.has(data, "expected")
		meta_value = data.meta_value
		value = 0
		arr = []
		qty = 0
		qty = HomeX2OView::getCount(data.meta_value)
		
		if occurrence == true && expected == true
			arr['color'] = "#6bbfff"
			arr['highlight'] =  "#50abf1"
			arr['value'] = parseInt(qty) * 100
			arr['label'] = "Consumed at"
			
		else if occurrence == false && expected == true
			arr['color'] = "#e3e3e3"
			arr['highlight'] =  "#cdcdcd"
			arr['value'] = parseInt(qty) * 100
			arr['label'] = qty
		else if occurrence == true && expected == false
			arr['color'] = "#ffaa06"
			arr['highlight'] =  "#cdcdcd"
			arr['value'] = parseInt(qty) * 100
			arr['label'] = qty

		arr


	drawBottle:(data)->
		doughnutData = []
		$.each data, (ind,val)->
			occurrence = HomeX2OView::get_occurrence(val)
			i = parseInt(ind) + 1
			if occurrence['value'] == 0
				occurrence['value'] = 1
			doughnutData.push 
					value: occurrence['value']
					color:occurrence['color']
					highlight:occurrence['highlight']
					label: "Bottle "+i
				
		doughnutData

	






	

class App.HomeX2OCtrl extends Ajency.RegionController

	initialize:->
		@_showView(App.useProductColl)

	_showView:(collection)=>
		productcollection = collection.clone()
		model = productcollection.findWhere({name:'X2O'}) 
		if model != undefined
			if model.get('name').toUpperCase() == 'X2O'
				modelColl = model
				@show new HomeX2OView
							model : modelColl

class ProductChildView extends Marionette.ItemView

	className : 'panel panel-default'

	template  : '<div class="panel-body">
			<h5 class="margin-none mid-title ">{{name}}<span>( {{serving_size}}  Serving/ Day )</span><i type="button" class="fa fa-ellipsis-v pull-right dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i>
					 <ul class="dropdown-menu pull-right" role="menu">
						<li><a href="#/product/{{id}}/history">Consumption History</a></li>
						
						
					  </ul>
			  </h5>
			  <input type="hidden" name="qty{{id}}"  id="qty{{id}}" value="" />
							<input type="hidden" name="meta_id{{id}}"  id="meta_id{{id}}" value="" />
					

			  <ul class="list-inline dotted-line  text-center row m-t-20">
								  <li class="col-md-8 col-xs-8"> 
							 <ul class="list-inline no-dotted">
							 					{{#no_servings}}
					
				 
									  
										{{{servings}}}
										
										
									 
									  
										
				
					{{/no_servings}}
					

				  

					
 
</ul>                          
								  </li>
								   
									<li class="col-md-4 col-xs-4">
										<h5 class="text-center">Status</h5>
											<i class="fa fa-smile-o"></i>  
										<h6 class="text-center margin-none">Complete the last one</h6>
									</li>
								</ul>
			  
			  </div>
		 

				   </br> '

	ui :
		anytime     : '.anytime'

	

	saveHandler:(response,status,xhr)=>
		@model.set 'occurrence' , response.occurrence
		#App.useProductColl.set @model
		productcollection = App.useProductColl.clone()
		model = productcollection.findWhere({name:'X2O'})  
		if model != undefined
			if model.get('name').toUpperCase() == 'X2O' 
				productcollection.remove model
				productcollection.reset productcollection.toArray()
		home = new HomeOtherProductsView
					collection : productcollection
		region =  new Marionette.Region el : '#otherproducts'
		region.show home
		#$('#otherproducts').html(home.render().el)
		


	serializeData:->
		data = super()
		recent = '--'
		data.occur = 0
		data.time = recent
		data.bonus = 0
		occurrenceArr = []
		no_servings  = []
		bonusArr = 0
		qty = @model.get 'qty'	
		product_type = @model.get('product_type')
		product_type = product_type.toLowerCase()
		temp = []
		$.each @model.get('occurrence') , (ind,val)->
			if qty[ind] != undefined
				temp.push val
		reponse = ""
		count = 0
		model = @model
		$.each temp , (ind,val)->
			occurrence = _.has(val, "occurrence")
			expected = _.has(val, "expected")
			if occurrence == true && expected == true
				reponse = ProductChildView::occurredfunc(val,ind,model)
				
				
			else if occurrence == false && expected == true 
				reponse = ProductChildView::expectedfunc(val,ind,count,model)
				count++
				
			response = reponse[0]
			no_servings.push servings : response.html , schedule : response.schedule_id , meta_id : response.meta_id ,qty :response.qty
			data.no_servings =  no_servings
			data.serving_size = temp.length
		data

	expectedfunc:(val,key,count,model)->
		console.log model
		temp = []
		i = 0
		html = ""
		product_type = model.get 'product_type'
		product_type = product_type.toLowerCase()
		qty = model.get 'qty'
		reminders = model.get 'reminder'
		classname = "hidden"
		time = ""
		tempcnt = 0
		increment = parseInt(key) + 1
		product = model.get('id')
		date = moment().format('YYYY-MM-DD')
		whenarr = [0 , 'Morning Before meal' , 'Morning After meal' ,'Night Before meal' ,'Night After meal' ]
		
		if model.get('type') == "Anytime"
			serving_text = 'Serving '+increment
		else
			serving_text = whenarr[qty[key].when]

		if parseInt(reminders.length) != 0
			classname = ''
			time = reminders[key].time
			serving_text = time

		newClass = product_type+'_expected_class'
		if parseInt(count) == 0
			html += '<li><a href="#/products/'+product+'/consume/'+date+'" id="original"><img src="'+_SITEURL+'/wp-content/themes/twentytwelve/xoomaapp/images/btn_03.png" width="70px"></a>
					<h6 class="text-center margin-none">Tap to take </h6>
					<h6 class="text-center text-primary '+classname+'">'+time+'</h6></li>'
		else
			html += '<li><a >
                  <h3 class="bold"><div class="cap '+newClass+'"></div>'+qty[key].qty+'</h3>
               </a>'
			html +=	'<i class="fa fa-clock-o center-block status"></i>
                     <h6 class="text-center text-primary">'+serving_text+'</h6></li>'
		qty  = qty[key].qty
		$('#qty'+model.get('id')).val qty
		
		schedule_id = val.schedule_id
		meta_id = 0
		temp.push html : html , schedule_id : schedule_id ,qty : qty , meta_id :meta_id
		temp
	
	occurredfunc:(val,key,model)->
		console.log val
		temp = []
		i = 0
		timezone = App.currentUser.get 'timezone'
		time = moment(val.occurrence+timezone, "HH:mm Z").format("h:ss A")
		product_type = model.get 'product_type'
		product_type = product_type.toLowerCase() 
		qty = val.meta_value.qty
		html = ""
		newClass = product_type+'_occurred_class'
		html += '<li><a ><h3 class="bold"><div class="cap '+newClass+'"></div>'+qty+'</h3></a>'
		html +=	'<i class="fa fa-check center-block status"></i><h6 class="text-center text-primary">'+time+'</h6></li>'
		console.log qty  = val.meta_value.qty
		schedule_id = val.schedule_id
		meta_id = val.meta_id
		temp.push html : html , schedule_id : schedule_id ,qty : qty , meta_id :meta_id
		temp


	



		




class HomeOtherProductsView extends Marionette.CompositeView

	
	  
	template : '<span></span>'    

	childView : ProductChildView

	

class App.HomeOtherProductsCtrl extends Ajency.RegionController

	initialize:->

		@_showView(App.useProductColl)

	_showView:(collection)=>
		productcollection = collection.clone()
		model = productcollection.findWhere({name:'X2O'})  
		if model != undefined
			if model.get('name').toUpperCase() == 'X2O' 
				productcollection.remove model
				productcollection.reset productcollection.toArray()
		@show new HomeOtherProductsView
					collection : productcollection
		


	
			
		








	
