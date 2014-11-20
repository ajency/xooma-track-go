<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/jquery-1.8.3.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/bootstrap.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/bootstrap-formhelpers-countries.en_US.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/bootstrap-formhelpers-countries.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-photofy-2.0.43.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.cookie.js"></script>
<script src="https://connect.facebook.net/en_US/all.js" type="text/javascript"></script>
<script type="text/javascript">
	
	var images = [
			<?php 
				$args = array();
				if(isset($_GET['cat']) && is_numeric($_GET['cat']))
					$args['cat'] = $_GET['cat'];
					
				$args['post_status'] 	= 'publish';
				$args['orderby'] 		= 'rand';
				$args['posts_per_page'] = 46;
				$args['post_type'] 		= 'post';
				$args['tag__not_in'] 	= 80;
				
				//$testimonials = query_posts('post_status=publish&orderby=rand&posts_per_page=21&post_type=post' .  $cat_filter );
				$testimonials = query_posts($args);
				
				$ids = '';
				
				foreach($testimonials as $testimonial):
					
					//store current IDS
					$ids .= $testimonial->ID . ',';
					
					$cats = get_the_category($testimonial->ID);
					
					$user = get_userdata((int)$testimonial->post_author);
					$ailment = $product = $country = '';
					
					foreach($cats as $cat)
					{
						$link = site_url('app?cat=' . $cat->term_id . '&cat_name='. $cat->cat_name);
					
						$link = "<a href=\'$link\'>{$cat->name}</a>, ";
					
						if($cat->parent == 25)
						{
							$ailment .= $link;
						}
						if($cat->parent == 2)
						{
							$product .= $link;
						}
						if($cat->parent == 48)
						{
							$country = $link;
						}	
					}
					
					$img = array();
					
					if(has_post_thumbnail($testimonial->ID))
					{
						$img = wp_get_attachment_image_src(get_post_thumbnail_id($testimonial->ID));
					}	
					else
					{
						$user_db_id = get_user_meta($user->ID,'fb_id',true);
						$img[0] = "https://graph.facebook.com/$user_db_id/picture?width=150&height=150";
					}
								
					$content = addslashes($testimonial->post_content);
						
					$content = remove_line_breaks($content);						
						
					echo '{
							ImageUrl: "'.  $img[0] .'", 
							LinkUrl: "'. $img[0] .'", 
							HTML: "<div class=\'facebook_button\' style=\'   position: absolute; z-index: 99999; margin-left: 214px; \'></div><span><a href=\'' . get_permalink($testimonial->ID) .'\'><h4 class=\'testimonialTitle\'>'. addslashes($testimonial->post_title) .'</h4></a></span>Country</br> <span> '. $country . '</span>Product</br> <span> '. rtrim($product,', ') .' </span>Testimony</br> <span> '. rtrim($ailment,', ') . '</span><div class=\'slickscroll\'><div>'. $content .'</div><br /><a href=\'' . get_permalink($testimonial->ID) .'\'>Complete View</a></div>",
							Href : "' . get_permalink($testimonial->ID) .'"},';
				endforeach;
			 ?>
  			];

	var _filter_cat_ids = [];
	var _current_ids	= [<?php echo rtrim($ids,','); ?>];

	
	function addToPage() {

        // calling the API ...
        var obj = {
          method: 'pagetab',
          redirect_uri: 'http://mystory.xoomaworldwide.com/',
        };

        FB.ui(obj);
    }
	
	function fbs_click(width, height) {
		var leftPosition, topPosition;
		//Allow for borders.
		leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
		//Allow for title and status bars.
		topPosition = (window.screen.height / 2) - ((height / 2) + 50);
		var windowFeatures = "status=no,height=" + height + ",width=" + width + ",resizable=yes,left=" + leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY=" + topPosition + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no";
		u=location.href;
		t=document.title;
		window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer', windowFeatures);
		return false;
	}
	
  	jQuery(document).ready(function($){	
		
		if($.cookie('submitted') != 'undefined')
  			$.removeCookie('submitted', { path: '/' });	
	
	
		if (jQuery('#search-query').val() !='')
		{
			jQuery('#search_testimonials').click();
		}
		$('#ailment_dropdown,#product_dropdown').multiselect({
			 button: 'btn btn-small',
			 width: '140px'
		});
		
		$(window).load(function(){
			$.getScript("http://static.ak.fbcdn.net/connect.php/js/FB.Share", function(data, textStatus, jqxhr) {
			});
		});	
		
		FB.init({
			appId  : '101968866648981',
			status : true, // check login status
			cookie : true, // enable cookies to allow the server to access the session
			xfbml  : true  // parse XFBML
		});
		
		
		
		//text or video testimonial
		$('#vid_testimonial').change(function(){
			$('#vid-testimonial').slideToggle('fast',function(){
				if($('#vid-testimonial').is(':visible'))
					$('input[name="video_testimonial"]').rules('add',{required : true});
				else
					$('input[name="video_testimonial"]').rules('remove');
			});
		});
		
		$('#load_more_testimonial').live('click',function(){
			get_filtered_data(_current_ids,_filter_cat_ids);
		});	
	   
		
		$('.grid-logo,.grid-like,.grid-write').fadeIn();
			
		
		//facebook connect
		$('#connect-facebook').live('click',function(){
			FB.login(function(response) {
				if (response.authResponse) {
					FB.api('/me', function(response) {
						$('#myModal').find('#fb-login-alert').fadeOut();
						$('#myModal').find('.model-photo').find('span.btn-file').fadeOut();
						$('input[name="user_fb_id"]').val(response.id);
						$('#inputName').val(response.name);
						$('#inputEmail').val(response.email);
						$('#photo-preview').attr('src','https://graph.facebook.com/'+ response.id +'/picture?width=150&height=150');
						
						//remove pic validation rules
						$('input[name="profile_pic"]').rules('remove');
						
					});
				} 
			},{scope: 'email,user_photos'});		
		});
		
		$('#ailment_dropdown').next('btn-group').find('.dropdown-menu').find('input[type="checkbox"]').change(function(){
			$('#ailment_dropdown').parent().find('label').remove();
		});
  				
  	  	$('#submit-testimonial').validate({
			ignore: "",
			errorClass : 'xm_error',
			rules : {
				'xm_id' : {
					minlength : 6,
					maxlength : 6,
					number    : true,
					required  : true	
				},
				'xmname' : 'required',
				'email' : {
					required : true,
					email : true
				},
				/*
				'profile_pic' : { 
					required: true, 
					accept: 'png|jpeg|jpg'
				},*/	
				'country' : 'required',
				'product' : 'required',
				'ailment' : 'required',						
				'testimonial' : 'required'
			},
			messages: {
				'country': {
					required: "Please select your country!"
			   	}			   
			},
			submitHandler : function(form){
				if($('#ailment_dropdown').val() == null)
				{
					$('#ailment_dropdown').parent().append('<label generated="true" class="xm_error" style="margin-top:0px">This field is required.</label>');
					return false;
				}
				if($('#product_dropdown').val() == null)
				{
					$('#product_dropdown').parent().append('<label generated="true" class="xm_error" style="margin-top:0px;margin-right:75px;">This field is required.</label>');
					return false;
				}
				
				form.submit();
			}
  	  	});	
		
		
		insert_empty_data();
		
  		jQuery("#photofy").photofy({
				imageSource: images,
				maxImages: 50,
				highlight: false,
				copyright: false,
				overlayTransparency: 0.4,
				shuffle : false,
				shuffleAtStart : false,
				fadeDuration: 0
		});

		add_video_icon(images);
  		
		jQuery('.single-filter .collapse').on('show', function () {
	
			jQuery(this).parent('.single-filter').find('.filter-toggle').addClass('open');
		})
				
		jQuery('.single-filter .collapse').on('hide', function () {
		
			jQuery(this).parent('.single-filter').find('.filter-toggle').removeClass('open');
		});


		jQuery('a.filter_testimonials').live('click',function(e){

			e.preventDefault();

			//set as selected
			jQuery(this).css({'color' : '#AAC93B' , 'font-weight' : 'bold'});
			
			var _cat_id = jQuery(this).attr('data-cat-id');

			_filter_cat_ids.push(_cat_id);

			var _cat = '<span class="myTag" id="cat_'+ _cat_id +'">'+
							'<span>'+ jQuery(this).html() +'&nbsp;&nbsp;</span>'+
							'<a href="#" class="myTagRemover" id="tagsk_Remover_'+ _cat_id +'" catidtoremove="'+ _cat_id +'" title="Remove">x</a>'+
						'</span>';
			
			jQuery('#category-filters').append(_cat);
			jQuery('#cat_'+ _cat_id).hide().fadeIn();
			
			get_filtered_data([],_filter_cat_ids);
					
  		});	

		<?php if(isset($_GET['cat']) && is_numeric($_GET['cat'])): ?>
			var _cat = '<span class="myTag" id="cat_<?php echo $_GET['cat'] ?>">'+
							'<span><?php echo $_GET['cat_name'] ?>&nbsp;&nbsp;</span>'+
							'<a href="#" class="myTagRemover" id="tagsk_Remover_<?php echo $_GET['cat'] ?>" catidtoremove="<?php echo $_GET['cat'] ?>" title="Remove">&times;</a>'+
						'</span>';
			
			jQuery('#category-filters').append(_cat);
			jQuery('#cat_<?php echo $_GET['cat'] ?>').hide().fadeIn();
		<?php endif; ?>	
			
		
  	});	

  	jQuery('a.myTagRemover').live('click',function(e){

  		e.preventDefault();

  		var cat_id = jQuery(this).attr('catidtoremove');

		//reset selected style
  		jQuery('#xm_cat_'+cat_id).css({'color' : '#005580' , 'font-weight' : 'normal'});

		get_filtered_ids(cat_id);

  		get_filtered_data([],_filter_cat_ids);

  		jQuery(this).parent().fadeOut('slow',function(){
  			jQuery(this).remove();		
  		});

  	});
  	

  	function get_filtered_ids(cat_id)
  	{
  		var _new_filter_ids = [];
  		
  		for( var i=0 ; i < _filter_cat_ids.length ; i++ )
  		{
			if(cat_id != _filter_cat_ids[i])
				_new_filter_ids.push(_filter_cat_ids[i]);
  		}

  		_filter_cat_ids = _new_filter_ids;

  	}


  	function get_filtered_data(_c_ids,_f_ids)
  	{
		if(_c_ids.length == 0)
			_c_ids = 'none';
			
		if(_f_ids.length == 0)
			_f_ids = 'none';
			
			
		
		jQuery('#spinner').css({
							width : jQuery('#photofy').width(),
							height : 1010
						}).show().find('div.spinner').height(jQuery(this).height());

		
  		/** make ajax call to get filtered testimonials */
		jQuery.post(ajaxurl,{
						action  	: 'xm_get_testimonials',
						cat_ids 	: _f_ids,
						current_ids : _c_ids,
						search_text : jQuery('#search-query').val(),
					},
					function(response)
					{
						//clear UI blocking
						jQuery('#spinner').hide();
						
						//set current ids
						_current_ids = 	response.ids;
						
						//clear images var
						images = [];

						images = response.data;

						insert_empty_data();
						
						//remove all 
						//jQuery('#photofy a.photofy_thumbnail').hide();// ('slow',function(){

						jQuery('#photofy a.photofy_thumbnail').remove();	
						
						jQuery("#photofy").photofy({
								imageSource: images,
								maxImages: 50,
								highlight: false,
								copyright: false,
								overlayTransparency: 0.4,
								shuffle : false,
								shuffleAtStart : false,
								fadeDuration: 0
						});

						//jQuery('#photofy a.photofy_thumbnail').show();
					
						add_video_icon(images);
						
					},'json'); 	
  	}
	
	function postToFeed(i) {

        // calling the API ...
        var obj = {
          method: 'feed',
          redirect_uri: 'http://mystory.xoomaworldwide.com',
          link: images[i].Href,
          picture: images[i].ImageUrl,
          name: '',
          caption: '',
          description: images[i].HTML
        };

        function callback(response) {
            //do nothing
        }

        FB.ui(obj, callback);
  	}  

	function add_video_icon(images)
  	{
  	  	var _video_testimonials = [];
  		for(var i = 0  ; i < images.length ; i++)
		{
			if(images[i].HTML.contains('<iframe'))
				_video_testimonials.push(i);	

			//add the like share button
			if(images[i].Href != null)
			{
				var ele = jQuery('a.photofy_thumbnail').eq(i);
				jQuery(ele).find('.facebook_button').append('<div class="fb-like" data-href="'+ images[i].Href +'" data-send="false" data-layout="standard" data-width="50" data-show-faces="false" data-colorscheme="dark" data-action="like"></div><br />');
			}			
		}
		//<a href="http://www.facebook.com/share.php?u='+ images[i].Href +'&app_id=101968866648981" onClick="return fbs_click(500, 200);" target="_blank" title="Share This on Facebook"><img src="/images/facebook3.png" alt="facebook share" width="64" height="24"></a>

  		if(_video_testimonials.length > 0)
  		{
	  		for(var i = 0  ; i < _video_testimonials.length ; i++)
	  		{
		  		var ele = jQuery('a.photofy_thumbnail').eq(_video_testimonials[i]);
				jQuery(ele).append('<div class="video_testimonial"></div>');
	  		}
  		}	
  	} 
  	

  	function insert_empty_data()
  	{
		var placeholder = theme_dir_uri + '/images/bck.gif';
  	  	
		if(_filter_cat_ids.length == 0)
		{
			if(images.length < 46) 
				$('#load_more_testimonial').show().html("Go back");
			else 
				$('#load_more_testimonial').show().html("Load More");
		}
		else
		{
			$('#load_more_testimonial').hide();
		}
			
		
		if(images.length >= 6 )
		{
			images.insert(6, {ImageUrl: placeholder, LinkUrl: '', HTML: '', Href : null});
		}
		{
		if(images.length >= 7 )
			images.insert(7, {ImageUrl: placeholder, LinkUrl: '', HTML: '', Href : null});
		}
		if(images.length >= 14 )
		{
			images.insert(14, {ImageUrl: placeholder, LinkUrl: '', HTML: '', Href : null});
		}
		if(images.length >= 17 )
		{
			images.insert(17, {ImageUrl: placeholder, LinkUrl: '', HTML: '', Href : null});
		}

		for(var i = images.length  ; i < 50 ; i++)
		{
			if((i != 6) || (i != 7) || (i != 14) || (i != 17))
				images.insert(i, {ImageUrl: placeholder, LinkUrl: '', HTML: '', Href : null});
		}
  	}

  	Array.prototype.insert = function (index, item) {
  	  this.splice(index, 0, item);
  	};
	
	String.prototype.contains = function(substr) {
  	  return this.indexOf(substr) > -1;
  	}
	
	function add_search_text()
	{
		if (jQuery('#search-query').val() !='')
		{
			var _search = '<span class="myTag" id="search_text">'+
							'<span>'+  jQuery('#search-query').val() +'&nbsp;&nbsp;</span>'+
							'<a href="#" class="mySearchTagRemover"  title="Remove">x</a>'+
						'</span>';
			 
			jQuery('#search-filters').html(_search);
			
			get_filtered_data([],_filter_cat_ids);
		}
	}
		
		jQuery('#search_testimonials').live('click',function(e){

			e.preventDefault(); 
			
			add_search_text();
			 
					
  		});	
		
		jQuery('a.mySearchTagRemover').live('click',function(e){

  		e.preventDefault();
		
		jQuery('#search-query').val('')
		
		get_filtered_data([],_filter_cat_ids);

  		jQuery(this).parent().fadeOut('slow',function(){
  			jQuery(this).remove();		
  		});

  	});
  	
	$('#search-query').bind("enterKey",function(e){
		e.preventDefault(); 
			
		add_search_text();
	});
	$('#search-query').keyup(function(e){ 
		if(e.keyCode == 13)
		{
		  $(this).trigger("enterKey");
		} 
		if(jQuery('#search-query').val() =='')
		{
			if ($("#search_text").length > 0){
				get_filtered_data([],_filter_cat_ids);
				
				jQuery('#search_text').fadeOut('slow',function(){
				jQuery('#search_text').remove();	
				});
			}				
		}
	});
</script>
</body>
</html>