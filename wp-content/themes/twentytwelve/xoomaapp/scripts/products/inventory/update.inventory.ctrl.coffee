App.state 'EditInventory',
					url : '/inventory/:id/edit'
					parent : 'xooma'
	

class EditInventoryView extends Marionette.ItemView

	class : 'animated fadeIn'

	template : '#update-inventory-template'

	ui :
		containers : '#containers'
		save		: '.save'
		subtract		: 'input[name="subtract"]'
		responseMessage : '.aj-response-message'
		form : '#inventory'
		view : '.view'
		container_label : '#container_label'
		newsum :'.newsum'
		ntotal :'.ntotal'
		ncon   : '.ncon'
		nequalto : '.nequalto'
		rangeSliders : '[data-rangeslider]'
		navail		 : '.navail'
		nadd 		 : '.nadd'
		nsub		 : '.nsub'
		finaladd 		: '.finaladd'
		eqa 		: '.eqa'
		entry 		: '.entry'
		record       : 'input[name="record"]'

	events:
		'click @ui.entry':(e)->
			@ui.entry.removeClass 'btn-primary'
			$(e.target).removeClass 'btn-default'
			$(e.target).addClass 'btn-primary'
			$('#subtract').val $(e.target).val()
			@ui.rangeSliders.val(0)
			@ui.rangeSliders.parent().find("output").html 0	
			@ui.save.hide()
			if $(e.target).val() == 'adjust'
				$('.record_new').hide()
				$('.record').hide()
				@adjustValue()
				@ui.containers.val()
				$('#slider').removeAttr('disabled')
				$('.rangeslider').removeClass('rangeslider--disabled')
				
			else
				$('.record_new').show()
				$('.record').show()
				@ui.containers.val(0)
				$( @ui.containers ).trigger( "change" )
				

				
		'change @ui.rangeSliders' : (e)-> 
			@valueOutput e.currentTarget
			console.log $('#subtract').val()
			if $('#subtract').val() == 'adjust'
				@adjustValue()
			else
				$( @ui.containers ).trigger( "change" )

		'change @ui.containers':(e)->
			if parseInt($(e.target).val()) != 0 
				$('#slider').removeAttr('disabled')
				$('.rangeslider').removeClass('rangeslider--disabled')
				@ui.save.show()
			else
				@ui.rangeSliders.val(0)
				@ui.rangeSliders.parent().find("output").html $(e.target).val()
				$('#slider').attr('disabled',true)
				$('.rangeslider').addClass('rangeslider--disabled')
				@ui.save.hide()
			available = @model.get 'available'
			total = @model.get 'total'
			@ui.ntotal.text total
			containers = parseInt(available)/parseInt(total)
			console.log contacount = Math.ceil containers
			console.log count = parseInt($(e.target).val()) + parseInt(contacount)
			@ui.ncon.text $(e.target).val()
			equalto = parseInt($(e.target).val()) * parseInt(total)
			@ui.nequalto.text equalto
			@ui.navail.text available
			@ui.nadd.text equalto
			if @ui.rangeSliders.val() < 0 
				$('.sign').text '-'
				eqt = parseInt(available) + parseInt(equalto) - parseInt(Math.abs(@ui.rangeSliders.val()))
			
			else
				$('.sign').text '+'
				eqt = parseInt(available) + parseInt(equalto) + parseInt(Math.abs(@ui.rangeSliders.val()))
			
			@ui.nsub.text Math.abs(@ui.rangeSliders.val())
			@ui.eqa.text eqt
			@ui.newsum.show()
			@ui.finaladd.show()
			#@ui.container_label.text count

		'keypress @ui.subtract':(e)->
			e.charCode >= 48 && e.charCode <= 57 ||	e.charCode == 44 

		'click @ui.save':(e)->
			e.preventDefault()
			data = @ui.form.serialize()
			product = @model.get('id')
			$.ajax
					method : 'POST'
					url : "#{_SITEURL}/wp-json/inventory/#{App.currentUser.get('ID')}/products/#{product}"
					data : data
					success : @successSave
					error : @errorSave
			

		'click @ui.view':(e)->
			e.preventDefault()
			product = @model.get('id')
			$.ajax
					method : 'GET'
					url : "#{_SITEURL}/wp-json/inventory/#{App.currentUser.get('ID')}/products/#{product}"
					success : @successHandler
					error : @errorHandler

	serializeData:->
		data = super()
		data.producttype = @model.get('product_type')
		data.product_type = @model.get('product_type').toLowerCase()

		data

	adjustValue:->
		available = @model.get 'available'
		total = @model.get 'total'
		@ui.navail.text available
		console.log @ui.rangeSliders.val()
		if parseInt(@ui.rangeSliders.val()) == 0
			@ui.save.hide()
		if @ui.rangeSliders.val() < 0 
			$('.sign').text '-'
			eqt = parseInt(available) - parseInt(Math.abs(@ui.rangeSliders.val()))
			@ui.save.show()
		else if @ui.rangeSliders.val() > 0
			$('.sign').text '+'
			eqt = parseInt(available) + parseInt(Math.abs(@ui.rangeSliders.val()))
			@ui.save.show()
			
		@ui.nsub.text Math.abs(@ui.rangeSliders.val())
		@ui.eqa.text eqt
		@ui.finaladd.show()
			
	valueOutput : (element) =>
		$(element).parent().find("output").html $(element).val()

	onShow:->
		@ui.save.hide()
		$('#subtract').val 'record'
		console.log $('#subtract').val()
		$('#record').addClass 'btn-primary'
		@ui.rangeSliders.each (index, ele)=>
			@valueOutput ele
		@ui.rangeSliders.rangeslider polyfill: false
		@ui.newsum.hide()
		@ui.finaladd.hide()
		available = @model.get 'available'
		total = @model.get 'total'
		containers = parseInt(available)/parseInt(total)
		console.log contacount = Math.ceil containers
		@ui.container_label.text contacount

	successSave:(response,status,xhr)=>
		if xhr.status == 201
			App.navigate '#/profile/my-products', true
		else
			@errorMsg()

	errorSave:(response,status,xhr)=>
		@errorMsg()

	errorMsg:->
		@ui.responseMessage.text "Details could not be saved"
		$('html, body').animate({
			scrollTop: 0
			}, 'slow')

	
		
		


class App.EditInventoryCtrl extends Ajency.RegionController
	initialize : (options = {})->
		productId  = @getParams()
		products = []
		console.log App.UserProductsColl
		console.log productModel = App.UserProductsColl.where({id:parseInt(productId[0])})
		@show new EditInventoryView
				model : productModel[0]	
					
		


	