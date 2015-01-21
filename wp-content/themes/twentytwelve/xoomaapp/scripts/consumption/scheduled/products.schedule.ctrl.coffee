App.state 'Schedule',
					url : '/products/:id/consume'
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

	events:
		'click @ui.servings':(e)->
			e.preventDefault()
			console.log meta_id  = $(e.target).parent().attr 'data-value'
			console.log qty  = $(e.target).parent().attr 'data-qty'
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
				e.preventDefault()
				meta_id = $('#meta_id').val()
				qty = $('#qty').val()
				console.log data = $('#schduleid').val()
				product = @model.get('id')
				$.ajax
						method : 'POST'
						data : 'meta_id='+meta_id+'&qty='+qty+'&date=2015-12-11'
						url : "#{_SITEURL}/wp-json/intakes/#{App.currentUser.get('ID')}/products/#{product}"
						success: @saveHandler
						error :@erroraHandler


		'click @ui.cancel':(e)->
			$('#qty').val ""
			$('#mydataModal').addClass "hidden"

		
			

		'click .update':(e)->
			e.preventDefault()
			meta_id = $('#meta_id').val()
			qty = $('#qty').val()
			console.log data = $('#schduleid').val()
			product = @model.get('id')
			$.ajax
					method : 'POST'
					data : 'meta_id='+meta_id+'&qty='+qty
					url : "#{_SITEURL}/wp-json/intakes/#{App.currentUser.get('ID')}/products/#{product}"
					success: @saveHandler
					error :@erroraHandler
			

	saveHandler:(response,status,xhr)=>
		@model.set 'occurrence' , response.occurrence
		@ui.responseMessage.text "Servings are updated!!!!"
		$('#mydataModal').addClass "hidden"





	serializeData:->
		data = super()
		data.day = moment().format("dddd")
		data.today = moment().format("MMMM Do YYYY")
		qty = @model.get 'qty'
		occurr = @model.get('occurrence')
		product_type = @model.get('product_type')
		product_type = product_type.toLowerCase()
		no_servings  = []
		temp = []
		bonus = parseInt(@model.get('occurrence').length) - parseInt(qty.length)
		$.each occurr , (ind,val)->
			if qty[ind] != undefined
				temp.push val

		$.each temp , (ind,val)->
			occurrence = _.has(val, "occurrence")
			expected = _.has(val, "expected")
			if occurrence == true && expected == true
				newClass = product_type+'_occurred_class'
				
			else if occurrence == false && expected == true
				newClass = product_type+'_expected_class'
				
			else if occurrence == true && expected == false
				newClass = product_type+'_bonus_class'
				
				

			i = 0
			
			servings = []
			while(i < qty[ind].qty)
					servings.push newClass : newClass 
					i++
			no_servings.push servings : servings , schedule : val.schedule_id , meta_id : val.meta_id ,qty : qty[ind].qty
			data.no_servings =  no_servings
		
		data.original = product_type+'_expected_class'
		data.bonus = bonus
		data


	create_occurrences:(val)->
		console.log val.qty
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
		App.useProductColl.each (val)->
			products.push val
		
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