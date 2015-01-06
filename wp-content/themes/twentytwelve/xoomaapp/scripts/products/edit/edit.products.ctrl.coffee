
class EditProductsView extends Marionette.ItemView

	template : '#edit-product-template'

	ui :
		schedule : '.schedule'
		servings_diff : 'input[name="servings_diff"]'
		servings_per_day : '.servings_per_day'
		form : '#edit_product'
		reminder_button : '.reminder_button'
		responseMessage : '.aj-response-message'
		cancel			:	'.cancel'
		rangeSliders : '[data-rangeslider]'
		x2o				: 'x2o'
		

	events:
		'change @ui.rangeSliders' : (e)-> @valueOutput e.currentTarget

		'click @ui.cancel':(e)->
			App.navigate '#/profile/my-products', true

		'click @ui.reminder_button':(e)->
			$(@ui.reminder_button).removeClass 'btn-success'
			$(e.target).addClass 'btn-success'
			$('#reminder').val $(e.target).attr('data-reminder')
			html1 = '<div class="reminder">'+$('.reminder').first().html()+'</div>'
			$('.reminder_div').text ""
			$('.reminder_div').append html1
			$('.js__timepicker').each (ind,val)->
				console.log val.name = 'reminder_time'+ind
			$( @ui.servings_per_day ).trigger( "change" );
			

		'click .save':(e)->
			e.preventDefault()
			data = @ui.form.serialize()
			product = @model.get('id')
			$.ajax
				method : 'POST'
				url : "#{_SITEURL}/wp-json/trackers/#{App.currentUser.get('ID')}/products/#{product}"
				data : data
				success : @successSave
				error : @errorSave


		'click .remove':(e)->
			product = parseInt @model.get('id')
			products = App.currentUser.get 'products'
			if $.inArray( product, products ) > -1
				$.ajax
					method : 'DELETE'
					url : "#{_SITEURL}/wp-json/trackers/#{App.currentUser.get('ID')}/products/#{product}"
					success: @successHandler
					error :@erroraHandler

		'click @ui.schedule':(e)->
			$(@ui.schedule).removeClass 'btn-primary'
			$(e.target).addClass 'btn-primary'
			$('#timeset').val $(e.target).attr('data-time')
			if $(e.target).attr('data-time') == 'Once'
				$('.second').hide()

			else
				$('.second').show()

		'click @ui.servings_diff ':(e)->
			if $(@ui.servings_diff).prop('checked') == true
				$(e.target).val '1'
				$('#check').val '1'
				servings = $('.servings_per_day').val()
				html = ""
				i = 1
				while(i <= servings)
					
						html += '<div class="qtyper">'+$('.qtyper').first().html()+'</div>'
						i++
					
				$('.qty_per_servings_div').text ""
				$('.qty_per_servings_div').append html
				$('.qty_per_servings').each (ind,val)->
					val.name = 'qty_per_servings'+ind
					val.id = 'qty_per_servings'+ind
			else
				$(@ui.servings_diff).prop 'val' , 0
				$('#check').val '0'
				html = '<div class="qtyper">'+$('.qtyper').first().html()+'</div>'
				$('.qty_per_servings_div').text ""
				$('.qty_per_servings_div').append html
				$('.qty_per_servings').each (ind,val)->
					val.name = 'qty_per_servings'+ind
					val.id = 'qty_per_servings'+ind
			$('.js__timepicker').pickatime()

		'change @ui.servings_per_day ':(e)->
			if parseInt($(e.target).val()) == 1
				$(@ui.servings_diff).prop 'disabled' , true
				$(@ui.servings_diff).prop 'checked' , false
				$(@ui.servings_diff).prop 'val' , 0
				servings = $('.servings_per_day').val()
				html = '<div class="qtyper">'+$('.qtyper').first().html()+'</div>'
				html1 = '<div class="reminder">'+$('.reminder').first().html()+'</div>'
						
				$('.qty_per_servings_div').text ""
				$('.reminder_div').text ""
				$('.qty_per_servings_div').append html
				$('.reminder_div').append html1
				$('.qty_per_servings').each (ind,val)->
					val.name = 'qty_per_servings'+ind
					val.id = 'qty_per_servings'+ind
				$('.js__timepicker').each (ind,val)->
					val.name = 'reminder_time'+ind

			else if $(@ui.servings_diff).prop('checked') == true 
				$(@ui.servings_diff).prop 'disabled' , false
				servings = $('.servings_per_day').val()
				html = ""
				i = 1
				while(i <= servings)
						html += '<div class="qtyper">'+$('.qtyper').first().html()+'</div>'
						i++
					
				
				$('.qty_per_servings_div').text ""
				$('.qty_per_servings_div').append html
				$('.qty_per_servings').each (ind,val)->
					console.log val.name = 'qty_per_servings'+ind
					val.id = 'qty_per_servings'+ind
				@showReminders()
			
			$('.js__timepicker').pickatime()


		'change .no_of_container':(e)->
			cnt = parseInt($(e.target).val()) * parseInt(@model.get('total'))
			$('#available').val cnt
			$('.available').text cnt


	showReminders:()->
		if parseInt($('#reminder').val()) == 1
				$(@ui.servings_diff).prop 'disabled' , false
				servings = $('.servings_per_day').val()
				html1 = ""
				i = 1
				while(i <= servings)
						html1 += '<div class="reminder">'+$('.reminder').first().html()+'</div>'
						i++
					
				
				$('.reminder_div').text ""
				$('.reminder_div').append html1
				$('.js__timepicker').each (ind,val)->
					val.name = 'reminder_time'+ind



	


	successHandler:(response,status,xhr)=>
		if xhr.status == 200
			products = App.currentUser.get 'products'
			products.remove response
		App.navigate '#/profile/my-products', true

	erroraHandler :(response,status,xhr)=>
		@ui.responseMessage.text "Something went wrong"
		$('html, body').animate({
						scrollTop: 0
						}, 'slow')

	successSave: (response,status,xhr)=>
		if xhr.status is 201
				response = parseInt response
				products = App.currentUser.get 'products'
				if typeof products == 'undefined'
					products = []
				products = _.union products, [response]
				App.currentUser.set 'products', products
		App.navigate '#/profile/my-products', true

	erroraHandler :(response,status,xhr)=>
		@ui.responseMessage.text "Could not delete the prodcut"
		$('html, body').animate({
						scrollTop: 0
						}, 'slow')


	serializeData:->
		data = super()

		if @model.get('time_set') == 'asperbmi'
			qty = @model.get 'qty'
			data.x2o = qty[0].qty
		frequecy = @model.get 'frequency_value'
		if parseInt(frequecy) == 1 
			data.anytime = ''
			data.schedule = 'disabled'
			data.anytimeclass = 'btn-primary'
			data.scheduleclass = ''
		else 
			data.anytime = 'disabled'
			data.schedule = ''
			data.anytimeclass = ''
			data.scheduleclass = 'btn-primary'
			if @model.get('time_set') == 'Once'
				data.once = 'btn-primary'
				data.twice = ''
			else
				data.once = ''
				data.twice = 'btn-primary'
		console.log reminder_flag = @model.get('reminder_flag')
		if reminder_flag == undefined || reminder_flag == 0 || reminder_flag == 'true'
			data.default = 'btn-success'
			data.success = ''
			
		else
			data.default = ''
			data.success = 'btn-success'
			
		
		data

	

	onShow:->
		$('.js__timepicker').pickatime()
		@ui.rangeSliders.each (index, ele)=> @valueOutput ele
		@ui.rangeSliders.rangeslider polyfill: false
		
		if parseInt(@model.get('frequency_value')) == 1 && @model.get('time_set') != 'asperbmi'
			$('.schedule_data').hide()
			$('.asperbmi').hide()
			$('.servings_per_day option[value="'+@model.get('time_set')+'"]').prop("selected",true);
			if parseInt(@model.get('time_set')) == 1
				$(@ui.servings_diff).prop 'disabled' , true
			@showAnytimeData(@model)
		else if parseInt(@model.get('frequency_value')) == 2
			$('.anytime').hide()
			$('.asperbmi').hide()
			
			@showScheduleData(@model)
		else
			$('.schedule_data').hide()
			$('.anytime').hide()
			

		$('#timeset').val @model.get 'time_set'
		container = @model.get('no_of_container')
		reminder_flag = @model.get('reminder_flag')
		$('#reminder').val reminder_flag
		$('.no_of_container option[value="'+container+'"]').prop("selected",true);
		# $( @ui.servings_per_day ).trigger( "change" );
		

		product = parseInt @model.get('id')
		products = App.currentUser.get 'products'
		if $.inArray( product, products ) == -1
			$('.remove').hide()

	valueOutput : (element) =>
		$(element).parent().find("output").html $(element).val()
		

	showScheduleData:(model)->
		product = parseInt model.get('id')
		products = App.currentUser.get 'products'
		if $.inArray( product, products ) > -1
			@showEditScheduleData(model)
		else
			@showAddScheduleData(model)
		
			


	showAddScheduleData:(model)->
		if @model.get('time_set') == 'Once'
				$('.second').hide()
				qty = @model.get('serving_size').split('|')
				whendata = @model.get('when').split('|')
				$('.qty0 option[value="'+qty[0]+'"]').prop("selected",true)
				$('.when0 option[value="'+whendata[0]+'"]').prop("selected",true)
				
		else
			qty = @model.get('serving_size').split('|')
			whendata = @model.get('when').split('|')
			$('.qty0 option[value="'+qty[0]+'"]').prop("selected",true)
			$('.when0 option[value="'+whendata[0]+'"]').prop("selected",true)
			$('.qty1 option[value="'+qty[1]+'"]').prop("selected",true)
			$('.when1 option[value="'+whendata[1]+'"]').prop("selected",true)

	showEditScheduleData:(model)->
		console.log qty = model.get 'qty'
		if @model.get('time_set') == 'Once'
			$('.second').hide()
			$('.qty0 option[value="'+qty[0].qty+'"]').prop("selected",true)
			$('.when0 option[value="'+qty[0].when+'"]').prop("selected",true)
		
			
		else
			$('.qty0 option[value="'+qty[0].qty+'"]').prop("selected",true)
			$('.when0 option[value="'+qty[0].when+'"]').prop("selected",true)
			$('.qty1 option[value="'+qty[1].qty+'"]').prop("selected",true)
			$('.when1 option[value="'+qty[1].when+'"]').prop("selected",true)

		

	showAnytimeData:(model)->
		product = parseInt model.get('id')
		products = App.currentUser.get 'products'
		if $.inArray( product, products ) > -1
			@showServings(model)
			
		else
			qty = model.get('serving_size').split('|')
			$('.qty_per_servings option[value="'+qty[0]+'"]').prop("selected",true)
			

	showServings:(model)->
		qty = model.get 'qty'
		if parseInt(model.get('check')) == 1
			$(@ui.servings_diff).prop('checked' ,true)
			$( @ui.servings_per_day ).trigger( "change" )
			$('#check').val(1)
			$.each qty , (ind,val)->
				$('#qty_per_servings'+ind+' option[value="'+val.qty+'"]').prop("selected",true)
		else
			$('#qty_per_servings0 option[value="'+qty[0].qty+'"]').prop("selected",true)
					

			

		
	


class App.EditProductsCtrl extends Ajency.RegionController
	initialize : (options = {})->
		productId  = @getParams()
		console.log product = parseInt productId[0]
		console.log products = App.currentUser.get 'products'
		
		if $.inArray( product, products ) > -1
			$.ajax
				method : 'GET'
				url : "#{_SITEURL}/wp-json/trackers/#{App.currentUser.get('ID')}/products/#{product}"
				success: @successHandler
				error :@erroraHandler
		else 
			productModel = App.productCollection.where({id:productId[0]})
			@_showView(productModel[0])
		


	_showView:(productModel)->
		console.log productModel
		@show new EditProductsView
					model : productModel


	successHandler:(response,status,xhr)=>
		pid = App.productCollection.where({id:response.id})
		model = new Backbone.Model response
		@_showView(model)



	