

class Xoomapp.MeasurementView extends Marionette.ItemView

	template : '<div>
                 <div class="container">
                      <div class="row">
                        <br> <br>
                            <div class="title">
                               <p><b>Set your mesurements </b><br>Knowing this information will help us determine the</br>ideal amount of X2O water that your bodyneeds on a daily basis </p>
                            </div> 
                            <br> 
                        <form id="add_measurements">
                           <div class="col-sm-3">   </div>  
                                <div >
                                       <ul >
                                          <li>
                                                <label>Height
                                                    <input type="text" required name="height" id="height" value="" placeholder="inches"/>
                                                </label>
                                            </li>
                                            <li>
                                                <label>Weight
                                                    <input type="text" required name="weight" id="weight" value="" placeholder="pounds" />
                                                </label>
                                            </li>
                                        </ul>
                                 </div>
                            <div class="col-sm-3">   </div>  
                         </div>
                       <br>
                              <h4 class="text-center">
                             Label Parts of the body
                              Measurements(inches)
                        </h4> 
                         <div class="row">
                          <div class="col-sm-2"> </div>
                           <div class="col-sm-4">  
                          
                              <img src="img/body-part.jpg" class="center-block " height="530px"/>
                           </div> 
                            <div class="col-sm-4">  
                               <ul data-role="listview" data-style="inset">
                                          <li>
                                                <label>Neck
                                                    <input type="text" name="neck" id="neck" value="" placeholder=""/>
                                                </label>
                                            </li>
                                            <li>
                                                <label>Chest
                                                    <input type="text" name="chest" id="chest" value="" placeholder="" />
                                                </label>
                                            </li>
                                             <li>
                                                <label>Waist
                                                    <input type="text" name="waist" id="waist" value="" placeholder="" />
                                                </label>
                                            </li>
                                             <li>
                                                <label>Abdomen
                                                    <input type="text" name="abdomen" id="abdomen" value="" placeholder="" />
                                                </label>
                                            </li>
                                             <li>
                                                <label> Hips
                                                    <input type="text" name="hips" id="hips" value="" placeholder="" />
                                                </label>
                                            </li>
                                             <li>
                                                <label>Upper Thigh
                                                    <input type="text" name="thigh" id="thigh" value="" placeholder="" />
                                                </label>
                                            </li>
                                               <li>
                                                <label>Mid Calf
                                                    <input type="text" name="midcalf" id="midcalf" value="" placeholder="" />
                                                </label>
                                            </li>
                                                <li>
                                                <label>Calf
                                                    <input type="text" name="calf" id="calf"  value="" placeholder="" />
                                                </label>
                                            </li>
                               </ul>
                           </div>  
                           
                           <div class="col-sm-2"> </div>
                           	<br>
						        <!-- Login Button -->
						           <button  type="submit" id="add_details" >Next</button>
						    	<!-- Login Button -->
						  <br>
                         </div>
                         </form>
                     </div></div>'

	events:
		'click #add_details':(event)->
			#to initialize validate plugin
			$("#add_measurements").validate({

				rules:
				    height:
				      number: true
				    
				    weight:
				      number: true
				    
				   
			  

				submitHandler: (form)->


					$.ajax
							method : 'POST',
							url : SITEURL+'/wp-json/measurements/2',
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

	





						
           
					
			


            	

	
                

		