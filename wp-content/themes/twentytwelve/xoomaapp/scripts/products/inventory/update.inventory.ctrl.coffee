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

	events:
		'change @ui.containers':(e)->
			available = @model.get 'available'
			total = @model.get 'total'
			containers = parseInt(available)/parseInt(total)
			console.log contacount = Math.ceil containers
			console.log count = parseInt($(e.target).val()) + parseInt(contacount)
			@ui.container_label.text count

		'keypress @ui.subtract':(e)->
			e.charCode >= 48 && e.charCode <= 57 ||	e.charCode == 44 

		'click @ui.save':(e)->
			e.preventDefault()
			sub = @ui.subtract.val()
			if sub == ""
				sub = 0
				@ui.subtract.val(0)
			if parseInt(@model.get('available')) >  parseInt(sub)
				data = @ui.form.serialize()
				product = @model.get('id')
				$.ajax
						method : 'POST'
						url : "#{_SITEURL}/wp-json/inventory/#{App.currentUser.get('ID')}/products/#{product}"
						data : data
						success : @successSave
						error : @errorSave
			else
				@errorMsg()

		'click @ui.view':(e)->
			e.preventDefault()
			product = @model.get('id')
			$.ajax
					method : 'GET'
					url : "#{_SITEURL}/wp-json/inventory/#{App.currentUser.get('ID')}/products/#{product}"
					success : @successHandler
					error : @errorHandler
			


	onShow:->
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

	errorMsg:->
		@ui.responseMessage.text "Value entered shoule be less than available count"
		$('html, body').animate({
			scrollTop: 0
			}, 'slow')

	
		
		


class App.EditInventoryCtrl extends Ajency.RegionController
	initialize : (options = {})->
		productId  = @getParams()
		products = []
		App.UserProductsColl.each (val)->
			$.each val.get('products') , (index,value)->
						products.push value
		
		productsColl =  new Backbone.Collection products
		productModel = productsColl.where({id:parseInt(productId[0])})
		@show new EditInventoryView
				model : productModel[0]	
					
		


	