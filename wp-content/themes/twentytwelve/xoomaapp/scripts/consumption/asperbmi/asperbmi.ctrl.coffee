App.state 'Asperbmi',
					url : '/products/:id/bmi'
					parent : 'xooma'

			
class AsperbmiView extends Marionette.ItemView

	template : '#asperbmi-template'

	ui :
		responseMessage : '.aj-response-message'


	events:
		'click #confirm':(e)->
			e.preventDefault()
			meta_id = @$el.find('#meta_id').val()
			qty = ( @originalBottleRemaining - @bottleRemaining ) / 100
			if qty is 0
			  return
			product = @model.get('id')
			date = moment().format('YYYY-MM-DD')
			$.ajax
						method : 'POST'
						data : 'meta_id='+meta_id+'&qty='+qty+'&date='+date
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
		console.log response
		occurResponse = _.map response.occurrence, (occurrence)->
			occurrence.meta_id = parseInt occurrence.meta_id
			occurrence
		@model.set 'occurrence' , occurResponse
		console.log @$el.find('#meta_id').val response.meta_id		
		tempColl = new Backbone.Collection occurResponse
		model = tempColl.findWhere
			meta_id : parseInt response.meta_id

		cnt = @getCount model.get 'meta_value'
		@originalBottleRemaining = @bottleRemaining
		if parseInt(cnt) is 1
			cnt = 0
		$('.bottlecnt').text cnt
		# @generate(response.occurrence)

	getCount:(val)->
		count = 0
		if!(_.isArray(val)) 
			count += parseFloat val.qty
		else
			_.each val , (val1)->
				console.log val1
				if _.isArray(val1)
					_.each val1 ,  (value)->
						count += parseFloat value.qty
				else
					count += parseFloat val1.qty

		count

	serializeData:->
		data = super()
		arr1 = []
		count = 0
		data.day = moment().format("dddd")
		data.today = moment().format("MMMM Do YYYY")
		data

	onShow:->
			@generate(@model.get('occurrence'))

	generate:(data)->
			occur = data
			bonus = 0
			count1 = 0
				
			# console.log @model.get('occurrence').length
			# console.log @model.get('servings')
			bonus = parseInt(@model.get('occurrence').length) - parseInt(@model.get('servings'))
			$('.bonus').text bonus
			_.each occur , (val)=>
				occurrence = _.has(val, "occurrence")
				expected = _.has(val, "expected")
				meta_id = val.meta_id
				# console.log val.meta_value
				count = @getCount(val.meta_value)
				
				if occurrence == true && (expected == true || expected == false) && count ==  1
					count1++
					return true
				else if occurrence == true && (expected == true || expected == false) && count !=  1
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
			@originalBottleRemaining = 100
			@bottleRemaining = 100
			@bottle = new EAProgressVertical(@$el.find('.bottle'),@bottleRemaining,'empty',10000,[25,50,75])

	update_occurrences:(data)->
			$('#add').hide()
			$('#meta_id').val parseInt data.meta_id
			count = 0
			meta_value = data.meta_value
			count = @getCount(data.meta_value)
			$('.bottlecnt').text count
			@bottleRemaining = 100 - 100*count
			@originalBottleRemaining = @bottleRemaining 
			@bottle = new EAProgressVertical(@$el.find('.bottle'),@bottleRemaining,'empty',10000,[25,50,75])
			

	startProgress : =>
		@bottle.startProgress()

	stopProgress : =>
		progress = @bottle.stopProgress(true)
		console.log progress
		@bottle.setProgress(progress)
		@bottleRemaining = progress



		
			

				
		
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