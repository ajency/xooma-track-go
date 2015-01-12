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
		$.each qty , (ind,val)->
			console.log occurrence  = @model.get('occurrences')[ind]
			occurrence = _.has(occurrence, "occurrence")
			expected = _.has(occurrence, "expected")
			if occurrence == true && expected == true
				data.class = @model.get('product_type_name')+'occurred_class'
			else if occurrence == false && expected == true
				data.class = @model.get('product_type_name')+'expected_class'
			else if occurrence == true && expected == false
				data.class = @model.get('product_type_name')+'bonus_class'
		


		
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