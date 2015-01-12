App.state 'Schedule',
					url : '/products/:id/consume'
					parent : 'xooma'

class ScheduleView extends Marionette.ItemView

	template : '#schedule-template'


	serializeData:->
		data = super()
		console.log data.day = moment().format("dddd")
		console.log data.today = moment().format("MMMM Do YYYY")
		qty = @model.get 'qty'
		occurr = @model.get('occurrences')
		product_type = @model.get('product_type_name')
		no_servings  = []
		$.each qty , (ind,val)->
			console.log occurrence  = occurr[ind]
			occurrence = _.has(occurrence, "occurrence")
			expected = _.has(occurrence, "expected")
			if occurrence == true && expected == true
				data.classname = product_type+'occurred_class'
			else if occurrence == false && expected == true
				data.classname = product_type+'expected_class'
			else if occurrence == true && expected == false
				data.classname = product_type+'bonus_class'

			i = 0
			servings = []
			while(i < val.qty)
				servings.push classname : data.classname
				i++
			no_servings.push servings : servings
			data.no_servings =  no_servings
		
		dsata.original = product_type+'occurred_class'
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