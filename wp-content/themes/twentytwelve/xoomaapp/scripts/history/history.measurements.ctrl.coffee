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
		$( '#picker_inline_fixed' ).pickadate
			max : new Date()
			onOpen:->
				scrollPageTo( @$node )
			,
			onClose:->
				$( 'body' ).css( 'overflow', '' )

	loadData:(id)->
			console.log product = id
			date = moment($('#picker_inline_fixed').val()).format("YYYY-MM-DD")
			if $('#picker_inline_fixed').val() == ""
				date = moment().format("YYYY-MM-DD")
			$.ajax
				method : 'GET'
				data : 'date='+date
				url : "#{_SITEURL}/wp-json/measurements/#{App.currentUser.get('ID')}/history"
				success : @successHandler
				error : @errorHandler


	successHandler:(response,status,xhr)=>
		if xhr.status == 200
			@showData()
		else
			@showErrorMsg()
			
	errorHandler:(response,status,xhr)=>
		@showErrorMsg()

	showErrorMsg:->
		$('.alert').remove()
		@ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be loaded!")
		
	showData:(response)->
		if response.length != 0
			coll = response.response
			html = ""
			html += '<li><span>Height : </span>'+coll.height+ 'inches'
			html += '<li><span>Weight : </span>'+coll.weight+ 'lb'
			html += '<li><span>Neck : </span>'+coll.neck+ 'lb'
			html += '<li><span>Chest : </span>'+coll.chest+ 'inches'
			html += '<li><span>Arm : </span>'+coll.arm+ 'inches'
			html += '<li><span>Abdomen : </span>'+coll.abdomen+ 'inches'
			html += '<li><span>Waist : </span>'+coll.waist+ 'inches'
			html += '<li><span>Hips : </span>'+coll.hips+ 'inches'
			html += '<li><span>Thigh : </span>'+coll.thigh+ 'inches'
			html += '<li><span>MidCalf : </span>'+coll.midcalf+ 'inches'
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
		productId  = @getParams()
		products = []
		@_showView(productId[0])

	_showView:(model)->
		@show new MeasurementHistoryView
				id : model
		