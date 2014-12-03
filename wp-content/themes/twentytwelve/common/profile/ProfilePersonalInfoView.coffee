

class Xoomapp.ProfilePersonalInfoView extends Marionette.ItemView

	template : '<div ><div class="response_msg"></div>
			           <form id="add_user_details" ><div class="container">
			          <div class="row">
			              <img src="http://localhost/xooma/wp-content/themes/twentytwelve/img/profile.jpg"  class="img-circle"/>
			              	<input type="hidden" name="image" id="image" value="http://localhost/xooma/wp-content/themes/twentytwelve/img/profile.jpg" /> 
			              	<<input type="hidden" name="attachment_id" id="attachment_id" value="" /> >
			                <div class="title">
			                   <p><b>YOU are on the the spot! </b><br>Let us know something about you.</p>
			                </div> 
			          </div>

			            <div class="row">
			        <div class="col-sm-3">  
			        </div>    
			  <div class="col-sm-6">

			  <div id="forms" >
			      
			          <ul >

			           
			              <li>
			                  <label>xooma id
			                      <input type="text" value="" required id="xooma_member_id" name="xooma_member_id" placeholder="text"/>
			                  </label>
			              </li>
			              <li>
			                  <label>Name
			                      <input type="text" id="name" name="name" value="Chris Brown" placeholder="text" disabled/>
			                  </label>
			              </li>
			              <li>
			                  <label>Email
			                      <input type="text" id="email_id" name="email_id" value="" placeholder="text" disabled/>
			                  </label>
			              </li>
			              <li>
			                  <label>Phone No
			                      <input type="text" id="phone_no" name="phone_no" value="" placeholder="text"/>
			                  </label>
			              </li>
			              <li>
			                  <label>Gender
			                      <input type="text" id="gender" required name="gender" value="" placeholder="text"/>
			                  </label>
			              </li>
			              <li>
			                  <label>Birthdate
			                     <input type="date" id="birth_date" required name="birth_date" value="2012-03-22" />
			                  </label>
			              </li>
			               <li>
			                  <label>Timezone
			                         <input id="timezone" name="timezone" />
			                  </label>
			              </li>
			          </ul>
			     
			  </div>
			  </div>
			   <div class="col-sm-3">   </div>  
			  </div>
			  <br>
			      <!-- Login Button -->
			           <button  type="submit" id="add_user" >Next</button>
			    <!-- Login Button -->
			  <br>
			     </form>  </div>
			</div>'

	events:
		'click #add_user':(event)->
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
							url : SITEURL+'/wp-json/profiles/2',
							data : $('#add_user_details').serialize(),
							success:(response)->
								console.log(response)
								if response.status == 404
									$('.response_msg').text "Something went wrong"
								else
									$('.response_msg').text "User details saved successfully"

							
							error:(error)->
								$('.response_msg').text "Something went wrong"



			})

	





						
           
					
			


            	

	
                

		