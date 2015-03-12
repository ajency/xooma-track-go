App.state 'Asperbmi',
					url : '/products/:id/bmi/:date'
					parent : 'xooma'

			
class AsperbmiView extends Marionette.ItemView

	template : '#asperbmi-template'

	ui :
		responseMessage : '.aj-response-message'


	events:
		'click #confirm':(e)->
			$('.loadingconusme').html '<img src="'+_SITEURL+'/wp-content/themes/twentytwelve/xoomaapp/images/ajax-loader.gif" width="40px">'
				
			e.preventDefault()
			meta_id = @$el.find('#meta_id').val()
			qty = ( @originalBottleRemaining - @bottleRemaining ) / 100
			if qty is 0
				$('.loadingconusme').html ""
				window.removeMsg()
				@ui.responseMessage.addClass('alert alert-danger').text("No change in the quantity!")
				$('html, body').animate({
									scrollTop: 0
									}, 'slow')
				return
			if parseInt(@model.get('available')) <= 0
				$('.loadingconusme').html ""
				window.removeMsg()
				@ui.responseMessage.addClass('alert alert-danger').text("Produt out of stock!")
				$('html, body').animate({
									scrollTop: 0
									}, 'slow')
				return

			product = @model.get('id')
			date = App.currentUser.get('homeDate')
			todays_date = moment().format('YYYY/MM/DD')
			currentime = moment(App.currentUser.get('today'),'YYYY-MM-DD HH:mm:ss').format('HH:mm:ss')
			s = moment(todays_date+currentime,'YYYY-MM-DD HH:mm:ss').format('hh:mm A')
			
			t = $('#consume_time').val()
			time  = moment(t,"hh:mm A").format("HH:mm:ss")
			$.ajax
						method : 'POST'
						data : 'meta_id='+meta_id+'&qty='+qty+'&date='+date+'&time='+time
						url : "#{_SITEURL}/wp-json/intakes/#{App.currentUser.get('ID')}/products/#{product}"
						success: @saveHandler
						error :@erroraHandler

		'click .reset-progress' : ->
			@bottleRemaining = @originalBottleRemaining
			@bottle.setProgress @bottleRemaining

		'touchstart .bottle' : 'startProgress'
		'mousedown .bottle' : 'startProgress'


		'touchend .bottle' : 'stopProgress'
		'mouseup .bottle' : 'stopProgress'
		'mouseout .bottle' : 'stopProgress'



	saveHandler:(response,status,xhr)=>
		$('.loadingconusme').html ""
		count1 = 0
		if xhr.status == 201
			occurResponse = _.map response.occurrence[0].occurrence, (occurrence)->
				occurrence.meta_id = parseInt occurrence.meta_id
				occur = _.has(occurrence, "occurrence")
				expected = _.has(occurrence, "expected")
				if occur == true && expected == true
					count1++
				occurrence
			console.log response
			@model.set 'occurrence' , response.occurrence[0].occurrence
			model = new UserProductModel 
			model.set response.occurrence[0]
			App.useProductColl.add model , {merge: true}
			@$el.find('#meta_id').val response.meta_id		
			tempColl = new Backbone.Collection occurResponse
			model = tempColl.findWhere
				meta_id : parseInt response.meta_id

			
				
			
			index = tempColl.indexOf(model);
			index = parseInt(index) + 1
			cnt = @getCount model.get 'meta_value'
			@originalBottleRemaining = @bottleRemaining
			msg = @showMessage(cnt)
			if parseInt(count1) >=	parseInt(response.occurrence[0].occurrence.length) && parseInt(cnt) == 1
				$('.bonus').text '(Bonus)'
			$('.msg').html msg
			if parseInt(cnt) is 1
				cnt = 0
				@create_occurrences(index)
			$('.bottlecnt').text cnt
			
			window.removeMsg()
			@ui.responseMessage.addClass('alert alert-success').text("Consumption saved!")
			$('html, body').animate({
								scrollTop: 0
								}, 'slow')
		else
			@showErrorMsg()

	erroraHandler:(response,status,xhr)=>
		@showErrorMsg()

	showErrorMsg:->
		window.removeMsg()
		@ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be saved!")
		$('html, body').animate({
							scrollTop: 0
							}, 'slow')
		

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

	serializeData:->
		data = super()
		arr1 = []
		count = 0
		data.day = moment().format("dddd")
		data.today = moment().format("MMMM Do YYYY")
		data

	onShow:->
			timezone = App.currentUser.get('offset')
			todays_date = moment().format('YYYY-MM-DD')
			date  = Marionette.getOption( @, 'date')
			currentime = moment.utc(App.currentUser.get('today'),'YYYY-MM-DD HH:mm:ss').zone(timezone).format('HH:mm:ss')
			console.log s = moment(todays_date+currentime,'YYYY-MM-DD HH:mm:ss').format('hh:mm A')
			
			#Commented as this does not work on mobile
			# $('.input-small').timepicker(
			# 	defaultTime : s
			# )
			$('.input-small').val s
			
			$('#date').val date
			@generate(@model.get('occurrence'))

	generate:(data)->
			occur = data
			bonus = 0
			count1 = 0
			count = 0
			console.log @model
			console.log @model.get('occurrence').length
			$.each occur , (ind,val)=>
				occurrence = _.has(val, "occurrence")
				expected = _.has(val, "expected")
				meta_id = val.meta_id
				count = @getCount(val.meta_value)
				
				if occurrence == true && (expected == true || expected == false) && count ==  1
					count1++
					return true
				else if occurrence == true && (expected == true || expected == false) && count !=  1
					@update_occurrences(val,ind,occur)
					return false
				else
					@create_occurrences(ind)
					return false
			if(parseInt(@model.get('occurrence').length) == parseInt count1)
				ind = 'bonus'
				@create_occurrences(ind)
				
	create_occurrences:(ind)=>
			console.log @model
			if ind == 'bonus'
				$('.bonus').text '(Bonus)'
				ind  = parseInt(@model.get('occurrence').length) 
			$('#meta_id').val(0)
			$('.serving').text 'Serving '+ (parseInt(ind) + 1)
			$('.bottlecnt').text 'No Consumption'
			msg = @showMessage(0)
			$('.msg').text msg
			@originalBottleRemaining = 100
			@bottleRemaining = 100
			@bottle = new EAProgressVertical(@$el.find('.bottle'),@bottleRemaining,'empty',10000,[25,50,75])

	update_occurrences:(data,ind,occur)=>
			count = 0
			meta_value = data.meta_value
			count = @getCount(data.meta_value)
			ind = ind + 1
			consumed = 0
			$.each occur , (ind,val)=>
				occurrence = _.has(val, "occurrence")
				expected = _.has(val, "expected")
				if occurrence == true && expected == false
					consumed++
			if parseInt(consumed) >= 1
				ind = 'bonus'
				$('.bonus').text '(Bonus)'
				ind  = parseInt(occur.length) 
			$('#add').hide()
			$('.serving').text 'Serving '+ (parseInt(ind))
			$('#meta_id').val parseInt data.meta_id
			$('.bottlecnt').text count
			msg = @showMessage(count)
			$('.msg').html msg
			@bottleRemaining = 100 - 100*count
			@originalBottleRemaining = @bottleRemaining 
			@bottle = new EAProgressVertical(@$el.find('.bottle'),@bottleRemaining,'empty',10000,[25,50,75])
	
	showMessage:(count)->
		console.log count
		temp = [0,0.25,0.5,0.75,1]
		msg = ""
		$.each temp , (ind,val)->
			if parseFloat(count) == parseFloat(val)
				console.log msg = x2oMessages[val]


		msg



	startProgress : =>
		@bottle.startProgress()

	stopProgress : =>
		progress = @bottle.stopProgress(true)
		@bottle.setProgress(progress)
		@bottleRemaining = progress



		
			

				
		
class App.AsperbmiCtrl extends Ajency.RegionController
	initialize : (options = {})->
		@show @parent().getLLoadingView()
		#productId  = @getParams()
		# url = window.location.hash.split('#')
		# locationurl = url[1].split('/')
		# product = parseInt locationurl[2]
		# date = locationurl[4]
		# products = []
		# App.useProductColl.each (val)->
		# 	products.push val
		
		# productsColl =  new Backbone.Collection products
		# productModel = productsColl.where({id:parseInt(product)})
		
		# if parseInt(productModel.length) == 0
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
		@show new AsperbmiView
					model : productModel
					date : date