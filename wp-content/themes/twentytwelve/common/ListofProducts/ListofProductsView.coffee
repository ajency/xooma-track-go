class ListofProductsViewItemview extends Marionette.ItemView

	tagName : 'li'

	template : 'Berry <a data-role="detailbutton" data-style="contactadd"></a>'












class Xoomapp.ListofProductsView extends Marionette.CompositeView

	template : '<div>
	          <h4 class="text-center">My Xooma Products</h4>
	    
	        <div class="container">
	              <div class="row">
	                  <div class="col-md-3"></div>
	                  <div class="col-md-6">
	                   
	                            <ul id="listofproducts">
	                                   
	                             </ul>
	                     </div>
	                  <div class="col-md-3"></div>
	              </div>
	               <br>
	                  <!-- NEXT Button -->
	                       <button id="next-btn" class="k-primary k-button">Next</button>
	                <!-- NEXT Button -->
	              <br>
	        </div>  

	      </div>'

	childView : ListofProductsViewItemview

	childViewContainer : 'ul#listofproducts'

	





						
           
					
			


            	

	
                

		