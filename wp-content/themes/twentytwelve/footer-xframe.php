<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/jquery-1.8.3.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/bootstrap.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-photofy-2.0.43.js" type="text/javascript"></script>
<script>
function xww_xframe_photofly(){
	xframeData = <?php xww_xframe_get_testimonials();?>;
//clear images var
	images = [];
	images =  xframeData.data;//jsonencoded posts array
	insert_empty_data();
	jQuery('#photofy a.photofy_thumbnail').remove();	
	jQuery("#photofy").photofy({
			imageSource: images,
			maxImages: 50,
			highlight: false,
			copyright: false,
			overlayTransparency: 0.4,
			shuffle : false,
			shuffleAtStart : false,
			fadeDuration: 0,
			select:function (obj, ui){
				
				var testimonial_url = jQuery(ui).find('.xww-xframe-url').attr('href');
				if(testimonial_url)
					window.open(testimonial_url,'_blank');
				return false;
			}
	});
	//add_video_icon(images);
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
			jQuery(ele).find('.facebook_button').append('<div class="fb-like" data-href="'+ images[i].Href +'" data-send="false" data-layout="standard" data-width="50" data-show-faces="false" data-colorscheme="light" data-action="like"></div><br />');
		}			
	}
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
	
	if(images.length < 46) 
		$('#load_more_testimonial').hide();
	else
		$('#load_more_testimonial').show();
	
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

jQuery(document).ready(function(){
	xww_xframe_photofly();
	jQuery('.grid-logo,.grid-like,.grid-write').fadeIn();
});		
</script>
</body>
</html>
 