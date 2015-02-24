App.state 'ViewMeasurementHistory',
					url : '/measurements/:id/history'
					parent : 'xooma'



class MeasurementHistoryView extends Marionette.ItemView

	template : '#measurement-history-template'

	ui :
		responseMessage : '.aj-response-message'

	events:
		'click #show':->
			product = Marionette.getOption( @, 'id' )
			@loadData(product)


	onShow:->
		product = Marionette.getOption( @, 'id' )
		@loadData(product)
		$('#picker_inline_fixed').datepicker({
		    inline: true,
		    dateFormat : 'yy-mm-dd'
		    changeYear: true,
		    changeMonth: true,
		    maxDate: new Date(),
		    onChangeMonthYear: (y, m, i)->
		    	d = i.selectedDay
		    	$('#picker_inline_fixed').datepicker('setDate', new Date(y, m - 1, d));
			     
			   
		    
		});

	loadData:(id)->
			product = id
			date = moment($('#picker_inline_fixed').val()).format("YYYY-MM-DD")
			if $('#picker_inline_fixed').val() == ""
				date = moment().format("YYYY-MM-DD")
			
			if !window.isWebView()
				$('.viewHistory').html '<li>Loading data<img src="'+_SITEURL+'/wp-content/themes/twentytwelve/xoomaapp/images/lodaing.GIF" width="70px"></li>'

			#Changes for Mobile
			if window.isWebView()
				$('.viewHistory').html '<li>Loading data<img src="./images/lodaing.GIF" width="70px"></li>'
			
			$.ajax
				method : 'GET'
				data : 'date='+date
				url : "#{_SITEURL}/wp-json/measurements/#{App.currentUser.get('ID')}/history"
				success : @successHandler
				error : @errorHandler


	successHandler:(response,status,xhr)=>
		if xhr.status == 200
			@showData(response)
		else
			@showErrorMsg()
			
	errorHandler:(response,status,xhr)=>
		@showErrorMsg()

	showErrorMsg:->
		window.removeMsg()
		@ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be loaded!")
		$('html, body').animate({
							scrollTop: 0
							}, 'slow')
		
	showData:(response)->
		if response.length != 0
			coll = response.response
			classarr = []
			$.each coll , (ind,val)->
				classarr[ind] = ""
				if ind == 'height'

					temparr = coll[ind].split('.')
					if temparr.length == 1
						temparr.push 0
					coll[ind]  = temparr[0]+"'"+temparr[1]+'"'
				if coll[ind] == ""
					coll[ind] = 'No data available'
					classarr[ind] = 'hidden'
			
			html = ""
			html += '<li><span class="circle"></span><span>Height : </span>'+coll.height+ '<span class="'+classarr['height']+'"> Ft/inches</span>'
			html += '<li><span class="circle"></span><span>Weight : </span>'+coll.weight+ '<span class="'+classarr['weight']+'"> lb</span></span>'
			html += '<li><span class="circle"></span><span>Neck : </span>'+coll.neck+ '<span class="'+classarr['neck']+'"> inches</span>'
			html += '<li><span class="circle"></span><span>Chest : </span>'+coll.chest+ '<span class="'+classarr['chest']+'"> inches</span>'
			html += '<li><span class="circle"></span><span>Arm : </span>'+coll.arm+ '<span class="'+classarr['arm']+'"> inches</span>'
			html += '<li><span class="circle"></span><span>Abdomen : </span>'+coll.abdomen+ '<span class="'+classarr['abdomen']+'"> inches</span>'
			html += '<li><span class="circle"></span><span>Waist : </span>'+coll.waist+ '<span class="'+classarr['waist']+'"> inches</span>'
			html += '<li><span class="circle"></span><span>Hips : </span>'+coll.hips+ '<span class="'+classarr['hips']+'"> inches</span>'
			html += '<li><span class="circle"></span><span>Thigh : </span>'+coll.thigh+ '<span class="'+classarr['thigh']+'"> inches</span>'
			html += '<li><span class="circle"></span><span>MidCalf : </span>'+coll.midcalf+ '<span class="'+classarr['midcalf']+'"> inches</span>'
		else
			html = '<li><span>No data available.Please go to settings and update your Progress Chart.</span></li>'
		$('.viewHistory').html html

				
		
		
		

			

	


	scrollPageTo:($node)->
		$( 'html, body' ).animate
                scrollTop: ~~$node.offset().top - 60
            , 150

            
            $( 'body' ).css( 'overflow', 'auto' )


class App.ViewMeasurementHistoryCtrl extends Ajency.RegionController
	initialize : (options = {})->
		@show @parent().getLLoadingView()
		productId  = @getParams()
		products = []
		@_showView(productId[0])

	_showView:(model)->
		@show new MeasurementHistoryView
				id : model
		