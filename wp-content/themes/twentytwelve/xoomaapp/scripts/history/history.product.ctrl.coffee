App.state 'ViewProductHistory',
					url : '/product/:id/history'
					parent : 'xooma'



class ViewProductHistoryView extends Marionette.ItemView

	template : '#view-history-template'

	events:
		'click #show':->
			product = Marionette.getOption( @, 'id' )
			@loadData(product)


	onShow:->
		product = Marionette.getOption( @, 'id' )
		@loadData(product)
		$( '#picker_inline_fixed' ).pickadate
			formatSubmit: 'yyyy-mm-dd'	
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
		console.log coll = new Backbone.Collection response.response
		$('.name').text response.name.toUpperCase()
		html = ""
		arr = 0
		timezone = App.currentUser.get 'timezone'
		coll.each (index)->
			if index.get('meta_value').length != 0
				meta_value = index.get('meta_value')
				meta_id = index.get('meta_value')
				time = moment(meta_value.date+timezone, "HH:mm Z").format("hA")
				fromnow = moment(meta_value.date+timezone).fromNow()
				qty = meta_value.qty
				if response.name.toUpperCase() == 'X2O'
					qty = parseInt(meta_value.qty)* 100 + '%'
				arr++
				html += '<li class="work"><div class="relative">
				      <label class="labels" class="m-t-20" for="work'+meta_id+'">'+qty+' CONSUMED</label>
				      <span class="date"><i class="fa fa-clock-o"></i> '+time+' <small class=""> ('+fromnow+' ) </small></span>
                    <span class="circle"></span>
				    </div><li>'

		if arr == 0
			html = '<li>No Consumption found for the current date.<li>'
		$('.viewHistory').html html
				
		
		
		

			

	


	scrollPageTo:($node)->
		$( 'html, body' ).animate
                scrollTop: ~~$node.offset().top - 60
            , 150

            
            $( 'body' ).css( 'overflow', 'auto' )


class App.ViewProductHistoryCtrl extends Ajency.RegionController
	initialize : (options = {})->
		productId  = @getParams()
		products = []
		@_showView(productId[0])

	_showView:(model)->
		@show new ViewProductHistoryView
				id : model
		