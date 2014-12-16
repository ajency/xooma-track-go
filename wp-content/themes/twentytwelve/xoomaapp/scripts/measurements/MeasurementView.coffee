

class ProfileMeasurementsView extends Marionette.ItemView

  template  : '#profile-measurements-template'

  className : 'animated fadeIn'

	onShow:->
		  #to initialize validate plugin
			$("#add_measurements").validate({

				submitHandler: (form)->


					$.ajax
							method : 'POST',
							url : _SITEURL+'/wp-json/measurements/2',
							data : $('#add_measurements').serialize(),
							success:(response)->
								console.log(response)
								if response.status == 404
									$('.response_msg').text "Something went wrong"
								else
									$('.response_msg').text "User details saved successfully"

							
							error:(error)->
								$('.response_msg').text "Something went wrong"



			})

	





						
           
					
			


            	

	
                

		