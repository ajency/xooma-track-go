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
				url : "#{_SITEURL}/wp-json/history/#{App.currentUser.get('ID')}/products/#{product}"
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
		@ui.responseMessage.addClass('alert alert-danger').text("Data couldn't be loaded!")
		$('html, body').animate({
							scrollTop: 0
							}, 'slow')

	showData:(response)->
		coll = new Backbone.Collection response.response
		$('.name').text response.name.toUpperCase()
		html = ""
		arr = 0
		timezone = App.currentUser.get 'timezone'
		coll.each (index)->
			if index.get('meta_value').length != 0 && response.name.toUpperCase() != 'X2O'
				meta_value = index.get('meta_value')
				meta_id = index.get('meta_value')
				time = moment(meta_value.date+timezone, "HH:mm Z").format("hA")
				fromnow = moment(meta_value.date+timezone).fromNow()
				qty = meta_value.qty
				arr++
				html += '<li class="work"><div class="relative">
				      <label class="labels" class="m-t-20" for="work'+meta_id+'">'+qty+' CONSUMED</label>
				      <span class="date"><i class="fa fa-clock-o"></i> '+time+' <small class=""> ('+fromnow+' ) </small></span>
                    <span class="circle"></span>
				    </div><li>'
			else
				i = 0
				data = ViewProductHistoryView::getCount(index.get('meta_value'))
				$.each data , (ind,val)->
					i++
					time = moment(val.date+timezone, "HH:mm Z").format("hA")
					fromnow = moment(val.date+timezone).fromNow()
					qty = val.qty
					meta_id = parseInt(index.get('meta_id')) + parseInt(i) 
					arr++
					html += '<li class="work"><div class="relative">
					      <label class="labels" class="m-t-20" for="work'+meta_id+'">'+qty+' CONSUMED</label>
					      <span class="date"><i class="fa fa-clock-o"></i> '+time+' <small class=""> ('+fromnow+' ) </small></span>
	                    <span class="circle"></span>
					    </div><li>'

				


		if arr == 0
			html = '<li>No Consumption found for the current date.<li>'
		$('.viewHistory').html html
				
		
	getCount:(val)=>
		count = []
		if!(_.isArray(val)) 
			count.push date : val.date , qty : val.qty 
		else
			_.each val , (val1)->
				if _.isArray(val1)
					_.each val1 ,  (value)->
						count.push date : value.date , qty : value.qty
				else
					count.push date : val1.date , qty : val1.qty

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
		