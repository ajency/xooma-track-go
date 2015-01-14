App.state 'Schedule',
					url : '/products/:id/consume'
					parent : 'xooma'

class ScheduleView extends Marionette.ItemView

	template : '#schedule-template'

	ui :
		intake : '.intake'
		form 	: '#consume'
		scheduleid : 'input[name="scheduleid"]'
		servings : '.servings'
		responseMessage : '.aj-response-message'

	events:
		'click @ui.servings':(e)->
			e.preventDefault()
			console.log meta_id  = $(e.target).parent().attr 'data-value'
			console.log qty  = $(e.target).parent().attr 'data-qty'
			
			ScheduleView::update_occurrences(meta_id,qty)
			
			

		'click @ui.intake':(e)->
			occurr = @model.get('occurrence').length
			i = 0
			$.each occurr , (ind,val)->
				occurrence = _.has(val, "occurrence")
				expected = _.has(val, "expected")
				if occurrence == true && expected == true
					i++
				
			e.preventDefault()
			meta_id = $('#meta_id').val()
			qty = $('#qty').val()
			console.log data = $('#schduleid').val()
			product = @model.get('id')
			if parseInt(i) < parseInt(occurr)
				$.ajax
					method : 'POST'
					data : 'meta_id='+meta_id+'&qty='+qty
					url : "#{_SITEURL}/wp-json/intakes/#{App.currentUser.get('ID')}/products/#{product}"
					success: @successHandler
					error :@erroraHandler
			else
				@ui.responseMessage.text "Servings are done!!!!"

	@successHandler:(response,status,xhr)=>
		console.log response



	serializeData:->
		data = super()
		console.log data.day = moment().format("dddd")
		console.log data.today = moment().format("MMMM Do YYYY")
		qty = @model.get 'qty'
		occurr = @model.get('occurrence')
		product_type = @model.get('product_type')
		product_type = product_type.toLowerCase()
		no_servings  = []
		$.each occurr , (ind,val)->
			console.log occurrence = _.has(val, "occurrence")
			console.log occurr[ind].meta_id
			console.log expected = _.has(val, "expected")
			if occurrence == true && expected == true
				console.log newClass = product_type+'_occurred_class'
				
			else if occurrence == false && expected == true
				console.log newClass = product_type+'_expected_class'
				ScheduleView::create_occurrences(val);
			else if occurrence == true && expected == false
				console.log newClass = product_type+'_bonus_class'
				

			i = 0
			
			servings = []
			while(i < qty[ind].qty)
				servings.push newClass : newClass 
				i++
			no_servings.push servings : servings , schedule : val.schedule_id , meta_id : val.meta_id ,qty : qty[ind].qty
			data.no_servings =  no_servings
		
		data.original = product_type+'_expected_class'
		data


	create_occurrences:(val)->
		console.log val
		$('#meta_id').val 0
		$('#qty').val val.qty

	update_occurrences:(meta_id,qty)->
		if meta_id == ""
			meta_id = 0
		$('#meta_id').val parseInt meta_id
		$('#qty').val qty
			


						


		
class App.ScheduleCtrl extends Ajency.RegionController
	initialize : (options = {})->
		productId  = @getParams()
		product = parseInt productId[0]
		products = []
		App.homexProductsColl.each (val)->
			$.each val.get('products') , (index,value)->
						products.push value
		
		productsColl =  new Backbone.Collection products
		productModel = productsColl.where({id:parseInt(productId[0])})
		@_showView(productModel[0])


	successHandler:(response,status,xhr)=>
		model = new Backbone.Model response
		@_showView(model)
		

	_showView:(productModel)->
		console.log productModel
		@show new ScheduleView
					model : productModel