

class ProfilePersonalInfoView extends Marionette.ItemView

	className : 'animated fadeIn'

	template : '#profile-personal-info-template'

	events:
		'click .radio':(event)->
			$('#gender').val event.id.value


	onShow:->
			#to initialize validate plugin
			$("#add_user_details").validate({

				rules:
				    xooma_member_id:
				    	number: true
				    
				    phone_no:
				      	number: true

				    

				submitHandler: (form)->


					$.ajax
							method : 'POST',
							url : _SITEURL+'/wp-json/profiles/2',
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

	





						
           
					
			


            	

	
                

		