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
			contacount = Math.ceil containers
			count = parseInt($(e.target).val()) + parseInt(contacount)
			@ui.ncon.text $(e.target).val()
			equalto = parseInt($(e.target).val()) * parseInt(total)
			@ui.nequalto.text equalto
			@ui.navail.text available
			@ui.nadd.text equalto
			if @ui.rangeSliders.val() < 0 
				$('.sign').text ' - '
				eqt = parseInt(available) + parseInt(equalto) - parseInt(Math.abs(@ui.rangeSliders.val()))
			
			else
				$('.sign').text ' + '
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
			

	serializeData:->
		data = super()
		data.producttype = @model.get('product_type')
		data.product_type = @model.get('product_type').toLowerCase()

		data

	adjustValue:->
		available = @model.get 'available'
		total = @model.get 'total'
		@ui.navail.text available
		if parseInt(@ui.rangeSliders.val()) == 0
			$('.sign').text ' - '
			@ui.save.hide()
			eqt = parseInt(available) - parseInt(Math.abs(@ui.rangeSliders.val()))
		if @ui.rangeSliders.val() < 0 
			$('.sign').text ' - '
			eqt = parseInt(available) - parseInt(Math.abs(@ui.rangeSliders.val()))
			@ui.save.show()
		else if @ui.rangeSliders.val() > 0
			$('.sign').text ' + '
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
		$('#record').addClass 'btn-primary'
		@ui.rangeSliders.each (index, ele)=>
			@valueOutput ele
		@ui.rangeSliders.rangeslider polyfill: false
		@ui.newsum.hide()
		@ui.finaladd.hide()
		available = @model.get 'available'
		total = @model.get 'total'
		containers = parseInt(available)/parseInt(total)
		contacount = Math.ceil containers
		@ui.container_label.text contacount

	successSave:(response,status,xhr)=>
		if xhr.status == 201
			model = new UserProductModel 
			model.set response[0]
			App.useProductColl.add model , {merge: true}
			window.removeMsg()
			@ui.responseMessage.addClass('alert alert-success').text("Inventory updated!")
			$('html, body').animate({
							scrollTop: 0
							}, 'slow')
		else
			@errorMsg()

	errorSave:(response,status,xhr)=>
		@errorMsg()

	errorMsg:->
		window.removeMsg()
		@ui.responseMessage.addClass('alert alert-danger').text("Inventory couldn't be updated!")
		$('html, body').animate({
							scrollTop: 0
							}, 'slow')
	
		
		


class App.EditInventoryCtrl extends Ajency.RegionController
	initialize : (options = {})->
		@show @parent().getLLoadingView()
		productId  = @getParams()
		products = []
		productModel = App.useProductColl.where({id:parseInt(productId[0])})
		@show new EditInventoryView
				model : productModel[0]	
					
		


	