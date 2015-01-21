App.state 'Asperbmi',
					url : '/products/:id/bmi'
					parent : 'xooma'

			
class AsperbmiView extends Marionette.ItemView

	template : '#asperbmi-template'

	ui :
		responseMessage : '.aj-response-message'


	events:
		'click #ssconfirm':(e)->
			e.preventDefault()
			console.log count = $('#confirm').attr('data-count',count)
			if parseInt(count) == 0
				@ui.responseMessage.text "Consumption not updated!!!!"
				return false
			meta_id = $('#meta_id').val()
			qty = $('#percentage').val()
			product = @model.get('id')
			$.ajax
						method : 'POST'
						data : 'meta_id='+meta_id+'&qty='+qty
						url : "#{_SITEURL}/wp-json/intakes/#{App.currentUser.get('ID')}/products/#{product}"
						success: @saveHandler
						error :@erroraHandler

		'touchstart .bottle' : 'startProgress'
		'mousedown .bottle' : 'startProgress'


		'touchend .bottle' : 'stopProgress'
		'mouseup .bottle' : 'stopProgress'
		'mouseout .bottle' : 'stopProgress'



	saveHandler:(response,status,xhr)=>
		$('#percentage').val 0
		console.log response
		@model.set 'occurrence' , response.occurrence
		console.log $('#meta_id').val response.meta_id
		cntColl = new Backbone.Collection response.occurrence
		temp = cntColl.filter (model)->
			meta_id = model.get 'meta_id'
			model.set 'meta_id' , parseInt meta_id
			return model
		console.log tempColl = new Backbone.Collection temp
		console.log model = tempColl.findWhere({meta_id:parseInt(response.meta_id)})
		cnt = @getCount(model.get('meta_value'))
		if parseInt(cnt) == 1
			cnt = 0
		$('.bottlecnt').text cnt
		@generate(response.occurrence)

	getCount:(val)->
		count = 0
		if!(_.isArray(val)) 
			count += parseFloat val.qty
		else
			$.each val , (ind,val1)->
				console.log val1
				if _.isArray(val1)
					$.each val1 ,  (item,value)->
						count += parseFloat value.qty
				else
					count += parseFloat val1.qty

		count

	serializeData:->
		data = super()
		arr1 = []
		count = 0
		data.day = moment().format("dddd")
		console.log data.today = moment().format("MMMM Do YYYY")
		data

	onShow:->
			@$el.closest('html').find('head').append('<link rel="stylesheet" href="http://localhost/xooma/wp-content/themes/twentytwelve/xoomaapp/bower_components/ea-vertical-progress/css/style.css">')
			@generate(@model.get('occurrence'))

	generate:(data)->
			console.log  occur = data
			bonus = 0
			count1 = 0
				
			console.log @model.get('occurrence').length
			console.log @model.get('servings')
			bonus = parseInt(@model.get('occurrence').length) - parseInt(@model.get('servings'))
			$('.bonus').text bonus
			$.each occur , (ind,val)=>
				console.log occurrence = _.has(val, "occurrence")
				console.log  expected = _.has(val, "expected")
				meta_id = val.meta_id
				console.log val.meta_value
				count = @getCount(val.meta_value)
				
				if occurrence == true && (expected == true || expected == false) && count ==  1
					count1++
					return true
				else if occurrence == true && (expected == true || expected == false) && count !=  1
					console.log count
					@update_occurrences(val)
					return false
				else
					@create_occurrences()
					return false
			if(parseInt(@model.get('occurrence').length)) == parseInt count1
				@create_occurrences()
				
	create_occurrences:()=>
			$('#meta_id').val(0)
			$('.bottlecnt').text 0
			@bottle = new EAProgressVertical(@$el.find('.bottle'),100,'empty',10000,[25,50,75])

	update_occurrences:(data)->
			$('#add').hide()
			$('#meta_id').val parseInt data.meta_id
			count = 0
			meta_value = data.meta_value
			count = @getCount(data.meta_value)
			confirm = parseFloat(count)/0.25
			$('.bottlecnt').text count
			@bottle = new EAProgressVertical(@$el.find('.bottle'),50,'empty',10000,[25,50,75])
			

	startProgress : =>
		@bottle.startProgress()

	stopProgress : =>
		progress = @bottle.stopProgress(true)
		console.log progress
		@bottle.setProgress(progress)



		
			

				
		
class App.AsperbmiCtrl extends Ajency.RegionController
	initialize : (options = {})->
		productId  = @getParams()
		product = parseInt productId[0]
		products = []
		App.useProductColl.each (val)->
			products.push val
		
		productsColl =  new Backbone.Collection products
		productModel = productsColl.where({id:parseInt(productId[0])})
		@_showView(productModel[0])

	_showView:(productModel)->
		console.log productModel
		@show new AsperbmiView
					model : productModel