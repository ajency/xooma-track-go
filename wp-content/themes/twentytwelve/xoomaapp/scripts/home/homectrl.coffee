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
			window.param = $(e.target).val()
			if $('.time_period').val() == '' || $('.time_period').val() == 'all'
				reg_date = App.graph.get 'reg_date'
				@ui.start_date.val reg_date
			else
				id = @ui.time_period.val()
				date =  moment().subtract(id, 'days')
				previous = date.format('YYYY-MM-DD')
				@ui.start_date.val previous
			timezone = App.currentUser.get('timezone')
			tt = moment().format('YYYY-MM-DD HH:mm:ss')
			d = new Date()
			timestamp = d.getTime()
		
			
			today = moment(timestamp).zone(timezone).format('YYYY-MM-DD')
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
			window.time_period = $(e.target).val()
			id = $(e.target).val()
			date =  moment().subtract(id, 'days')
			previous = date.format('YYYY-MM-DD')
			timezone = App.currentUser.get('timezone')
			tt = moment().format('YYYY-MM-DD HH:mm:ss')
			d = new Date()
			timestamp = d.getTime()
		
			
			today = moment(timestamp).zone(timezone).format('YYYY-MM-DD')
			@ui.start_date.val previous
			
			
			if id == 'all'
				reg_date = App.graph.get 'reg_date'
				@ui.start_date.val reg_date
			@ui.end_date.val today

		'click #showHome':(e)->
			if !window.isWebView()
				$('.loading').html 'Loading data<img src="'+_SITEURL+'/wp-content/themes/twentytwelve/xoomaapp/images/lodaing.GIF" width="70px">'
			
			#Changes for Mobile
			if window.isWebView()
				$('.loading').html 'Loading data<img src="./images/lodaing.GIF" width="70px">'
			
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
		if !window.isWebView()
			$('.loadinggraph').html 'Loading data<img src="'+_SITEURL+'/wp-content/themes/twentytwelve/xoomaapp/images/lodaing.GIF" width="70px">'
		
		#Changes for Mobile
		if window.isWebView()
			$('.loadinggraph').html 'Loading data<img src="./images/lodaing.GIF" width="70px">'	
		
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
		$('#param option[value="'+window.param+'"]').prop("selected",true)
		$('.time_period option[value="'+window.time_period+'"]').prop("selected",true)
		$('#param').trigger( "change" )
		$('.time_period').trigger( "change" )
		console.log todays_date = moment().format('YYYY-MM-DD')
		$('#showHome').hide()
		App.trigger 'cordova:hide:splash:screen'
		App.trigger 'cordova:register:push:notification'
		timezone = App.currentUser.get('offset')
		currentime = moment.utc(App.currentUser.get('today'),'YYYY-MM-DD HH:mm:ss').zone(timezone).format('HH:mm:ss')
		s = moment(todays_date+currentime,'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss')
		d = new Date(s)
		actual_time = d.getTime()
		console.log App.currentUser.get('homeDate')
		current = new Date(actual_time)
		day_night = current.getHours()
		if(parseInt(day_night)<=12)
			$('.daynightclass').attr('src', _SITEURL+'/wp-content/themes/twentytwelve/images/morning.gif')
		else
			$('.daynightclass').attr('src' , _SITEURL+'/wp-content/themes/twentytwelve/images/night.gif')
		
		$('#update').val App.currentUser.get('homeDate')
		selectedtimestamp = moment(App.currentUser.get('homeDate'),'YYYY-MM-DD').format("YYYY-MM-DD")
		selected_time = moment(selectedtimestamp).zone(timezone).format('x')
		
		reg_date = moment(App.currentUser.get('user_registered')).format('YYYY-MM-DD')

		if !window.isWebView()
			if todays_date == App.currentUser.get('homeDate')
				$('#update').val 'TODAY'
			
			$('#update').datepicker(
					dateFormat : 'yy-mm-dd'
					changeYear: true,
					changeMonth: true,
					maxDate: new Date(todays_date)
					minDate : new Date(reg_date)
					onSelect: (dateText, inst)->
						$('#showHome').show()
						App.currentUser.set 'homeDate' , dateText
						selectedtimestamp = moment(App.currentUser.get('homeDate')+currentime,'YYYY-MM-DD HH:mm:ss').format("YYYY-MM-DD HH:mm:ss")
						selected_time = moment(selectedtimestamp).zone(timezone).format('x')
			
						if todays_date == App.currentUser.get('homeDate')
							$('#update').val 'TODAY'
						

			)

		#Changes for Mobile
		if window.isWebView()
			$('#update')
			.attr
				max: moment().format 'YYYY-MM-DD'
				min: reg_date
			.change ->
				$('#showHome').show()
				App.currentUser.set 'homeDate', $('#update').val()
				selectedtimestamp = moment(App.currentUser.get('homeDate')+currentime,'YYYY-MM-DD HH:mm:ss').format("YYYY-MM-DD HH:mm:ss")
				selected_time = moment(selectedtimestamp).zone(timezone).format('x')

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
		$('#bmi').show()
		@reset()
		$('#y-axis').text 'BMI Ratio'
		$('#canvasregion').show()
		dates = [response['st_date'],response['et_date']]

		bmi_start_ht = parseFloat(response['st_height']) *  12
		bmi_end_ht = parseFloat(response['et_height']) *  12
		st_square = parseFloat(bmi_start_ht) * parseFloat(bmi_start_ht)
		et_square = parseFloat(bmi_end_ht) * parseFloat(bmi_end_ht)
		bmi_start = (parseFloat(response['st_weight'])/parseFloat(st_square))* 703
		bmi_start = bmi_start.toFixed(2)
		bmi_end = (parseFloat(response['et_weight'])/parseFloat(et_square))* 703
		bmi_end = bmi_end.toFixed(2)
		lineChartData = 
			labels : dates,
			datasets : [
				
				{
					label: "My Second dataset",
					fillColor : "rgba(255, 255, 255, 0.12)",
					strokeColor : "rgba(151,187,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(151,187,205,1)",
					data : [bmi_start,bmi_end]
				
				},
				{
		     
		            label: "My First dataset",
		            fillColor: "rgba(255, 255, 255, 0.12)",
		            strokeColor: "rgba(151,187,205,1)",
		            pointColor: "rgba(151,187,205,1)",
		            pointStrokeColor: "#fff",
		            pointHighlightFill: "#fff",
		            pointHighlightStroke: "rgba(220,220,220,1)",
		            data: [24.9,24.9]
		        },
		        {
		        
		            label: "My Second dataset",
		            fillColor: "rgba(255, 255, 255, 0.12)",
		            strokeColor: "rgba(151,187,205,1)",
		            pointColor: "rgba(151,187,205,1)",
		            pointStrokeColor: "#fff",
		            pointHighlightFill: "#fff",
		            pointHighlightStroke: "rgba(151,187,205,1)",
		            data: [18.5,18.5]

		        }
		       
				
			]


		ctdx = document.getElementById("canvas").getContext("2d");
		window.myLine = new Chart(ctdx).Line(lineChartData, 
			responsive: true
		);

	reset:->
		$('#canvas').remove(); 
		$('#graph-container').append('<canvas id="canvas"><canvas>');
		canvas = document.querySelector('#canvas');
		ctx = canvas.getContext('2d');
		ctx.canvas.width = "600";
		ctx.canvas.height = "450"; 
		


	generateGraph:->
		$('#bmi').hide()
		@reset()
		units = 'inches'
		size = 'Size'
		if $('#param').val() == 'weight'
			units = 'pounds'
			size = 'Weight'
		$('#y-axis').text size+'('+units+')'
		$('#canvasregion').show()
		dates = App.graph.get 'dates'
		param = App.graph.get 'param'
		if dates.length == 0 && param.length == 0
			$('.loadinggraph').html "<li>No data found</li>"
			$('#canvasregion').hide()
			return false
		lineChartData = 
			labels : dates,
			datasets : [
			
				
					label: "My Second dataset",
					fillColor : "#ffffff",
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
		state = App.currentUser.get 'state'
		if state != '/home'
			@show new workflow
			return false
		if App.useProductColl.length == 0 || App.currentUser.hasChanged('timezone')
			window.param = 'weight'
			window.time_period = 'all'
			App.currentUser.set 'homeDate' , ""
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
				 <h5 class=" mid-title margin-none"><div> {{name}}</div>
					<i type="button" class="fa fa-bars pull-right dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i>
					 <ul class="dropdown-menu pull-right" role="menu">
						<li><a href="#/product/{{id}}/history">Consumption History</a></li>
						<li><a href="#/product/{{id}}/edit">Edit product</a></li>
						
					  </ul>
			  </h5>
		<div class="row">
			
				  <div class="fill-bottle"> 
				 <a id="original" href="#/products/{{id}}/bmi/{{dateval}}" > <h6 class="text-center">Hydrate!</h6>   
						<img src="'+_SITEURL+'/wp-content/themes/twentytwelve/images/xooma-bottle.gif"/>
							 

						<h6 class="text-center texmsg">{{texmsg}}</h6> </a>         
					
				  </div><div id="rays"></div>

					 <div id="canvas-holder">
						<canvas id="chart-area" width="500" height="500"/>
					</div>
			
			</div>
		</div><h6 class="text-primary text-center"><i class="fa fa-clock-o "></i> Last consumed at {{time}}</h6>

		<br/></div></div>'
	ui :
		liquid : '.liquid'

	events:
		'click #original':(e)->
			available = @model.get 'available'

			if parseInt(available) <= 0
				e.preventDefault()
				window.removeMsg()
				$('.aj-response-message').addClass('alert alert-danger').text("Product out of stock!")
				$('html, body').animate({
									scrollTop: 0
									}, 'slow')
				return false
			else
				return true

	serializeData:->
		
		data = super()
		texmsg = ""
		timezone = App.currentUser.get('timezone')
		occurrenceArr = []
		bonusArr = 0
		recent = '--'
		data.time = recent
		
		consumed = 0	
		qtyarr = 0
		qtyconsumed = []
		totalservings = 0
		
		$.each @model.get('occurrence'), (ind,val)->
			occurrence = _.has(val, "occurrence");
			expected = _.has(val, "expected");
			if occurrence == true && (expected == true || expected == false)
				qtyconsumed = HomeX2OView::getCount(val.meta_value)
				occurrenceArr.push qtyconsumed[1]
			if occurrence == true && expected == false
				consumed++

			if occurrence == true && expected == true
				qtyconsumed = HomeX2OView::getCount(val.meta_value)
				qtyarr = parseFloat(qtyconsumed[0]) * 100
				q = parseInt(qtyarr) / 25
				totalservings += q
				
				
			
		if occurrenceArr.length != 0 
			recent = _.last occurrenceArr
			offset = App.currentUser.get('offset')
			console.log d = new Date(recent)
			timestamp = d.getTime()
			data.time = moment.utc(recent).zone(offset).format("ddd, h:mm A")
			
			data.occurr = occurrenceArr.length
		howmuchqty = parseInt(@model.get('occurrence').length) * 4
		
		howmuch = parseInt(totalservings) / parseInt(howmuchqty)
		selectedtimestamp = moment(App.currentUser.get('homeDate'),'YYYY-MM-DD').format("YYYY-MM-DD HH:mm:ss")
		d = new Date(App.currentUser.get('today'))
		todays_date = moment().format('YYYY-MM-DD')
		currentime = moment(App.currentUser.get('today'),'YYYY-MM-DD HH:mm:ss').format('HH:mm:ss')
		s = moment(todays_date+currentime,'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss')
		d = new Date(s)
		actual_time = d.getTime()
		selectedtimestamp = moment(App.currentUser.get('homeDate')+currentime,'YYYY-MM-DD HH:mm:ss').format("YYYY-MM-DD HH:mm:ss")
		selected_time = moment(selectedtimestamp).zone(timezone).format('x')
		
		texmsg = "The day has passed by"
		if parseInt(actual_time) == parseInt(selected_time)
			texmsg = @generateStatus(consumed,howmuch)
		
		data.texmsg = texmsg
		data.remianing = occurrenceArr.length
		data.dateval = App.currentUser.get('homeDate')
		data.qty = @model.get('qty').length
		data

	generateStatus:(consumed,howmuch)->
		timezone = App.currentUser.get('offset')
		texmsg = ""
		timeslot = ""
		timearray = []
		d = new Date()
		timestamp = d.getTime()
		s = moment(App.currentUser.get('today'),'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD')
		currentime = moment.utc(App.currentUser.get('today'),'YYYY-MM-DD HH:mm:ss').zone(timezone).format('HH:mm:ss')
		sw = moment(s+currentime,'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD hh:mm A')
		time = new Date(Date.parse(sw)).getTime()
		
		per = [0,25,50,75,100,'bonus']
		per1 = ['0_25','25_50','50_75','75_100']
		timearr = ["12AM-11AM","11AM-4PM","4PM-9PM","9PM-12AM"]
		timearry = ["12:00:00 AM-10:59:59 AM","11:00:00 AM-3:59:59 PM","4:00:00 PM-8:59:59 PM","9:00:00 PM-11:59:59 PM"]
		how = howmuch.toFixed(2) * 100
		if parseInt(consumed) >= 1
				how = 'bonus'
		$.each timearry , (ind,val)->
			v = timearr[ind]
			temp = val.split('-')
			
			d0 = new Date(s+' '+temp[0])

			timestamp0 = d0.getTime()
			d1 = new Date(s+' '+temp[1])
			timestamp1 = d1.getTime()
			if parseInt(timestamp0) <= parseInt(time) && parseInt(timestamp1) >= parseInt(time)
				timeslot = x2oMessages[v]
		
		$.each per , (ind,val)->
			if val == how
				texmsg = x2oMessages[val+'_'+timeslot]
		$.each per1 , (ind,val)->
			temp = val.split('_')
			if parseInt(temp[0]) < parseInt(how) && parseInt(temp[1]) > parseInt(how)
				texmsg = x2oMessages[val+'_'+timeslot]
		
		texmsg


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

		
		lasttime = _.last time
		[count, lasttime]	

	
		
		
	get_occurrence:(data)->
		occurrence = _.has(data, "occurrence")
		expected = _.has(data, "expected")
		meta_value = data.meta_value
		value = 0
		arr = []
		qty = 0
		qty = HomeX2OView::getCount(data.meta_value)

		if qty[1] == undefined
			qty[1] = []		
		if occurrence == true && expected == true
			arr['color'] = "#6bbfff"
			arr['value'] = qty[0]
			arr['time'] = qty[1]
			
			
		if occurrence == false && expected == true
			arr['color'] = "#e3e3e3"
			arr['value'] = qty[0]
			arr['time'] = qty[1]
			
		if occurrence == true && expected == false
			arr['color'] = "#ffaa06"
			arr['value'] = qty[0]
			arr['time'] = qty[1]
			

		arr


	drawBottle:(data)->
		d = new Date()
		n = -(d.getTimezoneOffset())

		data.sort( (a,b)->
			return parseInt(a.meta_id) - parseInt(b.meta_id)

		)
		
		timezone = n
		if App.currentUser.get('timezone') != null
			timezone = App.currentUser.get('timezone')
		doughnutData = []
		$.each data, (ind,val)->
			occurrence = HomeX2OView::get_occurrence(val)
			
			i = parseInt(ind) + 1
			if occurrence['value'] == 0 
				msg = "Pending "
				occurrence['value'] = 1
			if occurrence['time'].length != 0
				actualtime = occurrence['time']
				d = new Date(actualtime)
				timestamp = d.getTime()
				time = moment(timestamp).zone(timezone).format('h:mm A')
			
				
				msg = "(%) of Bottle "+ i+ ' consumed '
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
			 <h5 class=" mid-title margin-none"><div> {{name}}<span>( {{serving_size}}  Serving/ Day )</span></div><i type="button" class="fa fa-bars pull-right dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i>
					 <ul class="dropdown-menu pull-right" role="menu">
						<li><a href="#/product/{{id}}/history">Consumption History</a></li>
						<li><a href="#/product/{{id}}/edit">Edit product</a></li>
						
						
					  </ul>
			  </h5>
			  <input type="hidden" name="qty{{id}}"  id="qty{{id}}" value="" />
							<input type="hidden" name="meta_id{{id}}"  id="meta_id{{id}}" value="" />
					

			  <ul class="list-inline dotted-line  text-center row m-t-20 panel-product">
								  <li class="col-md-8 col-xs-12 col-sm-8"> 
							 <ul class="list-inline no-dotted">
												{{#no_servings}}
					
				 
									  
										{{{servings}}}
										
										
									 
									  
										
				
					{{/no_servings}}
					

				  

					
 
</ul>                          
								  </li>
								   
									<li class="col-md-4 col-xs-12 col-sm-4 mobile-status">
										<h5 class="text-center hidden-xs">Status</h5>
											<i class="fa fa-smile-o"></i>  
										<h6 class="text-center margin-none status">{{texmsg}}</h6>
									</li>
								</ul>
			  
			  </div>
		  <div class="panel-footer hidden"><i id="bell{{id}}" class="{{remindermsg}}"></i> Hey {{username}}! {{msg}}</div>


				 '

	ui :
		anytime     : '.anytime'

	events:
		'click #original':(e)->
			available = @model.get 'available'

			if parseInt(available) <= 0
				e.preventDefault()
				window.removeMsg()
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
		data = super()
		data.occur = 0
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
		timezone = App.currentUser.get 'timezone'
		d = new Date()
		timestamp = d.getTime()
		timearray.push moment().zone(timezone).format("x")	
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
				occurrenceArr.push val
				reponse = ProductChildView::occurredfunc(val,ind,model)
				if parseInt(val.meta_value.qty) != 0
					consumed++
				
			else if occurrence == false && expected == true 
				reponse = ProductChildView::expectedfunc(val,ind,count,model)
				count++
				
			response = reponse[0]
			no_servings.push servings : response.html , schedule : response.schedule_id , meta_id : response.meta_id ,qty :response.qty
		data.no_servings =  no_servings
		data.serving_size = temp.length
		skip = @checkSkip(temp)
		tt = moment().zone(timezone).format('x')
		todays_date = moment().format('YYYY-MM-DD')
		currentime = moment(App.currentUser.get('today'),'YYYY-MM-DD HH:mm:ss').format('HH:mm:ss')
		s = moment(todays_date+currentime,'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss')
		d = new Date(s)
		actual_time = d.getTime()
		selectedtimestamp = moment(App.currentUser.get('homeDate')+currentime,'YYYY-MM-DD HH:mm:ss').format("YYYY-MM-DD HH:mm:ss")
		selected_time = moment(selectedtimestamp).zone(timezone).format('x')
		texmsg = "The day has passed by"
		if skip[0].length != 0 && parseInt(actual_time) == parseInt(selected_time)
			texmsg = skip[1]
		else if skip[0].length == 0 && parseInt(actual_time) == parseInt(selected_time)
			howmuch = parseFloat(parseInt(consumed)/parseInt(temp.length)) * 100
			texmsg = @checkStatus(howmuch)
		
		msg = "Time set for reminders has already elapsed"
		if parseInt(model.get('reminder').length) == 0
			msg = "No reminders set"
		data.remindermsg = 'fa fa-bell-slash no-remiander'
		recent = _.last occurrenceArr
		if @model.get('upcoming').length != 0
			$.each @model.get('upcoming') , (ind,val)->
				if recent == undefined
					data.remindermsg = 'fa fa-bell-o element-animation'
					timedisplay = moment(val.next+timezone, "HH:mm Z").format('h:mm A')
					msg = 'Your next reminder is at '+timedisplay
					return false

				d1 = new Date(recent)
				timestamp1 = d1.getTime()
				rec = moment(timestamp1).zone(timezone).format("x")
				d = new Date(val.next)
				timestamp = d.getTime()
				time1 = moment(timestamp).zone(timezone).format("x")
				
				if parseInt(rec) < parseInt(time1)
					data.remindermsg = 'fa fa-bell-o element-animation'
					timedisplay = moment(val.next+timezone, "HH:mm Z").format('h:mm A')
					msg = 'Your next reminder is at '+timedisplay
					return false
		data.texmsg = texmsg
		data.username = App.currentUser.get('display_name')
		data.msg = msg
		data

	checkSkip:(temp)->
		skip_arr  = []
		$.each temp , (ind,val)->
			occurrence = _.has(val, "occurrence")
			expected = _.has(val, "expected")
			if occurrence == true && expected == true
				qty = val.meta_value.qty
				if parseInt(qty) == 0 
					skip_arr.push qty
				else
					skip_arr  = []
		msg = 'Oops! Not good! Try not to repeat'
		if skip_arr.length == temp.length
			msg = 'Aww! Thats bad..'

		[skip_arr,msg]

	checkStatus:(howmuch)->
		per = [0,25,50,75,100]
		per1 = ['25_50','50_75']
		timearr = ["12AM-11AM","11AM-4PM","4PM-9PM","9PM-12AM"]
		timearry = ["12:00:00 AM-10:59:59 AM","11:00:00 AM-3:59:59 PM","4:00:00 PM-8:59:59 PM","9:00:00 PM-11:59:59 PM"]
		
		timearray = []
		timezone = App.currentUser.get 'offset'
		timeslot = ""
		texmsg = ""
		d = new Date()
		timestamp = d.getTime()
		timearray.push moment().zone(timezone).format("x")
		# s = moment(App.currentUser.get('today'),'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD')
		# currentime = moment(App.currentUser.get('today'),'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss')
		# time = moment(currentime).format("x")

		s = moment(App.currentUser.get('today'),'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD')
		currentime = moment.utc(App.currentUser.get('today'),'YYYY-MM-DD HH:mm:ss').zone(timezone).format('HH:mm:ss')
		sw = moment(s+currentime,'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD hh:mm A')
		time = new Date(Date.parse(sw)).getTime()
		
		$.each timearry , (ind,val)->
			v = timearr[ind]
			temp = val.split('-')
			d0 = new Date(s+' '+temp[0])
			timestamp0 = d0.getTime()
			d1 = new Date(s+' '+temp[1])
			timestamp1 = d1.getTime()
			if parseInt(timestamp0) <= parseInt(time) && parseInt(timestamp1) >= parseInt(time)
				timeslot = Messages[v]
		
		$.each per , (ind,val)->
			if parseInt(val) == parseInt(howmuch)
				texmsg = Messages[val+'_'+timeslot]
		$.each per1 , (ind,val)->
			temp = val.split('_')
			if parseInt(temp[0]) < parseInt(howmuch) && parseInt(temp[1]) > parseInt(howmuch)
				texmsg = Messages[val+'_'+timeslot]

		texmsg


	expectedfunc:(val,key,count,model)->
		
		temp = []
		i = 0
		html = ""
		d = new Date()
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
			html += '<li><a href="#/products/'+product+'/consume/'+date+'" id="original"><span class="circle-btn"><img src="'+_SITEURL+'/wp-content/themes/twentytwelve/xoomaapp/images/btn_03.png" width="70px"></span></a>
					<h6 class="text-center margin-none">Tap to take </h6>
					<h6 class="text-center text-primary '+classname+'">'+time+'</h6></li>'
		else
			html += '<li><a >
				  <h3 ><div class="cap '+newClass+'"></div>'+qty[key].qty+'</h3>
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
		temp = []
		i = 0
		timezone = App.currentUser.get 'offset'
		time = moment.utc(val.meta_value.date).zone(timezone).format("h:mm A")
			
		product_type = model.get 'product_type'
		product_type = product_type.toLowerCase() 
		qty = val.meta_value.qty
		if parseInt(qty) == 0
			time = "Skipped"
		html = ""
		newClass = product_type+'_occurred_class'
		html += '<li><a><h3><div class="cap '+newClass+'"></div>'+qty+'</h3></a>'
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
		


	
			
		








	
