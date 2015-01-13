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

	events:
		'click @ui.servings':(e)->
			e.preventDefault()
			console.log meta_id  = $(e.target).parent().attr 'data-value'
			if meta_id == ""
				meta_id = 0
			$('#meta_id').val parseInt meta_id

		'click @ui.intake':(e)->
			e.preventDefault()
			meta_id = $('#meta_id').val()
			console.log data = $('#schduleid').val()
			product = @model.get('id')
			
			$.ajax
				method : 'POST'
				data : 'meta_id='+meta_id
				url : "#{_SITEURL}/wp-json/intakes/#{App.currentUser.get('ID')}/products/#{product}"
				success: @successHandler
				error :@erroraHandler

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
		$.each qty , (ind,val)->
			console.log occurrence = _.has(occurr[ind], "occurrence")
			console.log occurr[ind].meta_id
			console.log expected = _.has(occurr[ind], "expected")
			if occurrence == true && expected == true
				console.log newClass = product_type+'_occurred_class'
				
			else if occurrence == false && expected == true
				console.log newClass = product_type+'_expected_class'
			else if occurrence == true && expected == false
				console.log newClass = product_type+'_bonus_class'
				

			i = 0
			
			servings = []
			while(i < val.qty)
				servings.push newClass : newClass 
				i++
			no_servings.push servings : servings , schedule : occurr[ind].schedule_id , meta_id : occurr[ind].meta_id
			data.no_servings =  no_servings
		
		data.original = product_type+'_expected_class'
		data.scheduleid = occurr[0].schedule_id
		data
						


		
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