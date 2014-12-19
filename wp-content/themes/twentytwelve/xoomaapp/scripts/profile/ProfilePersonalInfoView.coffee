

class ProfilePersonalInfoView extends Marionette.ItemView

	className : 'animated fadeIn'

	template : '#profile-personal-info-template'

	behaviors :
		FormBehavior :
			behaviorClass : Ajency.FormBehavior

	ui :
		form : '#add_user_details'
		responseMessage : '.response_msg'
		dateElement : '.js__datepicker'
		


	events:
		'click .radio':(e)->
			$('#gender').val $('#'+e.target.id).val()

		'click #measurement':(e)->
			e.preventDefault()

		'click #birth_date':(e)->
			$input = @ui.dateElement.pickadate(
			 	formatSubmit: 'yyyy-mm-dd'
			 	
			)
			picker = $input.pickadate('picker')
			picker.set('select',@model.get('profiles').birth_date , { format: 'yyyy-mm-dd' })




	onsShow:->
		$('#profile').parent().addClass 'active'
		$('#measurement').bind('click',@disabler)
		$('#measurement').css('cursor', 'default')
		$('#product').bind('click',@disabler)
		$('#product').css('cursor', 'default')
		@$el.find("#timezone option[value='"+@model.get('profiles').timezone+"']").attr("selected","selected")
		@$el.find("input[name=radio_grp][value=" + @model.get('profiles').gender + "]").prop('checked', true);
		@$el.find('#gender').val @model.get('profiles').gender
		

	disabler:(e)->
		e.preventDefault()
		return false

	#to initialize validate plugin
	onFormSubmit: (_formData)=>
		@model.saveProfiles(_formData).done(@successHandler).fail(@errorHandler)
		return false
				
							
	successHandler:(response, status)=>
		$('#product').unbind('click',@disabler)
		$('#measurement').css('cursor', 'pointer')
		@showSuccessMessage()


	errorHandler:(error)=>
		@ui.responseMessage.text "Details could not be saved"





















