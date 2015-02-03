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
				e.preventDefault()
				meta_id = $('#meta_id').val()
				qty = @ui.qty.val()
				data = $('#schduleid').val()
				product = @model.get('id')
				date = $('#date').val()
				t = $('#consume_time').val()
				date = moment().format('YYYY-MM-DD')
				time  = moment(t,"HH:mm a").format("HH:mm:ss")
				if t == ""
					time  = moment().format("HH:mm:ss")
				
				$.ajax
						method : 'POST'
						data : 'meta_id='+meta_id+'&qty='+qty+'&date='+date+'&time='+time
						url : "#{_SITEURL}/wp-json/intakes/#{App.currentUser.get('ID')}/products/#{product}"
						success: @saveHandler
						error :@erroraHandler


		

		
			

		'click .update':(e)->
			e.preventDefault()
			meta_id = $('#meta_id').val()
			qty = $('#qty').val()
			data = $('#schduleid').val()
			product = @model.get('id')
			$.ajax
					method : 'POST'
					data : 'meta_id='+meta_id+'&qty='+qty
					url : "#{_SITEURL}/wp-json/intakes/#{App.currentUser.get('ID')}/products/#{product}"
					success: @saveHandler
					error :@erroraHandler
			

	saveHandler:(response,status,xhr)=>
		@model.set 'occurrence' , response.occurrence
		App.navigate "#/home" , true
		
		

	onShow:->
		date  = Marionette.getOption( @, 'date')
		$('#date').val date
		$('.js__timepicker').pickatime(
			interval: 15
			onSet : (context)->

				$('.now').text $('#consume_time').val()
			

			 

		)
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

		$.each temp , (ind,val)->
			occurrence = _.has(val, "occurrence")
			expected = _.has(val, "expected")
			if occurrence == false && expected == true
				console.log qty[ind].qty
				ScheduleView::create_occurrences(qty[ind].qty)
				data.qty = qty[ind].qty
				return false
				
		data.product_type = product_type
		data


	create_occurrences:(val)->
		$('#meta_id').val 0
		$('#qty').val val.qty

	update_occurrences:(meta_id,qty)->
		if meta_id == ""
			meta_id = 0
		$('#meta_id').val parseInt meta_id
		$('#qty').val qty
			


						


		
class App.ScheduleCtrl extends Ajency.RegionController
	initialize : (options = {})->
		console.log productId  = @getParams()
		product = 3
		date = '2015-02-04'
		products = []
		App.useProductColl.each (val)->
			products.push val
		
		productsColl =  new Backbone.Collection products
		productModel = productsColl.where({id:parseInt(product)})
		@_showView(productModel[0],date)


	successHandler:(response,status,xhr)=>
		model = new Backbone.Model response
		@_showView(model)
		

	_showView:(productModel,date)->
		@show new ScheduleView
					model : productModel
					date : date