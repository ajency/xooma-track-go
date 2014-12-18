

class ProfilePersonalInfoView extends Marionette.ItemView

	className : 'animated fadeIn'

	template : '#profile-personal-info-template'

	events:
		'click .radio':(e)->

			$('#gender').val $('#'+e.target.id).val()
			

	onShow:->
			@$el.find("#timezone option[value='"+@model.get('timezone')+"']").attr("selected","selected")
			$("input[name=radio_grp][value=" + @model.get('gender') + "]").prop('checked', true);
			$('#gender').val @model.get('gender');
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
					$.ajax
							method : 'POST',
							url : _SITEURL+'/wp-json/profiles/'+App.currentUser.get('ID'),
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

	





						
           
					
			


            	

	
                

		