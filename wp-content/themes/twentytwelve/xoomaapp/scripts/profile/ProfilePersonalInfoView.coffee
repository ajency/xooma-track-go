

class ProfilePersonalInfoView extends Marionette.ItemView

	className : 'animated fadeIn'

	template : '#profile-personal-info-template'

	events:
		'click .radio':(e)->
			$('#gender').val e.target.id.value


	onShow:->
			console.log @model
			jQuery.validator.addMethod("equalLength",  (value, element)-> 
			    return this.optional(element) || (parseInt(value.length) == 6);
			  "* Enter valid 6 digit Xooma ID");

			#to initialize validate plugin
			$("#add_user_details").validate({

				rules:
				    xooma_member_id:
				    	number: true
				    	equalLength :true
				    
				    phone_no:
				      	number: true

				    radio_grp:
				    	required:true

				   	


				    

				submitHandler: (form)->
					$('#image').val App.

					$.ajax
							method : 'POST',
							url : _SITEURL+'/wp-json/profiles/128',
							data : $('#add_user_details').serialize(),
							success:(response)->
								if response.status == 404
									$('.response_msg').text response.response
								else
									$('.response_msg').text "User details saved successfully"

							
							error:(error)->
								$('.response_msg').text "Details could not be saved"


					return false;
			})

	





						
           
					
			


            	

	
                

		