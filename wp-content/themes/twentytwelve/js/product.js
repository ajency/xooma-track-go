jQuery(document).ready(function($) {

	//to initialize validate plugin
	$("#add_product_form").validate({
		submitHandler: function(form) {
    	

		
		$.ajax({
			type : 'POST',
			url : SITEURL+'/wp-json/products',
			data : $('#add_product_form').serializeArray(),
			success:function(response){
				$('.alert').remove();
				$('#response_msg').text('Product was created successfully');
				$('html, body').animate({
							scrollTop: 0
							}, 'slow')
			},
			error:function(error){
				console.log(error);
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

    	console.log(attachment);

        $('.custom_media_image').attr('src', attachment.url);
        $('.custom_media_url').val(attachment.url);
        $('.custom_media_id').val(attachment.id);

        wp.media.editor.send.attachment = send_attachment_bkp;
    }

    wp.media.editor.open();

    return false;       
}); 

	//event to load servings per day

	$('#frequency').live('change',function(event){

		if(parseInt(this.value) == 1){
			$('#serving_per_day_anytime').attr("required");
			$('#serving_per_day_scheduled').removeAttr("required");
			$('#when').removeAttr("required");
			$('#serving_per_day_anytime').show();
			$('#serving_per_day_scheduled').hide();
			$('#row_when').hide();
		}
		else{
			$('#serving_per_day_anytime').removeAttr("required");
			$('#serving_per_day_scheduled').attr("required");
			$('#when').attr("required");
			$('#serving_per_day_anytime').hide();
			$('#serving_per_day_scheduled').show();
			$('#row_when').show();
		} 

	});

	//to calculate the value based upon the size entered
	$('#serving_size').live('change',function(event){
		
		size = this.value == "" ? 0 : this.value;
		serving = $('#serving_per_container').val()== "" ? 0 : $('#serving_per_container').val();
		total =  parseInt(size) * parseInt(serving);
		$('#total').text(total);

		

	});

	//to calculate the value based upon the serving_per_container entered
	$('#serving_per_container').live('change',function(event){

		size = $('#serving_size').val() == "" ? 0 : $('#serving_size').val();
		serving = this.value == "" ? 0 : this.value;
		total =  parseInt(size) * parseInt(serving);
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

	// get all the products 
	load_products();
	function load_products(){
		
		$.ajax({
			type : 'GET',
			url : SITEURL+'/wp-json/products',
			//url : AJAXURL+'?action=get_products',
			data : "term_id=0",
			success:function(response){
				show_all_products(response);
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
			url : SITEURL+'/wp-json/products',
			//url : AJAXURL+'?action=get_products',
			data :'term_id='+this.id,
			success:function(response){
				console.log(response);
				show_edit_product(response);
				
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
		anytime_selected = parseInt(response[0].frequency_value) == 1 ? 'selected' : "";
		schedule_freq_selected = parseInt(response[0].frequency_value) == 2 ? 'selected' : "";
		time_text = "";
		when_text = "";
		schedule_text = "";
		time_schedule_text = "";
		schedule_array = new Array('Once','Twice');
		when_array = new Array('Morning before Meal','Morning with Meal','Evening before Meal','Evening with Meal');
		for (var i = 1 ; i <= 10; i++) {
			console.log
			time_set_selected = parseInt(response[0].time_set) == i ? 'selected' : "";
			time_text += '<option value="'+i+'" '+time_set_selected+'>'+i+'</option>';
		}
		$.each(schedule_array, function(index,value){
			schedule_selected = parseInt(response[0].time_set) == parseInt(index) + 1 ? 'selected' : "";
			schedule_text += '<option value="'+(parseInt(index) + 1)+'" '+schedule_selected+'>'+value+'</option>';
		});
		$.each(when_array, function(index,value){
			when_selected = parseInt(response[0].when) == parseInt(index) + 1 ? 'selected' : "";
			when_text += '<option value="'+(parseInt(index) + 1)+'" '+when_selected+'>'+value+'</option>';
		});
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
		html = "";
		html += '<html>'+
			'<h2>Edit Product</h2>'+
			'<form id="edit_product_form" enctype="multipart/form-data" method="POST">'+
				'<table class="widefat">'+
				    '<tbody>'+
				        '<tr>'+
				            '<td class="row-title"><label for="tablecell">Name</label></td>'+
				            '<td><input type="hidden" name="id" id="id" value="'+response[0].id+'" /><input name="name" id="name" required type="text" value="'+response[0].name+'" class="regular-text" /></td>'+
				        '</tr>'+
				        '<tr >'+
				            '<td class="row-title"><label for="tablecell">Active</label></td>'+
				            '<td><input name="active" type="checkbox" id="active" value="'+response[0].active_value+'"  '+active+' /></td>'+
				            '<td><a href="#" class="custom_media_upload">Upload</a>'+
                				'<img class="custom_media_image" src="" />'+
                				'<input class="custom_media_url" type="hidden" name="attachment_url" value="">'+
                				'<input class="custom_media_id" type="hidden" name="attachment_id" value=""></td>'+
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
				            '<td class="row-title"><label for="tablecell">Frequncy</label></td>'+
				            '<td><select required id="frequency" name="frequency">'+
				                '<option value=""></option>'+
				                '<option  value="1" '+anytime_selected+' >Anytime</option>'+
				                '<option value="2" '+schedule_freq_selected+' >Scheduled</option>'+
				            '</select></td>'+
				        '</tr>'+
				        '<tr >'+
				            '<td class="row-title"><label for="serving_per_day">Serving per day</label></td>'+
				            '<td><select required id="serving_per_day_anytime" name="serving_per_day_anytime" style="'+display_anytime+'" '+required_anytime+'>'+
				                '<option value=""></option>'+
				                time_text+
				            '</select>'+
				            '<select required id="serving_per_day_scheduled" name="serving_per_day_scheduled" style="'+display_schedule+'" '+required_schedule+'>'+
				                '<option value=""></option>'+schedule_text+
				                '</select></td>'+
				        '</tr>'+
				        '<tr id="row_when" style="'+display_schedule+'" '+required_schedule+'>'+
				            '<td class="row-title"><label for="when">When</label></td>'+
				            '<td><select required id="when" name="when">'+
				                '<option value=""></option>'+
				                when_text+
				                
				            '</select></td>'+
				        '</tr>'+
				        '<tr>'+
				            '<td class="row-title"><label for="serving_size">Serving Size</label></td>'+
				            '<td><input type="text" required id="serving_size" name="serving_size" value="'+response[0].serving_size+'" class="small-text" /></td>'+
				        '</tr>'+
				        '<tr>'+
				            '<td class="row-title"><label for="serving_per_container">Serving per Container</label></td>'+
				            '<td><input type="text" required id="serving_per_container" name="serving_per_container" value="'+response[0].serving_per_container+'" class="small-text" /></td>'+
				        '</tr>'+
				        '<tr>'+
				            '<td class="row-title"><label for="total">Total</label></td>'+
				            '<td><label id="total">'+response[0].total+'</label></td>'+
				        '</tr>'+
				    '</tbody>'+
				    
				'</table>'+

				'<br/>'+
				'<input class="button-primary" type="submit" name="save_edit" id="save_edit" value="Save" /> '+
				'<input class="button-primary" type="button" name="cancel" id="cancel" value="Cancel" /> '+
				'</form>'+
				'</html>';

		$('#form_data').html(html);
		$('.custom_media_image').attr('src',response[0].image);
		// initialize validate plugin for product edit form
		$("#edit_product_form").validate({
		submitHandler: function(form) {

			$.ajax({
				type : 'POST',
				url : SITEURL+'/wp-json/products/update',
				//url : AJAXURL+'?action=update_product',
				data : $('#edit_product_form').serializeArray(),
				success:function(response){
					console.log(response);
				},
				error:function(error){
					console.log(error);
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
	


	


});