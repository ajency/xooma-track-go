

class ProfilePersonalInfoView extends Marionette.ItemView

	className : 'animated fadeIn'

	template : '#profile-personal-info-template'

	ui : 
		form : '#add_user_details'
		responseMessage : '.response_msg'
		

	events:
		'click .radio':(e)->
			$('#gender').val $('#'+e.target.id).val()

		'click #measurement':(e)->
			e.preventDefault()

		'click #birth_date':(e)->
			$input = $('.js__datepicker').pickadate(
			 	formatSubmit: 'yyyy-mm-dd'
			)
			picker = $input.pickadate('picker')
			picker.set('select',@model.get('profiles').birth_date , { format: 'yyyy-mm-dd' })
		



	onShow:->
		@$el.find("#timezone option[value='"+@model.get('profiles').timezone+"']").attr("selected","selected")
		@$el.find("input[name=radio_grp][value=" + @model.get('profiles').gender + "]").prop('checked', true);
		@$el.find('#gender').val @model.get('profiles').gender
		@ui.form.validate 
			rules:
			    xooma_member_id:
			    	number: true
			    	equalLength :true

			    phone_no:
			      	number: true

			    radio_grp:
			    	required:true

			submitHandler: @formSubmitHandler

		jQuery.validator.addMethod("equalLength",  (value, element)->
		    return this.optional(element) || (parseInt(value.length) == 6);
		  "* Enter valid 6 digit Xooma ID");

	#to initialize validate plugin
	formSubmitHandler: (form)->
				_formData = $('#add_user_details').serialize()
				App.currentUser.saveProfiles(_formData).done(@successHandler).fail(@errorHandler)
				return false
				
							
	successHandler:(response, status)=>
		if status == 404
			@ui.responseMessage.text response.response
		else
			@ui.responseMessage.text "User details saved successfully"

	errorHandler:(error)=>
		@ui.responseMessage.text "Details could not be saved"





















