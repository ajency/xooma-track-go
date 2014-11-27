jQuery(document).ready(function($) {

	//to initialize validate plugin
	$("#add_product_form").validate({

		rules: {
			    serving_size: {
			      number: true
			    },
			    serving_per_container: {
			      number: true
			    },
			    serving_size_clone: {
			      number: true
			    }
			  },
		
		submitHandler: function(form) {
  			
			$.ajax({
				type : 'POST',
				url : SITEURL+'/wp-json/products',
				data : $('#add_product_form').serialize(),
				success:function(response){
					$('#response_msg').text('Product was created successfully');
					$('html, body').animate({
								scrollTop: 0
								}, 'slow')
				},
				error:function(error){
					console.log(error.responseJSON.status);
					if(error.responseJSON.status == 201){
						$('#response_msg').text('Product was created successfully');
						$('html, body').animate({
								scrollTop: 0
								}, 'slow')
						load_products();
					}
					else
					{
						$('#response_msg').text('There was some problem creating the product');
						$('html, body').animate({
								scrollTop: 0
								}, 'slow')
					} 
					
				} 
			})
	    
	 	
 		}
	});

	// initialize validate plugin for product edit form
	// $("#edit_product_form").validate({
	// 	submitHandler: function(form) {

	// 		$.ajax({
	// 			type : 'POST',
	// 			url : SITEURL+'/wp-json/products/update',
	// 			//url : AJAXURL+'?action=update_product',
	// 			data : $('#edit_product_form').serializeArray(),
	// 			success:function(response){
	// 				console.log(response);
	// 			},
	// 			error:function(error){
	// 				console.log(error);
	// 			} 
	// 		})
	// }
		
		
	// });
	
	$("#edit_product_form").removeAttr("novalidate");
	$('.custom_media_upload').live('click',function() {

    var send_attachment_bkp = wp.media.editor.send.attachment;

    wp.media.editor.send.attachment = function(props, attachment) {

    	console.log(attachment.sizes.thumbnail);
    	if(attachment.sizes.thumbnail != undefined){
	        $('.custom_media_image').attr('src', attachment.sizes.thumbnail.url);
	        $('.custom_media_url').val(attachment.sizes.thumbnail.url);
	        $('.custom_media_id').val(attachment.id);
    	}
    	else
    	{
    		$('.custom_media_image').attr('src', attachment.url);
        	$('.custom_media_url').val(attachment.url);
        	$('.custom_media_id').val(attachment.id);
    	}
        wp.media.editor.send.attachment = send_attachment_bkp;
    }

    wp.media.editor.open();

    return false;       
}); 

	//event to load servings per day

	$('.radio').live('click',function(event){

		if(parseInt(this.id) == 1){
			$('#serving_per_day_anytime').val("");
			$('#serving_per_day_scheduled').val("");
			$('#serving_per_day_anytime').prop('selectedIndex', "");
			$('#serving_per_day_scheduled').prop('selectedIndex', "");
			$('#serving_per_day_anytime').prop("required", true);
			$('#serving_per_day_scheduled').removeAttr("required");
			$('#when').removeAttr("required");
			$('#serving_per_day_anytime').show();
			$('#serving_per_day_scheduled').hide();
			$("label[for='when']").hide()
			$('#row_when').hide();
			$('#when').hide();
			$('#when').val("");
			$('#when').prop('selectedIndex', "");
			$(".widefat #clone td").remove();
			$( "#serving_size" ).trigger( "change" );
			$( "#serving_per_container" ).trigger( "change" );
			$('#clone_id').val(0)

		}
		else{

			$('#serving_per_day_anytime').val("");
			$('#serving_per_day_scheduled').val("");
			$('#serving_per_day_anytime').prop('selectedIndex', "");
			$('#serving_per_day_scheduled').prop('selectedIndex', "");
			$('#when').prop('selectedIndex', "");
			$('#when').val("");
			$('#serving_per_day_anytime').removeAttr("required");
			$('#serving_per_day_scheduled').prop("required", true);
			$('#when').prop("required", true);
			$('#serving_per_day_anytime').hide();
			$('#serving_per_day_scheduled').show();
			$('#row_when').show();
			$('#when').show();
			$(".widefat #add_table_weight td").remove();
		 	$('#count').val(0);
		 	$( "#serving_size_clone" ).trigger( "change" );
			$( "#serving_per_container" ).trigger( "change" );
		} 
		$('#frequency').val(this.id);

	});

	//to calculate the value based upon the size entered
	$('#serving_size').live('change',function(event){
		
		size = this.value == "" ? 0 : this.value;
		serving = $('#serving_per_container').val()== "" ? 0 : $('#serving_per_container').val();
		serving_size_clone =($('#serving_size_clone').val() == undefined) 
							? 0 : $('#serving_size_clone').val();
		total =  (parseInt(size) + parseInt(serving_size_clone))* parseInt(serving) ;
		$('#total').text(total);

		

	});

	//to calculate the value based upon the size entered
	$('#serving_size_clone').live('change',function(event){
		
		serving_size_clone = (this.value == undefined) ? 0 : this.value;
		serving = $('#serving_per_container').val()== "" ? 0 : $('#serving_per_container').val();
		size = $('#serving_size').val()== "" ? 0 : $('#serving_size').val();
		total =  (parseInt(size) + parseInt(serving_size_clone))* parseInt(serving) ;
		$('#total').text(total);

		

	});

	//to calculate the value based upon the serving_per_container entered
	$('#serving_per_container').live('change',function(event){

		size = $('#serving_size').val() == "" ? 0 : $('#serving_size').val();
		serving_size_clone = ($('#serving_size_clone').val() == undefined)
							 ? 0 : $('#serving_size_clone').val();
		serving = this.value == "" ? 0 : this.value;
		total =  (parseInt(size) + parseInt(serving_size_clone))* parseInt(serving) ;
		$('#total').text(total);

		

	});

	//to set the value of checkebox
	$('#active').live('click',function(event){

		if($('#'+this.id).prop('checked') == true)
		{
			$('#'+this.id).val('1');
		}
		else
		{
			$('#'+this.id).val('0');
		}
		

		

	});

	//to set the value of dep_weight checkebox
	$('#dep_weight').live('click',function(event){

		if($('#'+this.id).prop('checked') == true)
		{
			$('#'+this.id).val('1');
		}
		else
		{
			$('#'+this.id).val('0');
		}
		

		

	});

	$('#serving_per_day_anytime').live('change',function(event){
		i = 0; 
		if(this.value == 'asperbmi')
		{
			row = '<input type="button" name="add" id="add" value="Add Values for BMI" >';
		    row2 = '<table class="add_rows">'+ 
		            	'<tr id="row'+i+'">'+
		            		'<td>'+
		            			'<input type="textbox" number required class="check_number" id="weight_from'+i+'" name="weight_from'+i+'" value="">'+
		            		'</td>'+
		            		'<td>'+
		            			'<input type="textbox" required class="check_number" id="weight_to'+i+'" name="weight_to'+i+'" value="">'+
		            		'</td>'+
		            		'<td>'+
		            			'<input type="textbox" required class="check_number" id="quantity'+i+'" name="quantity'+i+'" value="">'+
		            		'</td>'+
		            		'<td>'+
		            			'<input type="button" class="del" data-del="'+i+'"  name="del" id="del" value="del" >'+
		            			'<input type="hidden" name="hide'+i+'" id="hide'+i+'" value="0">'+
		            		'</td>'+
		            	'</tr>'+
		            '</table>';

		    $(".widefat").find('#add_table_weight').append($('<td>').append(row),
    		$('<td>').append(row2)
			);
		    $('#count').val($("table .add_rows tr").length);
		    console.log($('#count').val());
		     

		 }
		 else
		 {
		 	$(".widefat #add_table_weight td").remove();
		 	$('#count').val(0);
		 }
	})
	$('.add_row_class').live('change',function(event){
		i = 0; 
		
		if(this.value == 'Once' || this.value == "")
		{
			$(".widefat #add_table_weight td").remove();
		     $(".widefat #clone td").remove();
		     $('#count').val(0);
		     $('#clone_id').val(0)
		}
		else if(this.value == 'Twice')
		
		{
			$('#count').val(0);
			$(".widefat #add_table_weight td").remove();
			dropdown_tet = '<label for="when_clone">When</label>';
			dropdown = '<select  required id="when_clone" name="when_clone">'+
                '<option value="">Please select</option>'+
                '<option  value="1" >Morning before Meal</option>'+
                '<option value="2" >Morning with Meal</option>'+
                '<option value="3" >Evening before Meal</option>'+
                '<option value="4" >Evening with Meal</option>'+
                
            '</select>';

            tetbox_tet = '<td width="30%" class="row-title"><label for="serving_size_clone">Quantity per servings</label></td>';
            tetbox = '<input type="text" number required id="serving_size_clone" name="serving_size_clone" value="" class="small-text" />'; 
            
            if($('#clone_id').val() != 1)
            {
            $(".widefat").find('#clone').append($('<td>').append(tetbox_tet),
    		$('<td>').append(tetbox), $('<td>').append(dropdown_tet),$('<td>').append(dropdown)
			);
			$('#count').val(1);
		  }
		}
		
	})
	//to load shedule servings
	// $('#serving_per_day_scheduled').live('change',function(event){

	// 	if(parseInt(this.value) == 'Once'){
	// 		$(".widefat #clone td").remove();
    		


	// 	}
	// 	else
	// 	{
	// 		dropdown_tet = '<label for="when_clone">When</label>';
	// 		dropdown = '<select  required id="when_clone" name="when_clone">'+
 //                '<option value=""></option>'+
 //                '<option  value="1" >Morning before Meal</option>'+
 //                '<option value="2" >Morning with Meal</option>'+
 //                '<option value="3" >Evening before Meal</option>'+
 //                '<option value="4" >Evening with Meal</option>'+
                
 //            '</select>';

 //            tetbox_tet = '<td width="30%" class="row-title"><label for="serving_size_clone">Quantity per servings</label></td>';
 //            tetbox = '<input type="text" number required id="serving_size_clone" name="serving_size_clone" value="" class="small-text" />'; 

 //            $(".widefat").find('#clone').append($('<td>').append(tetbox_tet),
 //    		$('<td>').append(tetbox), $('<td>').append(dropdown_tet),$('<td>').append(dropdown)
	// 		);
		  
		   
	// 	}


	// });
	
	$('#add').live('click',function(event){

		i = $("table .add_rows tr").length;
		$('#count').val(i);
		
		row1 = '<input type="textbox"  class="check_number" required id="weight_from'+i+'" name="weight_from'+i+'" value="">';
		row2 = '<input type="textbox"  class="check_number" required id="weight_to'+i+'" name="weight_to'+i+'" value="">';
		row3 = '<input type="textbox"  class="check_number" required id="quantity'+i+'" name="quantity'+i+'" value="">';
		del = '<input type="button" class="del" data-del="'+i+'" name="del'+i+'" id="del'+i+'" value="Del" >'+
				'<input type="hidden" name="hide'+i+'" id="hide'+i+'" value="0">';

		$(".add_rows").append($('<tr>').attr('id','row'+i).append($('<td>').append(row1),
    		$('<td>').append(row2),$('<td>').append(row3), $('<td>').append(del)
			));
	})

	$('.del').live('click',function(event){



		id = $('#'+this.id).attr('data-del');
		console.log(id);
		if(parseInt(id) == 0){
			$('#response_msg').text('Enter atleast one BMI Value ')
			$('html, body').animate({
									scrollTop: 0
									}, 'slow')
			return false;
		}	
		$('#row'+id).hide();
		$('#weight_from'+id).removeAttr('required');
		$('#weight_to'+id).removeAttr('required');
		$('#quantity'+id).removeAttr('required');
		$('#hide'+id).val('1');

	})

	// get all the products 
	load_products();
	function load_products(){
		
		$.ajax({
			type : 'GET',
			url : SITEURL+'/wp-json/products',
			//url : AJAXURL+'?action=get_products',
			data : "",
			success:function(response){
				show_all_products(response.response);
			},
			error:function(error){
				console.log(error);
			} 
		});


	}
	//html for showing all the products
	function show_all_products(response){

		html = "";

		$.each(response, function( index, value ) {
			$('#total_products').text(value.total_products);
			html += "<tr  class='row_class' id="+value.id+"><td>"+value.name+"</td><td>"+value.product_type_name+"</td><td>"+value.frequency+
			"</td><td>"+value.modified_date+"</td><td>"+value.active+"</td></tr>";
				


		});

		$('#prodcts_table tbody').append(html);


	}
	//onclick function to edit a product
	$('.row_class').live('click',function(e){

		$.ajax({
			type : 'GET',
			url : SITEURL+'/wp-json/products/'+this.id,
			//url : AJAXURL+'?action=get_products',
			data :'',
			success:function(response){
				console.log(response);
				show_edit_product(response.response);
				
			},
			error:function(error){
				console.log(error);
			} 
		});



	});

	

	//edit product form
	function show_edit_product(response)
	{

		$('#form_data').text("");
		active = (response[0].active_value == 1) ? 'checked' : "";
		anytime_selected = parseInt(response[0].frequency_value) == 1 ? 'checked' : "";
		schedule_freq_selected = parseInt(response[0].frequency_value) == 2 ? 'checked' : "";
		time_text = "";
		when_text = "";
		schedule_text = "";
		time_schedule_text = "";
		when_selected_clone_text = "";
		bmi_display = "display:none";
		bmi_text ="";
		schedule_array = new Array('Once','Twice');
		anytime_array = new Array(1,2,3,4,5,6,7,8,9,10,'asperbmi');
		when_array = new Array('Morning before Meal','Morning with Meal','Evening before Meal','Evening with Meal');
		for (var i = 0 ; i < anytime_array.length; i++) {
			
			time_set_selected = response[0].time_set == anytime_array[i] ? 'selected' : "";
			time_set_selected = parseInt(response[0].frequency_value) == 1 ? time_set_selected : "";
			bmi_value = anytime_array[i] == 'asperbmi'? 'As per BMI' : anytime_array[i];
			time_text += '<option value="'+anytime_array[i]+'" '+time_set_selected+'>'+bmi_value+'</option>';
		}
		$.each(schedule_array, function(index,value){
			schedule_selected = response[0].time_set == value ? 'selected' : "";
			schedule_selected = parseInt(response[0].frequency_value) == 2 ? schedule_selected : "";
			bmi_value = value == 'asperbmi'? 'As per BMI' : value;
			schedule_text += '<option value="'+schedule_array[index]+'" '+schedule_selected+'>'+bmi_value+'</option>';
		});
		bmi = response[0].bmi;
		
		if(!(jQuery.isEmptyObject(bmi)))
		{
			bmi_display = "";
			bmi_text = '<td><input type="button" name="add" id="add" value="Add Values for BMI" ></td><td><table class="add_rows">';
			$.each(bmi,function(inde,value) {
				console.log(value);
				range = value.range;
				console.log(range);
				range_arr = range.split('<');
				console.log(range_arr[1]);
				quantity = value.quantity;
				console.log(quantity);
				i = inde
				bmi_text += 
		    	'<tr id="row'+i+'"><td><input class="check_number" type="textbox" required id="weight_from'+i+'" name="weight_from'+i+'" value="'+range_arr[0]+'"></td>'+
				'<td><input type="textbox" class="check_number" required id="weight_to'+i+'" name="weight_to'+i+'" value="'+range_arr[1]+'"></td>'+
				'<td><input type="textbox" class="check_number" required id="quantity'+i+'" name="quantity'+i+'" value="'+quantity+'"></td>'+
				'<td><input type="button" class="del" data-del="'+i+'" name="del'+i+'" id="del'+i+'" value="Del" ></td>'+
				'<input type="hidden" name="hide'+i+'" id="hide'+i+'" value="0"></td></tr>';
			});
			bmi_text += '</table></td>';
		

		}
		when = response[0].when.split('|');
		serving_size = response[0].serving_size.split('|');
		if(parseInt(response[0].frequency_value) == 1)
		{
			display_anytime = '';
			required_schedule = "required";
			required_anytime = "";
			display_schedule = "display:none";
		}
		else
		{
			display_schedule = '';
			required_schedule = ""
			required_anytime = "required";
			display_anytime = "display:none";
		}
		when_clone_text = "";
		when_selected_clone_text = '<option value="">Please select</option>';
		when_text = '<option value="">Please select</option>';	
		$.each(when_array, function(index,value){
			
			when_selected = parseInt(when[0]) == parseInt(index) + 1 ? 'selected' : "";
			when_selected = parseInt(response[0].frequency_value) == 2 ? when_selected : "";
			when_text += '<option value="'+(parseInt(index) + 1)+'" '+when_selected+'>'+value+'</option>';
			if(when[1] !="")
			{
				when_selected_clone = parseInt(when[1]) == parseInt(index) + 1 ? 'selected' : "";
				when_selected_clone = parseInt(response[0].frequency_value) == 2 ? when_selected_clone : "";
				
				when_selected_clone_text += '<option value="'+(parseInt(index) + 1)+'" '+when_selected_clone+'>'+value+'</option>';
				when_clone_text = 
        	'<td class="row-title"><label for="serving_size_clone">Quantity per servings</label></td>'+
            '<td><input type="text" number style="'+display_schedule+'" '+required_schedule+' id="serving_size_clone" name="serving_size_clone" value="'+serving_size[1]+'" class="small-text" /></td>'+
     
            '<td  class="row-title"><label id="row_when"  for="when">When</label></td>'+
            '<td><select style="'+display_schedule+'" '+required_schedule+' id="when_clone" name="when_clone">'+
                when_selected_clone_text+
                
            '</select></td>';
			}
		});
		
		
		html = "";
		html += '<html>'+
			'<h2>Edit Product</h2>'+
			'<form id="edit_product_form" enctype="multipart/form-data" method="POST"><div id="response_msg" ></div>'+
				'<table class="widefat">'+
				    '<tbody>'+
				        '<tr>'+
				            '<td class="row-title"><label for="tablecell">Name</label></td>'+
				            '<td><input type="hidden" name="id" id="id" value="'+response[0].id+'" /><input name="name" id="name" required type="text" value="'+response[0].name+'" class="regular-text" /></td>'+
				        '</tr>'+
				        '<tr >'+
				            '<td class="row-title"><label for="tablecell">Active</label></td>'+
				            '<td><input name="active" type="checkbox" id="active" value="'+response[0].active_value+'"  '+active+' /></td>'+
				        '</tr >'+
				        '<tr >'+
				        '<td ><label for="tablecell">Upload Image </label></td>'+
				        '<td><a href="#" class="custom_media_upload">Upload</a>'+
                				'<img class="custom_media_image" src="'+response[0].image+'" />'+
                				'<input class="custom_media_url" type="hidden" name="attachment_url" value="">'+
                				'<input class="custom_media_id" type="hidden" name="attachment_id" value="'+response[0].attachment_id+'"></td>'+
				        '</tr>'+
				        '<tr>'+
				            '<td class="row-title"><label for="tablecell">Short Description</label></td>'+
				            '<td><textarea id="short_desc" required name="short_desc" cols="80" rows="10">'+response[0].description+'</textarea></td>'+
				        '</tr>'+
				        '<tr >'+
				            '<td class="row-title"><label for="tablecell">Product Type</label></td>'+
				            '<td><select required id="product_type" name="product_type">'+
				                '<option value=""></option>'+
				                response[0].product_type+
				            '</select></td>'+
				        '</tr>'+
				        '<tr >'+
				            '<td class="row-title"><label for="tablecell">Frequency</label></td>'+
				            '<td><label title="g:i a">'+
				            	'<input type="radio" id="1" class="radio" '+anytime_selected+' name="example" value="" /> <span>Anytime</span></label>'+
								'&nbsp;&nbsp;&nbsp;<label title="g:i a">'+
								'<input type="radio" id="2" class="radio" '+schedule_freq_selected+' name="example" value="" /> <span>Scheduled</span></label>'+
								'<input type="hidden" id="frequency" name="frequency" value="'+response[0].frequency_value+'" /></td>'+
				        '</tr>'+
				        '<tr >'+
				            '<td class="row-title"><label for="serving_per_day">Serving per day</label></td>'+
				            '<td><select required id="serving_per_day_anytime"  name="serving_per_day_anytime" style="'+display_anytime+'" '+required_anytime+'>'+
				                '<option value="">Please select</option>'+
				                time_text+
				            '</select>'+
				            '<select required id="serving_per_day_scheduled" class="add_row_class" name="serving_per_day_scheduled" style="'+display_schedule+'" '+required_schedule+'>'+
				                '<option value="">Please select</option>'+schedule_text+
				                '</select></td>'+
				        '</tr>'+
				        '<tr id="add_table_weight">'+
            				bmi_text+
        				'</tr>'+
				        '<tr  >'+
        	'<td class="row-title"><label for="serving_size">Quantity per servings</label><input type="hidden" name="count" id="count" value="'+bmi.length+'"></td>'+
            '<td><input type="text" required id="serving_size" number name="serving_size" value="'+serving_size[0]+'" class="small-text" /></td>'+
     
            '<td  class="row-title"><label id="row_when" style="'+display_schedule+'" for="when">When</label></td>'+
            '<td><select '+required_schedule+' id="when" name="when" style="'+display_schedule+'" >'+
                when_text+'</select></td>'+
        '</tr>'+
        '<tr id="clone" >'+when_clone_text+'</tr>'+
				        '<tr><input type="hidden" id="clone_id" name="clone_id" value="" />'+
				            '<td class="row-title"><label for="serving_per_container">Serving per Container</label></td>'+
				            '<td><input type="text" required number id="serving_per_container" name="serving_per_container" value="'+response[0].serving_per_container+'" class="small-text" /></td>'+
				        '</tr>'+
				        '<tr>'+
				            '<td class="row-title"><label for="total">Total</label></td>'+
				            '<td><label id="total">'+response[0].total+'</label></td>'+
				        '</tr>'+
				    '</tbody>'+
				    
				'</table>'+

				'<br/>'+
				'<input class="button-primary" type="submit" name="save_edit" id="save_edit" value="Save" /> '+
				// '<input class="button-primary" type="button" name="cancel" id="cancel" value="Cancel" /> '+
				'</form>'+
				'</html>';

		$('#form_data').html(html);
		$('.custom_media_image').attr('src',response[0].image);
		if(when_clone_text!= ""){
			$('#clone_id').val(1);
		}
		// initialize validate plugin for product edit form
		$("#edit_product_form").validate({
			rules: {
			    serving_size: {
			      number: true
			    },
			    serving_per_container: {
			      number: true
			    },
			    serving_size_clone: {
			      number: true
			    }
			  },

		submitHandler: function(form) {
			console.log($('#edit_product_form').serialize());
			$.ajax({
				type : 'PUT',
				url : SITEURL+'/wp-json/products/'+$('#id').val(),
				//url : AJAXURL+'?action=update_product',
				data : $('#edit_product_form').serialize(),
				success:function(response){
					$('#response_msg').text('');
					$('#response_msg').text('Product was updated successfully');
					$('html, body').animate({
								scrollTop: 0
								}, 'slow');
					

				},
				error:function(error){

					$('#response_msg').text('');
					$('#response_msg').text('There was some problem updating the product');
					$('html, body').animate({
								scrollTop: 0
								}, 'slow')
				} 
			})
	}
		
		
	});
		

	}

	// submit updated product details
	// $('#save_edit').live('click',function(e){
	// 	e.preventDefault();
	// 	$.ajax({
	// 		type : 'POST',
	// 		url : SITEURL+'/wp-json/products/update',
	// 		//url : AJAXURL+'?action=update_product',
	// 		data : $('#edit_product_form').serializeArray(),
	// 		success:function(response){
	// 			console.log(response);
	// 		},
	// 		error:function(error){
	// 			console.log(error);
	// 		} 
	// 	});
	// })

	function upload_image(){
		//plupload to attach the image and return attachment id
		var uploader = new plupload.Uploader({
			browse_button: 'browse', // this can be an id of a DOM element or the DOM element itself
			url: 'UPLOADURL',
			runtimes : "gears,html5,flash,silverlight,browserplus",
	        file_data_name : "async-upload",
	        multiple_queues : true,
	        multipart : true,
	        urlstream_upload : true,
	        max_file_size : "10mb",
	        url : UPLOADURL,
	        flash_swf_url : SITEURL + "/wp-includes/js/plupload/plupload.flash.swf",
	        silverlight_xap_url : SITEURL + "/wp-includes/js/plupload/plupload.silverlight.xap",
	        filters : [{
	            title : "Image files",
	            extensions : "jpg,gif,png"
	        }
	        ],
	        multipart_params :{
	            action : "upload-attachment",
	            _wpnonce : _WPNONCE
	        }
		});

		uploader.init();
		uploader.bind('FilesAdded', function(up, files) {
			var html = '';
			plupload.each(files, function(file) {
			    html += '<li id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></li>';
			});
			document.getElementById('filelist').innerHTML += html;
		});
	 
		uploader.bind('UploadProgress', function(up, file) {
	  		document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
		});
	 
		uploader.bind('Error', function(up, err) {
	  		document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
		});
	 
		// document.getElementById('start-upload').onclick = function() {
	 //  		uploader.start();
		// };
		$('#start-upload').live('click',function(event){
			uploader.start();

		});
		uploader.bind('FileUploaded', function(up, file, response) {
			response = JSON.parse(response.response);
	  		$('input[name="attachment_id"]').val(response.data.id);
	  		$('.uploaded-image').attr('src',response.data.sizes.thumbnail.url);
		});

	//plupload to attach the image and return attachment id
	}


	var files;
 
	// Add events
	$('input[type=file]').on('change', prepareUpload);
	 
	// Grab the files and set them to our variable
	function prepareUpload(event)
	{
	  files = event.target.files;
	}
	
	//function to import csv file
	$('#import_products_form').on('submit',function(event){
		event.preventDefault();
		// this.action = AJAXURL+'?action=import_csv';
		// console.log(this.action);
		var data = new FormData();
			$.each(files, function(key, value)
				{
					data.append(key, value);
				});
		console.log(data);
		$.ajax({
			type : 'POST',
			//url : SITEURL+'/api/v1/products',
			url : AJAXURL+'?action=import_csv&files',
			data : data,
			dataType: 'json',
        	processData: false, // Don't process the files
        	contentType: false, 
			success:function(data){
				console.log(data);
			} 
		});


	});

	//function to export data  csv file
	$('#export').click(function(event){
		this.href = AJAXURL+'?action=export_csv';
	});

	$('#settings_form').validate({
		rules: {
			    no_of_days: {
			      number: true
			    },
			    morning_from: {
			      number: true
			    },
			    morning_to: {
			      number: true
			    },
			    evening_from: {
			      number: true
			    },
			    evening_to: {
			      number: true
			    }
			  },

		submitHandler: function(form) {
			
			$.ajax({
				type : 'POST',
				url : SITEURL+'/wp-json/settings',
				//url : AJAXURL+'?action=update_product',
				data : $('#settings_form').serializeArray(),
				success:function(response){
					$('#response_msg').text('');
					$('#response_msg').text('Settings saved successfully');
					$('html, body').animate({
								scrollTop: 0
								}, 'slow')
				},
				error:function(error){
					$('#response_msg').text('');
					$('#response_msg').text('There was some problem');
					$('html, body').animate({
								scrollTop: 0
								}, 'slow')
				} 
			})
	}


	})
	
	$('.check_number').live('keypress',function(evt){

		var charCode = (evt.which) ? evt.which : evt.keyCode;
		// Added to allow decimal, period, or delete
		if (charCode == 110 || charCode == 190 || charCode == 46) 
			return true;
		
		if (charCode > 31 && (charCode < 48 || charCode > 57)) 
			return false;
	})


	

});