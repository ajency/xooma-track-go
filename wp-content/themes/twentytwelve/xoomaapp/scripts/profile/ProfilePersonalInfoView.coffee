

class App.ProfilePersonalInfoView extends Marionette.ItemView

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
				clear: 'Clear date'
			)
			picker = $input.pickadate('picker')
			picker.set('select',@model.get('profiles').birth_date , { format: 'yyyy-mm-dd' })


		# 'input #birth_date':(e)->
		# 	@checkDateValue(e)
		

	#This Function Checks the date selected by user and doesnot allow him to select future dates
	# checkDateValue:()->
	# 	moment(c).format("Do MMM YYYY");
	# 	getBirthdateValue = $("#birth_date").val();
	# 	date = new Date()
	# 	selected_date = moment(getBirthdateValue).format("Do MMM YYYY");
	# 	todays_date = moment(date).format("Do MMM YYYY");
	# 	difference_in_dates = moment(selected_date,"Do MMM YYYY").diff(moment(todays_date,"Do MMM YYYY"))
	# 	if difference_in_dates > 0
	# 		alert "You cannot select a future Date"
		



	onShow:->
		_.enableCordovaBackbuttonNavigation()
		$('#profile').parent().addClass 'active'
		$('#measurement').bind('click',@disabler)
		$('#measurement').css('cursor', 'default')
		$('#product').bind('click',@disabler)
		$('#product').css('cursor', 'default')
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

	disabler:(e)->
		e.preventDefault()
		return false

	#to initialize validate plugin
	formSubmitHandler: (form)=>
		_formData = $('#add_user_details').serialize()
		@model.saveProfiles(_formData).done(@successHandler).fail(@errorHandler)
		return false
				
							
	successHandler:(response, status)=>
		if status is 404
			@ui.responseMessage.text response.response
		else
			@ui.responseMessage.text "User details saved successfully"

	errorHandler:(error)=>
		@ui.responseMessage.text "Details could not be saved"





















