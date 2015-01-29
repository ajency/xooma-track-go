App.state 'EditProducts',
					url : '/product/:id/edit'
					parent : 'xooma'
	
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
		subtract		: 'input[name="subtract"]'
		

	events:
		'click .save_another':(e)->
			e.preventDefault()
			$('.save').trigger( "click" )

		'keypress @ui.subtract':(e)->
			e.charCode >= 48 && e.charCode <= 57 ||	e.charCode == 44 

		'change @ui.rangeSliders' : (e)-> 
			$('.servings_per_day').val $(e.target).val()
			@valueOutput e.currentTarget
			@showReminders()

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
				val.name = 'reminder_time'+ind
				val.id = 'reminder_time'+ind
			#$( @ui.servings_per_day ).trigger( "change" )
			if parseInt(@model.get('frequency_value')) == 2
				@selectSchdule(@model)
			@showReminders()

		'click .save':(e)->
			e.preventDefault()
			check = @checkreminder()
			if check == false
				@ui.responseMessage.addClass('alert alert-danger').text("Reminders data not saved!")
				$('html, body').animate({
							scrollTop: 0
							}, 'slow')
				return 
			sub = @ui.subtract.val()
			if sub == ""
				sub = 0
			if parseInt($('#available').val()) >=  parseInt(sub) 
				data = @ui.form.serialize()
				product = @model.get('id')
				$.ajax
					method : 'POST'
					url : "#{_SITEURL}/wp-json/trackers/#{App.currentUser.get('ID')}/products/#{product}"
					data : data
					success : @successSave
					error : @errorSave
			else
				@ui.responseMessage.addClass('alert alert-danger').text("Value entered shoule be less than available count!")
				$('html, body').animate({
							scrollTop: 0
							}, 'slow')


		

		'click @ui.schedule':(e)->
			$(@ui.schedule).removeClass 'btn-primary'
			$(e.target).addClass 'btn-primary'
			$('#timeset').val $(e.target).attr('data-time')
			if $(e.target).attr('data-time') == 'Once'
				$('.second').hide()
			else
				$('.second').show()
			
			@selectSchdule(@model)	
			@showReminders()
			

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
			# $( @ui.servings_per_day ).trigger( "change" )
			

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
					val.id = 'reminder_time'+ind

			else
				$(@ui.servings_diff).prop 'disabled' , false
				@showReminders()
				
			@loadCheckedData()
			$('.js__timepicker').pickatime()


		'change .no_of_container':(e)->
			cnt = parseInt($(e.target).val()) * parseInt(@model.get('total'))
			$('#available').val cnt
			$('.available').text cnt

	checkreminder:->
		servings = $('.servings_per_day').val()
		i = 0
		while i < servings
			if $('#reminder_time'+i).val() == "" && parseInt($('#reminder').val()) == 1
				return false
			i++
		

	loadCheckedData:()->
		if $(@ui.servings_diff).prop('checked') == true 
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
					val.name = 'qty_per_servings'+ind
					val.id = 'qty_per_servings'+ind
				@showReminders()

	selectSchdule:(model)->
		if $('#timeset').val() == 'Once'
			$('.servings_per_day option[value="1"]').prop("selected",true)

		else
			$('.servings_per_day option[value="2"]').prop("selected",true)
			

	showReminders:()->
		if parseInt($('#reminder').val()) == 1
				$(@ui.servings_diff).prop 'disabled' , false
				$('#reminder_time0').removeAttr 'disabled'
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
					val.id = 'reminder_time'+ind
				
		else
			$('#reminder_time0').attr 'disabled' , true			
			
			html1 = '<div class="reminder">'+$('.reminder').first().html()+'</div>'
			$('#reminder_time0').attr 'disabled' , true			
			$('.reminder_div').text ""
			$('.reminder_div').append html1
			$('.js__timepicker').each (ind,val)->
				val.name = 'reminder_time'+ind
				val.id = 'reminder_time'+ind
				val.value = ""

		$('.js__timepicker').pickatime()



	


	successSave: (response,status,xhr)=>
		if xhr.status is 201
				product = parseInt response.response[0].id
				products = App.currentUser.get 'products'
				if typeof products == 'undefined'
					products = []
				products = _.union products, [product]
				App.currentUser.set 'products', _.uniq products
				model = new UserProductModel 
				model.set response.response[0]
				App.useProductColl.add model , {merge: true}
		if document.activeElement.name == "save"
			App.navigate '#/profile/my-products', true
		else
			App.navigate '#/products', true


	errorSave :(response,status,xhr)=>
		@ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be saved due to some error!")
		$('html, body').animate({
						scrollTop: 0
						}, 'slow')


	serializeData:->
		data = super()
		product = parseInt @model.get('id')
		weightbmi = @get_weight_bmi(@model.get('bmi'))
		data.x2o = Math.ceil(weightbmi)	
		data.defaultbmi = Math.ceil(weightbmi)
		products = App.currentUser.get 'products'
		if @model.get('time_set') == 'asperbmi' &&  @model.get('qty') != undefined
			qty = @model.get 'qty'
			reminders = @model.get 'reminders'
			data.defaultbmi = qty.length
			data.reminder = reminders[0].time
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
			reminder_flag = @model.get('reminder_flag')
		if reminder_flag == undefined || parseInt(reminder_flag) == 0 || reminder_flag == 'true'
			data.default = 'btn-success'
			data.success = ''
			
		else
			data.default = ''
			data.success = 'btn-success'
			
		
		data

	get_weight_bmi:(bmi)->
		weight = App.currentUser.get('weight')
		actual = 1
		if bmi != undefined	
			$.each bmi , (index,value)->
				bmi_val  = value['range'].split('<')
				if parseInt(bmi_val[0]) <= parseInt(weight) && parseInt(weight) <= parseInt(bmi_val[1])
					actual = value['quantity'];
		actual


	

	onShow:->
		@checkMode()
		$('.js__timepicker').pickatime()
		@ui.rangeSliders.each (index, ele)=> @valueOutput ele
		@ui.rangeSliders.rangeslider polyfill: false
		$('#timeset').val @model.get 'time_set'
		container = @model.get('no_of_container')
		reminder_flag = @model.get('reminder_flag')
		$('#reminder').val reminder_flag
		$('.no_of_container option[value="'+container+'"]').prop("selected",true)
		if parseInt(@model.get('frequency_value')) == 1 && @model.get('time_set') != 'asperbmi'
			$('.schedule_data').remove()
			$('.asperbmi').hide()
			$('.servings_per_day option[value="'+@model.get('time_set')+'"]').prop("selected",true);
			if parseInt(@model.get('time_set')) == 1
				$(@ui.servings_diff).prop 'disabled' , true
			
			$( @ui.servings_per_day ).trigger( "change" )
			@showAnytimeData(@model)
		else if parseInt(@model.get('frequency_value')) == 2
			$('.anytime').hide()
			$('.asperbmi').hide()
			$('#check').val '1'
			@selectSchdule(@model)	
			@showReminders()
			@showScheduleData(@model)
		else
			$('.schedule_data').hide()
			$('.anytime').hide()
			if @model.get('bmi') != undefined
				weightbmi = @get_weight_bmi(@model.get('bmi'))
				weight = Math.ceil(weightbmi)
			else
				qty = @model.get 'qty'
				weight = qty.length
			$('.servings_per_day option[value="'+weight+'"]').prop("selected",true);
			@showReminders()

		
		
		

		product = parseInt @model.get('id')
		products = App.currentUser.get 'products'
		if $.inArray( product, products ) == -1
			$('.remove').hide()

	checkMode:()->
		product = parseInt @model.get('id')
		products = App.currentUser.get 'products'
		if $.inArray( product, products ) == -1
			$('.save').text "Add"
			$('.save_another').removeClass 'hidden'
			$('.save_another').text 'Add & Choose another'
		else
			$('.noofcontainer').hide()
			$('.view').removeClass 'hidden'

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
		qty = @model.get('serving_size').split('|')
		whendata = @model.get('when').split('|')
		$('.qty0 option[value="'+qty[0]+'"]').prop("selected",true)
		$('.when0 option[value="'+whendata[0]+'"]').prop("selected",true)
			
		if @model.get('time_set') == 'Once'
			$('.second').hide()
			
				
		else
			$('.qty1 option[value="'+qty[1]+'"]').prop("selected",true)
			$('.when1 option[value="'+whendata[1]+'"]').prop("selected",true)
			
	showEditScheduleData:(model)->
		qty = model.get 'qty'
		reminders = model.get 'reminders'
		$('.qty0 option[value="'+qty[0].qty+'"]').prop("selected",true)
		$('.when0 option[value="'+qty[0].when+'"]').prop("selected",true)
		reminder = reminders[0].time
		$('#reminder_time0').val reminder
		if @model.get('time_set') == 'Once'
			$('.second').hide()
			
		else
			$('.qty1 option[value="'+qty[1].qty+'"]').prop("selected",true)
			$('.when1 option[value="'+qty[1].when+'"]').prop("selected",true)
			reminder = reminders[1].time
			$('#reminder_time1').val reminder
			

		

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
		reminders = model.get 'reminders'
		if parseInt(model.get('check')) == 1
			$(@ui.servings_diff).prop('checked' ,true)
			$( @ui.servings_per_day ).trigger( "change" )
			$('#check').val(1)
			$.each qty , (ind,val)->
				$('#qty_per_servings'+ind+' option[value="'+val.qty+'"]').prop("selected",true)
				



		else
			$('#qty_per_servings0 option[value="'+qty[0].qty+'"]').prop("selected",true)
		$.each reminders , (ind,val)->
			$('#reminder_time'+ind).val val.time
		
			

			

		
	


class App.EditProductsCtrl extends Ajency.RegionController
	initialize : (options = {})->
		@show @parent().getLLoadingView()
		productId  = @getParams()
		product = parseInt productId[0]
		products = App.currentUser.get 'products'
		
		if $.inArray( product, products ) > -1 || App.productCollection.length == 0
			$.ajax
				method : 'GET'
				url : "#{_SITEURL}/wp-json/trackers/#{App.currentUser.get('ID')}/products/#{product}"
				success: @successHandler
				error :@erroraHandler
		else 
			productModel = App.productCollection.where({id:productId[0]})
			@_showView(productModel[0])
		


	_showView:(productModel)->
		@show new EditProductsView
					model : productModel


	successHandler:(response,status,xhr)=>
		if xhr.status == 200
			pid = App.productCollection.where({id:response.id})
			model = new Backbone.Model response
			@_showView(model)
		else
			@region =  new Marionette.Region el : '#edit-product-template'
			new Ajency.NothingFoundCtrl region : @region

	erroraHandler:(response,status,xhr)=>
		@region =  new Marionette.Region el : '#404-template'
		new Ajency.HTTPRequestCtrl region : @region
