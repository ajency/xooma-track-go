App.state 'Schedule',
					url : '/products/:id/consume'
					parent : 'xooma'

class ScheduleView extends Marionette.ItemView

	template : '#schedule-template'

	ui :
		intake : '.intake'
		form 	: '#consume'

	events:
		'click @ui.intake':(e)->
			product = @mode.get('id')
			e.preventDefault()
			$.ajax
				method : 'POST'
				data : @ui.form.serialize()
				url : "#{_SITEURL}/wp-json/intakes/#{App.currentUser.get('ID')}/products/#{product}"
				success: @successHandler
				error :@erroraHandler



	serializeData:->
		data = super()
		console.log data.day = moment().format("dddd")
		console.log data.today = moment().format("MMMM Do YYYY")
		qty = @model.get 'qty'
		occurr = @model.get('occurrences')
		product_type = @model.get('product_type_name')
		product_type = product_type.toLowerCase()
		no_servings  = []
		$.each qty , (ind,val)->
			console.log occurrence = _.has(occurr[ind], "occurrence")
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
			no_servings.push servings : servings
			no_servings.push schedule : occurr[ind]
			data.no_servings =  no_servings
		
		data.original = product_type+'_expected_class'
		data
						


		
class App.ScheduleCtrl extends Ajency.RegionController
	initialize : (options = {})->
		productId  = @getParams()
		product = parseInt productId[0]
		$.ajax
				method : 'GET'
				data : 'date=""'
				url : "#{_SITEURL}/wp-json/intakes/#{App.currentUser.get('ID')}/products/#{product}"
				success: @successHandler
				error :@erroraHandler


	successHandler:(response,status,xhr)=>
		model = new Backbone.Model response
		@_showView(model)
		

	_showView:(productModel)->
		console.log productModel
		@show new ScheduleView
					model : productModel