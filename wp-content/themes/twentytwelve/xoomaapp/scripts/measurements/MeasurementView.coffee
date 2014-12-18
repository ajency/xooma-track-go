
class ProfileMeasurementsView extends Marionette.ItemView

		template  : '#profile-measurements-template'

		className : 'animated fadeIn'

		onShow:->
			$("#element1").popover({
						html: true,
				});$("#element2").popover({
						html: true,
				});$("#element3").popover({
						html: true
				});$("#element4").popover({
						html: true
				});$("#element5").popover({
						html: true
				});$("#element6").popover({
						html: true
				});$("#element7").popover({
						html: true
				});$("#element8").popover({
						html: true
				});
			@cordovaEventsForModuleDescriptionView()

				
				
			$document = $(document);
			selector = '[data-rangeslider]';
			$element = $(selector);

			i = $element.length - 1 ;
			while i >= 0
				valueOutput $element[i]
				i--
		
			$document.on('change', 'input[type="range"]', (e)->
						valueOutput(e.target);
				);
			$element.rangeslider(
						
						polyfill: false,
						
						onSlide:  (position, value)->
								console.log('onSlide');
								console.log('position: ' + position, 'value: ' + value);
					 
						
						onSlideEnd: (position, value)->
								console.log('onSlideEnd');
								console.log('position: ' + position, 'value: ' + value);
						
				);
			$("#add_measurements").validate({

				submitHandler: (form)->


					$.ajax
							method : 'POST',
							url : _SITEURL+'/wp-json/measurements/128',
							data : $('#add_measurements').serialize(),
							success:(response)->
								console.log(response)
								if response.status == 404
									$('.response_msg').text "Something went wrong"
								else
									$('.response_msg').text "User details saved successfully"

							
							error:(error)->
								$('.response_msg').text "Something went wrong"

					return false;



			})

		valueOutput = (element) ->
			value = element.value
			output = element.parentNode.getElementsByTagName("output")[0]
			output.innerHTML = value
			return


		onPauseSessionClick : =>
			console.log 'Invoked onPauseSessionClick'
			Backbone.history.history.back()


			document.removeEventListener("backbutton", @onPauseSessionClick, false)

		
		
		cordovaEventsForModuleDescriptionView : ->
			# Cordova backbutton event
			navigator.app.overrideBackbutton(true)
			document.addEventListener("backbutton", @onPauseSessionClick, false)

			# Cordova pause event
			document.addEventListener("pause", @onPauseSessionClick, false)





						
					 
					
			


							

	
								

		