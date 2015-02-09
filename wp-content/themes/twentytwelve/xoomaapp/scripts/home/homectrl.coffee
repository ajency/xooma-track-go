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
			if $('.time_period').val() == '' || $('.time_period').val() == 'all'
				reg_date = App.graph.get 'reg_date'
				@ui.start_date.val reg_date
			else
				id = @ui.time_period.val()
				date =  moment().subtract(id, 'days')
				previous = date.format('YYYY-MM-DD')
				@ui.start_date.val previous
			today = moment().format('YYYY-MM-DD')
			@ui.end_date.val today
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

		'click #showHome':(e)->
			$('.loading').html 'Loading data<img src="'+_SITEURL+'/wp-content/themes/twentytwelve/xoomaapp/images/lodaing.GIF" width="70px">'
			App.currentUser.getHomeProducts().done(@_showView).fail(@errorHandler)

	_showView:(collection)=>
		$('.loading').html ""
		response = collection.response
		App.useProductColl.reset response
		productcollection = App.useProductColl.clone()
		model = productcollection.findWhere({name:'X2O'}) 

		if model != undefined
			if model.get('name').toUpperCase() == 'X2O'
				modelColl = model
				listview = new HomeX2OView
							model : modelColl

			
								
				region =  new Marionette.Region el : '#x2oregion'
				region.show listview

			
				productcollection.remove model
				productcollection.reset productcollection.toArray()
		listview1 = new HomeOtherProductsView
						collection : productcollection	

		region =  new Marionette.Region el : '#otherproducts'
		region.show listview1	

	onFormSubmit: (_formData)=>
		$('.loadinggraph').html 'Loading data<img src="'+_SITEURL+'/wp-content/themes/twentytwelve/xoomaapp/images/lodaing.GIF" width="70px">'
			
		$.ajax
			method : 'GET'
			data : _formData
			url : "#{APIURL}/graphs/#{App.currentUser.get('ID')}"
			success: @_successHandler
			error: @_errorHandler

	_successHandler: (response, status,xhr)=>
		dates = _.has(response, "dates")
		$('.loadinggraph').html ""
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
		window.removeMsg()
		@ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be loaded!")
		$('html, body').animate({
							scrollTop: 0
							}, 'slow')
		


	onShow:->
		App.trigger 'cordova:hide:splash:screen'

		$('#update').val moment().format('YYYY-MM-DD')
		if App.currentUser.get('homeDate') != undefined && App.currentUser.get('homeDate') != ""
		 	$('#update').val App.currentUser.get('homeDate')
		else
			date = moment().format('YYYY-MM-DD')
			App.currentUser.set 'homeDate' , date
			$('#update').val date
		reg_date = moment(App.currentUser.get('user_registered')).format('YYYY-MM-DD')
		$('#update').datepicker(
			    dateFormat : 'yy-mm-dd'
			    changeYear: true,
			    changeMonth: true,
			    maxDate: new Date()
			    minDate : new Date(reg_date)
			    onSelect: (dateText, inst)->
			    	App.currentUser.set 'homeDate' , dateText
			    	

		)

		$('.history').attr('href' ,'#/measurements/'+App.currentUser.get('ID')+'/history' )
		$('.update').attr('href' ,'#/profile/measurements' )	
		if parseInt(App.useProductColl.length) == 0
			window.removeMsg()
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
		if dates.length == 0 && param.length == 0
			$('.loadinggraph').html "<li>No data found</li>"
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
			@show new HomeLayoutView

	_showView:(collection)=>
		@show @parent().getLLoadingView()
		
		response = collection.response
		App.useProductColl.reset response
		
		state = App.currentUser.get 'state'
		@show new HomeLayoutView

	errorHandler:=>
		window.removeMsg()
		$('.aj-response-message').addClass('alert alert-danger').text("Data couldn't be loaded!")
		$('html, body').animate({
							scrollTop: 0
							}, 'slow')

class HomeX2OView extends Marionette.ItemView

	template : '<div class="row">
			<div class="col-md-4 col-xs-4"></div>
			
					</div>
		<div class="panel panel-default">
			<div class="panel-body">
				<h5 class="margin-none mid-title ">{{name}}<i type="button" class="fa fa-ellipsis-v pull-right dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i>
					 <ul class="dropdown-menu pull-right" role="menu">
						<li><a href="#/product/{{id}}/history">Consumption History</a></li>
						
						
					  </ul>
			  </h5>
		<div class="row">
			
				  <div class="fill-bottle"> 
				 <a id="original" href="#/products/{{id}}/bmi/{{dateval}}" > <h6 class="text-center"> Tap to Consume</h6>   
                        <img src="'+_SITEURL+'/wp-content/themes/twentytwelve/images/xooma-bottle.gif"/>
                             

                        <h6 class="text-center texmsg">{{texmsg}}</h6> </a>         
					
				  </div>
					 <div id="canvas-holder">
						<canvas id="chart-area" width="500" height="500"/>
					</div>
			
			</div>
		</div><h6 class="text-primary text-center"><i class="fa fa-clock-o "></i> Last consumed at {{time}}</h6

		</div></div>'
	ui :
		liquid : '.liquid'

	events:
		'click #original':(e)->
			console.log @model.get 'available'
			available = @model.get 'available'

			if parseInt(available) <= 0
				e.preventDefault()
				$('.aj-response-message').addClass('alert alert-danger').text("Product out of stock!")
				$('html, body').animate({
									scrollTop: 0
									}, 'slow')
				return false
			else
				return true

	serializeData:->
		data = super()
		per = [0,25,50,75,100]
		per1 = ['25_50','50_75']
		timearr = ["2AM-11AM","11AM-4PM","4PM-9PM","9PM-2AM"]
		
		temp = []
		texmsg = ""
		timeslot = ""
		time = ""
		timearray = []
		d = new Date()
		n = -(d.getTimezoneOffset())
		
		timezone = n
		if App.currentUser.get('timezone') != null
			timezone = App.currentUser.get('timezone')
		console.log tt = moment().format('YYYY-MM-DD HH:mm:ss')
		d = new Date()
		timestamp = d.getTime()
		
		timearray.push moment(timestamp).zone(timezone).format("x")
		occurrenceArr = []
		bonusArr = 0
		recent = '--'
		data.time = recent
		data.bonus = 0
		consumed = 0	
		qtyarr = []	
		qtyarr.push 0
		$.each @model.get('occurrence'), (ind,val)->
			occurrence = _.has(val, "occurrence");
			expected = _.has(val, "expected");
			if occurrence == true && expected == true
				date = val.occurrence
				occurrenceArr.push date
				consumed++
				console.log val.meta_value
				qtyconsumed = HomeX2OView::getCount(val.meta_value)
				qtyarr.push qtyconsumed[0]


			if occurrence == true && expected == false
				bonusArr++
			
		if occurrenceArr.length != 0 
			recent = _.last occurrenceArr
			d = new Date(recent)
			timestamp = d.getTime()
			data.time = moment(timestamp).zone(timezone).format("ddd, h:mm A")
			data.bonus = bonusArr
			data.occurr = occurrenceArr.length
		howmuchqty = _.last qtyarr
		console.log howmuch = parseFloat(howmuchqty) * 100
		$.each timearr , (ind,val)->
			temp = val.split('-')
			t0 = moment(temp[0], "hA").format('YYYY-MM-DD HH:mm:ss')
			t1 = moment(temp[1], "hA").format('YYYY-MM-DD HH:mm:ss')

			time = _.last timearray
			d = moment().format('YYYY-MM-DD')
			d0 = new Date(t0)
			timestamp0 = d0.getTime()
			d1 = new Date(t1)
			timestamp1 = d1.getTime()
			time1 = moment(timestamp0).zone(timezone).format("x")
			time2 = moment(timestamp1).zone(timezone).format("x")
			if parseInt(time1) < parseInt(time) && parseInt(time2) > parseInt(time)
				timeslot = Messages[val]
		console.log timeslot
		$.each per , (ind,val)->
			if parseInt(val) == parseInt(howmuch)
				texmsg = Messages[val+'_'+timeslot]
		$.each per1 , (ind,val)->
			temp = val.split('_')
			if parseInt(temp[0]) < parseInt(howmuch) && parseInt(temp[1]) > parseInt(howmuch)
				texmsg = Messages[val+'_'+timeslot]
		data.texmsg = texmsg
		data.remianing = occurrenceArr.length
		data.dateval = App.currentUser.get('homeDate')
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
		console.log val
		count = 0
		time = []
		if!(_.isArray(val)) 
			count += parseFloat val.qty
			time.push val.date
		else
			$.each val , (ind,val1)->
				if!(_.isArray(val1)) 
					count += parseFloat val1.qty
					time.push val1.date
				else
					$.each val1 , (ind,val2)->
						if _.isArray(val2)
							$.each val2 ,  (ind,value)->
								count += parseFloat value.qty
								time.push value.date
						else
							count += parseFloat val2.qty
							time.push val2.date

		console.log time
		lasttime = _.last time
		[count, lasttime]	

	
		
		
	get_occurrence:(data)->
		occurrence = _.has(data, "occurrence")
		expected = _.has(data, "expected")
		meta_value = data.meta_value
		value = 0
		arr = []
		qty = 0
		console.log qty = HomeX2OView::getCount(data.meta_value)

		if qty[1] == undefined
			qty[1] = []		
		if occurrence == true && expected == true
			arr['color'] = "#6bbfff"
			arr['value'] = qty[0]
			arr['time'] = qty[1]
			
			
		else if occurrence == false && expected == true
			arr['color'] = "#e3e3e3"
			arr['value'] = qty[0]
			arr['time'] = qty[1]
			
		else if occurrence == true && expected == false
			arr['color'] = "#ffaa06"
			arr['value'] = qty[0]
			arr['time'] = qty[1]
			

		arr


	drawBottle:(data)->
		d = new Date()
		n = -(d.getTimezoneOffset())
		
		timezone = n
		if App.currentUser.get('timezone') != null
			timezone = App.currentUser.get('timezone')
		doughnutData = []
		$.each data, (ind,val)->
			console.log occurrence = HomeX2OView::get_occurrence(val)
			msg = "No change in consumption(in ml)"
			i = parseInt(ind) + 1
			if occurrence['value'] == 0 
				occurrence['value'] = 1
			if occurrence['time'].length != 0
				actualtime = occurrence['time']
				d = new Date(actualtime)
				timestamp = d.getTime()
				time = moment(timestamp).zone(timezone).format('h:mm A')
			
				
				msg = "Bottle "+ i+ ' consumed(in ml) at '+ time
			doughnutData.push 
					value: parseFloat(occurrence['value']) * 100 
					color:occurrence['color']
					label: msg
				
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
					

			  <ul class="list-inline dotted-line  text-center row m-t-20 panel-product">
								  <li class="col-md-8 col-xs-12"> 
							 <ul class="list-inline no-dotted">
							 					{{#no_servings}}
					
				 
									  
										{{{servings}}}
										
										
									 
									  
										
				
					{{/no_servings}}
					

				  

					
 
</ul>                          
								  </li>
								   
									<li class="col-md-4 col-xs-12 mobile-status">
										<h5 class="text-center hidden-xs">Status</h5>
											<i class="fa fa-smile-o"></i>  
										<h6 class="text-center margin-none status">{{texmsg}}</h6>
									</li>
								</ul>
			  
			  </div>
		  <div class="panel-footer"><i id="bell{{id}}" class="fa fa-bell-slash no-remiander"></i> Hey {{username}}! {{msg}}</div>


				 '

	ui :
		anytime     : '.anytime'

	events:
		'click #original':(e)->
			console.log @model.get 'available'
			available = @model.get 'available'

			if parseInt(available) <= 0
				e.preventDefault()
				$('.aj-response-message').addClass('alert alert-danger').text("Product out of stock!")
				$('html, body').animate({
									scrollTop: 0
									}, 'slow')
				return false
			else
				return true

	

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
		per = [0,25,50,75,100]
		per1 = ['25_50','50_75']
		timearr = ["2AM-11AM","11AM-4PM","4PM-9PM","9PM-2AM"]
		data = super()
		recent = '--'
		data.occur = 0
		data.time = recent
		data.bonus = 0
		occurrenceArr = []
		no_servings  = []
		bonusArr = 0
		consumed = 0
		qty = @model.get 'qty'	
		product_type = @model.get('product_type')
		product_type = product_type.toLowerCase()
		temp = []
		texmsg = ""
		timeslot = ""
		time = ""
		timearray = []
		d = new Date()
		n = -(d.getTimezoneOffset())
		timezone = n
		if App.currentUser.get('timezone') != null
			timezone = App.currentUser.get 'timezone'
		d = new Date()
		timestamp = d.getTime()
		timearray.push moment(timestamp).zone(timezone).format("x")	
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
				consumed++
				
			else if occurrence == false && expected == true 
				reponse = ProductChildView::expectedfunc(val,ind,count,model)
				count++
				
			response = reponse[0]
			no_servings.push servings : response.html , schedule : response.schedule_id , meta_id : response.meta_id ,qty :response.qty
			data.no_servings =  no_servings
			data.serving_size = temp.length
		console.log howmuch = parseFloat(parseInt(consumed)/parseInt(temp.length)) * 100
		$.each timearr , (ind,val)->
			temp = val.split('-')
			t0 = moment(temp[0], "hA").format('YYYY-MM-DD HH:mm:ss')
			t1 = moment(temp[1], "hA").format('YYYY-MM-DD HH:mm:ss')

			time = _.last timearray
			d = moment().format('YYYY-MM-DD')
			d0 = new Date(t0)
			timestamp0 = d0.getTime()
			d1 = new Date(t1)
			timestamp1 = d1.getTime()
			time1 = moment(timestamp0).zone(timezone).format("x")
			time2 = moment(timestamp1).zone(timezone).format("x")
			if parseInt(time1) < parseInt(time) && parseInt(time2) > parseInt(time)
				timeslot = Messages[val]
		console.log timeslot
		$.each per , (ind,val)->
			if parseInt(val) == parseInt(howmuch)
				texmsg = Messages[val+'_'+timeslot]
		$.each per1 , (ind,val)->
			temp = val.split('_')
			if parseInt(temp[0]) < parseInt(howmuch) && parseInt(temp[1]) > parseInt(howmuch)
				texmsg = Messages[val+'_'+timeslot]
		
		msg = "Time set for reminders has already elapsed"
		if parseInt(model.get('reminder').length) == 0
			msg = "No reminders set"
		
		if @model.get('upcoming').length != 0
			$.each @model.get('upcoming') , (ind,val)->
				console.log time = _.last timearray
				d = new Date(val.next_occurrence)
				timestamp = d.getTime()
				time1 = moment(timestamp).zone(timezone).format("x")
			
				if parseInt(time) < parseInt(time1)
					$('#bell'+model.get('id')).removeClass 'fa-bell-slash no-remiander'
					$('#bell'+model.get('id')).addClass 'fa-bell-o element-animation'
					console.log timedisplay = moment(val.next_occurrence+timezone, "HH:mm Z").format('h:mm A')
					msg = 'Your next reminder is at '+timedisplay
					return false
		data.texmsg = texmsg
		data.username = App.currentUser.get('display_name')
		data.msg = msg
		data

	expectedfunc:(val,key,count,model)->
		
		temp = []
		i = 0
		html = ""
		d = new Date()
		n = -(d.getTimezoneOffset())
		
		timezone = n
		if App.currentUser.get('timezone') != null
			timezone = App.currentUser.get 'timezone'
		product_type = model.get 'product_type'
		product_type = product_type.toLowerCase()
		qty = model.get 'qty'
		reminders = model.get 'reminder'
		classname = "hidden"
		time = ""
		tempcnt = 0
		increment = parseInt(key) + 1
		product = model.get('id')
		date = App.currentUser.get('homeDate')
		whenarr = [0 , 'Morning Before meal' , 'Morning After meal' ,'Night Before meal' ,'Night After meal' ]
		
		if model.get('type') == "Anytime"
			serving_text = 'Serving '+increment
		else
			serving_text = whenarr[qty[key].when]

		if parseInt(reminders.length) != 0
			classname = ''
			time = reminders[key].time
			d = new Date(time)
			timestamp = d.getTime()
			time = moment(timestamp).zone(timezone).format("h:mm A")
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
		d = new Date()
		n = -(d.getTimezoneOffset())
		timezone = n
		if App.currentUser.get('timezone') != null
			timezone = App.currentUser.get 'timezone'
		d = new Date(val.meta_value.date)
		timestamp = d.getTime()
		time = moment(timestamp).zone(timezone).format("h:mm A")
			
		product_type = model.get 'product_type'
		product_type = product_type.toLowerCase() 
		console.log qty = val.meta_value.qty
		if parseInt(qty) == 0
			time = "Skipped"
		html = ""
		newClass = product_type+'_occurred_class'
		html += '<li><a><h3 class="bold"><div class="cap '+newClass+'"></div>'+qty+'</h3></a>'
		html +=	'<i class="fa fa-check center-block status"></i><h6 class="text-center text-primary">'+time+'</h6></li>'
		qty  = val.meta_value.qty
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
		


	
			
		








	
