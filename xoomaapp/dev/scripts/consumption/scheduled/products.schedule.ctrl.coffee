App.state 'Schedule',
					url : '/products/:id/consume/:date'
					parent : 'xooma'

class ScheduleView extends Marionette.ItemView

	template : '#schedule-template'

	ui :
		intake : '.intake'
		update : '.update'
		form 	: '#consume'
		scheduleid : 'input[name="scheduleid"]'
		servings : '.servings'
		original : '.original'
		responseMessage : '.aj-response-message'
		cancel  : '.cancel'
		rangeSliders : '[data-rangeslider]'
		consume_time : 'input[name="consume_time"]'
		qty : 'input[name="qty"]'

	events:
		'change @ui.rangeSliders' : (e)-> @valueOutput e.currentTarget

		'click .reset' :(e)->
			qty  = $('#org_qty').val()
			@ui.rangeSliders.val parseInt(qty)
			@ui.rangeSliders.parent().find("output").html qty
			todays_date = moment().format('YYYY-MM-DD')
			timezone = App.currentUser.get 'offset'
			currentime = moment.utc(App.currentUser.get('today'),'YYYY-MM-DD HH:mm:ss').zone(timezone).format('HH:mm:ss')
			s = moment(todays_date+currentime,'YYYY-MM-DD HH:mm:ss').format('hh:mm A')
			$('#consume_time').val s		
			$('.input-small').timepicker(
				defaultTime : s
			)
			$('.now').text 'Now'

		'click @ui.servings':(e)->
			e.preventDefault()
			meta_id  = $(e.target).parent().attr 'data-value'
			qty  = $(e.target).parent().attr 'data-qty'
			if meta_id != ""
				$('#intake').removeClass "intake"
				$('#intake').addClass "update"
				$('#mydataModal').removeClass "hidden"

			ScheduleView::update_occurrences(meta_id,qty)
			
		'click @ui.original':(e)->
			e.preventDefault()
			$('#meta_id').val 0
			$('#qty').val ""
			$('#intake').addClass "intake"
			$('#intake').removeClass "update"
			$('#mydataModal').removeClass "hidden"
			temp = []
			qty = @model.get 'qty'
			$.each @model.get('occurrence') , (ind,val)->
				occurrence = _.has(val, "occurrence")
				expected = _.has(val, "expected")
				if occurrence == false && expected == true && qty[ind] != undefined
					temp.push qty[ind]
			first = temp[0]
			ScheduleView::create_occurrences(first);
			
			
	
		'click .intake':(e)->
				timezone = App.currentUser.get('offset')
				todays_date = moment().format('YYYY-MM-DD')
				sel_date = App.currentUser.get 'homeDate'
				currentime = moment.utc(App.currentUser.get('today'),'YYYY-MM-DD HH:mm:ss').zone(timezone).format('HH:mm:ss')
				s = moment(todays_date+currentime,'YYYY-MM-DD HH:mm:ss').format('YYYY/MM/DD hh:mm A')
				current = new Date(Date.parse(s)).getTime()
				t = $('#consume_time').val()
				seltime  = moment(t,"hh:mm a").format('YYYY/MM/DD hh:mm A')
				time  = moment(t,"hh:mm a").format("HH:mm:ss")
				d1 = new Date(Date.parse(seltime)).getTime()

				
				if parseInt(d1) > parseInt(current) && todays_date == sel_date
					window.removeMsg()
					@ui.responseMessage.addClass('alert alert-danger').text("Cannot select future time!")
					$('html, body').animate({
										scrollTop: 0
										}, 'slow')
					return false
				
		
				$('.loadingconusme').html '<img src="'+_SITEURL+'/wp-content/themes/twentytwelve/xoomaapp/images/ajax-loader.gif" width="40px">'
				e.preventDefault()
				meta_id = $('#meta_id').val()
				qty = @ui.qty.val()
				data = $('#schduleid').val()
				product = @model.get('id')
				date = App.currentUser.get('homeDate')
				
				
				$.ajax
						method : 'POST'
						data : 'meta_id='+meta_id+'&qty='+qty+'&date='+date+'&time='+time
						url : "#{APIURL}/intakes/#{App.currentUser.get('ID')}/products/#{product}"
						success: (response,status,xhr)=>
							@saveHandler response, status, xhr
							App.trigger 'fb:publish:feed', @model
						error :@erroraHandler


		

		
			

		'click #skip':(e)->
			e.preventDefault()
			$('.loadingconusme').html '<img src="'+_SITEURL+'/wp-content/themes/twentytwelve/xoomaapp/images/ajax-loader.gif" width="40px">'
				
			meta_id = $('#meta_id').val()
			qty = 0
			data = $('#schduleid').val()
			product = @model.get('id')
			date = App.currentUser.get('homeDate')
			t = $('#consume_time').val()
			time  = moment(t,"HH:mm a").format("HH:mm:ss")
			if t == ""
				time  = moment().format("HH:mm:ss")
			
			$.ajax
					method : 'POST'
					data : 'meta_id='+meta_id+'&qty='+qty+'&date='+date+'&time='+time
					url : "#{APIURL}/intakes/#{App.currentUser.get('ID')}/products/#{product}"
					success: @saveHandler
					error :@erroraHandler
			

	saveHandler:(response,status,xhr)=>
		console.log response
		@model.set 'occurrence' , response.occurrence[0].occurrence
		model = new UserProductModel 
		model.set response.occurrence[0]
		App.useProductColl.add model , {merge: true}
		App.navigate "#/home" , true
		
		

	onShow:->
		timezone = App.currentUser.get('offset')
		
		
		
		
		date  = Marionette.getOption( @, 'date')
		occurr = @model.get('occurrence')
		temp = []
		qty = @model.get 'qty'
		$.each occurr , (ind,val)->
			if qty[ind] != undefined
				temp.push val

		$.each temp , (ind,val)->
			occurrence = _.has(val, "occurrence")
			expected = _.has(val, "expected")
			if occurrence == false && expected == true
				console.log qty[ind].qty
				ScheduleView::create_occurrences(qty[ind].qty)
				return false
		
		$('#date').val date
		todays_date = moment().format('YYYY-MM-DD')
		# currentime = moment(App.currentUser.get('today'),'YYYY-MM-DD HH:mm:ss').format('HH:mm:ss')
		# console.log s = moment(todays_date+currentime,'YYYY-MM-DD HH:mm:ss').format('hh:mm A')
		
		currentime = moment.utc(App.currentUser.get('today'),'YYYY-MM-DD HH:mm:ss').zone(timezone).format('HH:mm:ss')
		console.log s = moment(todays_date+currentime,'YYYY-MM-DD HH:mm:ss').format('hh:mm A')
		
		if !window.isWebView()	
			$('.input-small').timepicker(
				defaultTime : s
			)

		#Changes for mobile
		if window.isWebView()
			$('.input-small')
				.val s
				.prop disabled: true
				.parent().click ->
					options = 
						date: moment($('.input-small').val(), 'hh:mm A').toDate()
						mode: 'time'
					
					datePicker.show options, (time)->
						if not _.isUndefined time
							$('.input-small').val moment(time).format('hh:mm A')



		@ui.rangeSliders.each (index, ele)=> @valueOutput ele
		@ui.rangeSliders.rangeslider polyfill: false


	valueOutput : (element) =>
		$(element).parent().find("output").html $(element).val()


	serializeData:->
		console.log @model
		data = super()
		data.day = moment().format("dddd")
		data.today = moment().format("MMMM Do YYYY")
		qty = @model.get 'qty'
		
		occurr = @model.get('occurrence')
		product_type = @model.get('product_type')
		product_type = product_type.toLowerCase()
		data.classname = product_type+'_default_class'
		no_servings  = []
		temp = []
		bonus = parseInt(@model.get('occurrence').length) - parseInt(qty.length)
		$.each occurr , (ind,val)->
			if qty[ind] != undefined
				temp.push val
		model = @model
		whenarr = [0 , 'Morning Before meal' , 'Morning After meal' ,'Night Before meal' ,'Night After meal' ]
		$.each temp , (ind,val)->
			occurrence = _.has(val, "occurrence")
			expected = _.has(val, "expected")
			if occurrence == false && expected == true
				if model.get('type') == 'Anytime'
					data.serving = 'Serving ' + (parseInt(ind) + 1)
				else
					data.serving = whenarr[qty[ind].when]
				data.qty = qty[ind].qty
				return false

				

				
		data.product_type = product_type
		data




	create_occurrences:(val)->
		$('#meta_id').val 0
		$('#org_qty').val val
		console.log $('#org_qty')

	update_occurrences:(meta_id,qty)->
		if meta_id == ""
			meta_id = 0
		$('#meta_id').val parseInt meta_id
		$('#qty').val qty
			


						


		
class App.ScheduleCtrl extends Ajency.RegionController
	initialize : (options = {})->
		# url = window.location.hash.split('#')
		# locationurl = url[1].split('/')
		# product = parseInt locationurl[2]
		# date = locationurl[4]
		# products = []
		# App.useProductColl.each (val)->
		# 	products.push val
		
		# productsColl =  new Backbone.Collection products
		# productModel = productsColl.where({id:parseInt(product)})
		# if productModel.length == 0
			@show @parent().getLLoadingView()
			App.currentUser.getHomeProducts().done(@showView).fail @errorHandler
		# else
		# 	@_showView(productModel[0],date)

	showView:(Collection)=>
		url = window.location.hash.split('#')
		locationurl = url[1].split('/')
		product = parseInt locationurl[2]
		date = locationurl[4]
		productModel = App.useProductColl.where({id:parseInt(product)})
		@_showView(productModel[0],date)


	
		

	_showView:(productModel,date)->
		@show new ScheduleView
					model : productModel
					date : date