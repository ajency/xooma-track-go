App.state 'ViewProductHistory',
					url : '/product/:id/history'
					parent : 'xooma'



class ViewProductHistoryView extends Marionette.ItemView

	template : '#view-history-template'

	ui :
		responseMessage : '.aj-response-message'

	events:
		'click #show':->
			product = Marionette.getOption( @, 'id' )
			@loadData(product)

		'click .consume':(e)->
			e.preventDefault()
			product = Marionette.getOption( @, 'id' )
			product = Marionette.getOption( @, 'id' )
			date = moment($('#picker_inline_fixed').val()).format("YYYY-MM-DD")
			if $('#picker_inline_fixed').val() == ""
				date = moment().format("YYYY-MM-DD")
			
			model = App.useProductColl.findWhere({id:parseInt(product)})
			if model.get('name').toUpperCase() == 'X2O'
				App.navigate "#products/"+product+'/bmi/'+date , true
				
			else
				App.navigate "#products/"+product+'/consume/'+date , true
		
			
			

		



	onShow:->
		product = Marionette.getOption( @, 'id' )
		model = App.useProductColl.findWhere({id:parseInt(product)})
		if model == undefined
			App.currentUser.getUserProducts().done(@showView).fail @errorHandler
		else
			@loadView()

	showView:(collection)=>
		@loadView()

	loadView:()->
		product = Marionette.getOption( @, 'id' )
		date = moment($('#picker_inline_fixed').val()).format("YYYY-MM-DD")
		if $('#picker_inline_fixed').val() == ""
			date = moment().format("YYYY-MM-DD")
		
		model = App.useProductColl.findWhere({id:parseInt(product)})
		if model.get('name').toUpperCase() == 'X2O'
			$('.consume').attr('href' ,"#products/"+product+'/bmi/'+date )
			
		else
			$('.consume').attr('href' ,"#products/"+product+'/consume/'+date )
				
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

	loadData:(id)=>
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
				url : "#{APIURL}/history/#{App.currentUser.get('ID')}/products/#{product}"
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
		coll = new Backbone.Collection response.response
		$('.name').text response.name.toUpperCase()
		html = ""
		arr = 0
		d = new Date()
		n = -(d.getTimezoneOffset())
		
		timezone = App.currentUser.get 'offset'
		coll.each (index)->
			if index.get('meta_value').length != 0 && response.name.toUpperCase() != 'X2O'
				meta_value = index.get('meta_value')
				meta_id = index.get('meta_value')
				time = moment.utc(meta_value.date).zone(timezone).format("h:mm A")
				
				
				qty = meta_value.qty
				arr++
				html += '<li class="work'+meta_id+'"><div class="relative">
				      <label class="labels" class="m-t-20" for="work'+meta_id+'">'+qty+' CONSUMED</label>
				      <span class="date"><i class="fa fa-clock-o"></i> '+time+' <small class=""></small></span>
                    <span class="circle"></span>
				    </div><li>'
			else
				i = 0
				data = ViewProductHistoryView::getCount(index.get('meta_value'))
				$.each data , (ind,val)->
					i++
					time = moment.utc(val.date).zone(timezone).format("h:mm A")
					qty = val.qty
					meta_id = parseInt(index.get('meta_id')) + parseInt(i) 
					arr++
					html += '<li class="work'+meta_id+'"><div class="relative">
					      <label class="labels" class="m-t-20" for="work'+meta_id+'">'+qty+' CONSUMED</label>
					      <span class="date"><i class="fa fa-clock-o"></i> '+time+' <small class=""></small></span>
	                    <span class="circle"></span>
					    </div><li>'

				


		if arr == 0
			html = '<li>No consumption found for the selected date.<li>'
		$('.viewHistory').html html
				
		
	getCount:(val)=>
		count = []
		if! _.isArray(val)
			count.push date : val.date , qty : val.qty
		else
			$.each val , (ind,val1)->
				if!(_.isArray(val1)) 
					count.push date : val1.date , qty : val1.qty 
				else
					$.each val1, (ind,val2)->
						if _.isArray(val2)
							$.each val2 ,  (ind,val3)->
								count.push date : val3.date , qty : val3.qty
						else
							count.push date : val2.date , qty : val2.qty

		count	
		

			

	


	scrollPageTo:($node)->
		$( 'html, body' ).animate
                scrollTop: ~~$node.offset().top - 60
            , 150

            
            $( 'body' ).css( 'overflow', 'auto' )


class App.ViewProductHistoryCtrl extends Ajency.RegionController
	initialize : (options = {})->
		@show @parent().getLLoadingView()
		productId  = @getParams()
		products = []
		@_showView(productId[0])

	_showView:(model)->
		@show new ViewProductHistoryView
				id : model
		