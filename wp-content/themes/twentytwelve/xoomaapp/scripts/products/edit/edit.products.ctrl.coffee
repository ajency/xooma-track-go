
class EditProductsView extends Marionette.ItemView

	template : '#edit-product-template'

	ui :
		schedule : '.schedule'
		servings_diff : 'input[name="servings_diff"]'
		servings_per_day : '.servings_per_day'
		form : '#edit_product'
		reminder_button : '.reminder_button'
		responseMessage : '.aj-response-message'

	events:
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
			
			console.log product = @model.get('id')
			$.ajax
				method : 'POST'
				url : "#{_SITEURL}/wp-json/trackers/#{App.currentUser.get('ID')}/products/#{product}"
				data : data
				success : @successSave
				error : @errorSave


		'click .remove':(e)->
			console.log product = @model.get('id')
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
			$('#time_set').val $(e.target).attr('data-time')
			if $(e.target).attr('data-time') == 'Once'
				$('.second').hide()

			else
				$('.second').show()

		'click @ui.servings_diff ':(e)->
			console.log $(@ui.servings_diff).prop('checked')
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
					console.log val.name = 'qty_per_servings'+ind
					val.id = 'qty_per_servings'+ind
			else
				$(@ui.servings_diff).prop 'val' , 0
				$('#check').val '0'
				html = '<div class="qtyper">'+$('.qtyper').first().html()+'</div>'
				$('.qty_per_servings_div').text ""
				$('.qty_per_servings_div').append html
				$('.qty_per_servings').each (ind,val)->
					console.log val.name = 'qty_per_servings'+ind
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
					console.log val.name = 'qty_per_servings'+ind
					val.id = 'qty_per_servings'+ind
				$('.js__timepicker').each (ind,val)->
					console.log val.name = 'reminder_time'+ind

			else if $(@ui.servings_diff).prop('checked') == true 
				$(@ui.servings_diff).prop 'disabled' , false
				console.log servings = $('.servings_per_day').val()
				html = ""
				i = 1
				while(i <= servings)
						console.log  $('.qtyper').first().html()
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
			console.log @model.get('total')
			cnt = parseInt($(e.target).val()) * parseInt(@model.get('total'))
			$('#available').val cnt
			$('.available').text cnt


	showReminders:()->
		if parseInt($('#reminder').val()) == 1
				$(@ui.servings_diff).prop 'disabled' , false
				console.log servings = $('.servings_per_day').val()
				html1 = ""
				i = 1
				while(i <= servings)
						html1 += '<div class="reminder">'+$('.reminder').first().html()+'</div>'
						i++
					
				
				$('.reminder_div').text ""
				$('.reminder_div').append html1
				$('.js__timepicker').each (ind,val)->
					console.log val.name = 'reminder_time'+ind



	


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
		console.log frequecy = @model.get 'frequency_value'
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
			$('#reminder').val 0
		else
			data.default = ''
			data.success = 'btn-success'
			$('#reminder').val 1
		data

	

	onShow:->
		$('.js__timepicker').pickatime()
		if parseInt(@model.get('frequency_value')) == 1 && @model.get('time_set') != 'asperbmi'
			$('.schedule').hide()
			$('.asperbmi').hide()
			$('.servings_per_day option[value="'+@model.get('time_set')+'"]').prop("selected",true);
			if parseInt(@model.get('time_set')) == 1
				console.log @ui.servings_diff
				$(@ui.servings_diff).prop 'disabled' , true
			@showAnytimeData(@model)
		else if parseInt(@model.get('frequency_value')) == 2
			$('.anytime').hide()
			$('.asperbmi').hide()
			if @model.get('time_set') == 'Once'
				$('.second').hide()
				qty = @model.get('serving_size').split('|')
				whendata = @model.get('when').split('|')
				$('.qty1 option[value="'+qty[0]+'"]').attr("selected","selected")
				$('.when1 option[value="'+whendata[0]+'"]').attr("selected","selected")
				
			else
				qty = @model.get('serving_size').split('|')
				whendata = @model.get('when').split('|')
				$('.qty1 option[value="'+qty[0]+'"]').attr("selected","selected")
				$('.when1 option[value="'+whendata[0]+'"]').attr("selected","selected")
				$('.qty2 option[value="'+qty[1]+'"]').attr("selected","selected")
				$('.when2 option[value="'+whendata[1]+'"]').attr("selected","selected")

		else
			$('.schedule').hide()
			$('.anytime').hide()
		container = @model.get('no_of_container')
		container = container == undefined ? 1 : @model.get('no_of_container')
		reminder_flag = @model.get('reminder_flag')
		reminder_flag = reminder_flag == undefined ? 0 : @model.get('reminder_flag')
		$('#reminder').val reminder_flag
		$('.no_of_container option[value="'+container+'"]').attr("selected","selected");
		# $( @ui.servings_per_day ).trigger( "change" );
		$('#time_set').val @model.get 'time_set'
		

	showAnytimeData:(model)->
		console.log product = model.get('id')
		console.log products = App.currentUser.get 'products'
		console.log $.inArray( product, products )
		if $.inArray( product, products ) == -1
			qty = model.get('serving_size').split('|')
			$('.qty_per_servings option[value="'+qty[0]+'"]').attr("selected","selected");
			
		else
			@showServings(model)
			

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
		products = App.currentUser.get 'products'
		console.log $.inArray( product, products )
		if $.inArray( product, products ) > -1
			$.ajax
				method : 'GET'
				url : "#{_SITEURL}/wp-json/trackers/#{App.currentUser.get('ID')}/products/#{product}"
				success: @successHandler
				error :@erroraHandler
		else 
			console.log productModel = App.productCollection.where({id:productId[0]})
			@_showView(productModel[0])
		


	_showView:(productModel)->
		@show new EditProductsView
					model : productModel


	successHandler:(response,status,xhr)=>
		console.log pid = App.productCollection.where({id:response.id})
		console.log model = new Backbone.Model response
		@_showView(model)



	