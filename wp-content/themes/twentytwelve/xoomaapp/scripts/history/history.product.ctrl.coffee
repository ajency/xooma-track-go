App.state 'ViewProductHistory',
					url : '/product/:id/history'
					parent : 'xooma'


class ProductHistoryChildView extends Marionette.ItemView

	tagName : 'li'

	className : '.work'

	template : '<div class="relative">
				      <label class="labels" class="m-t-20" for="work{{meta_id}}">{{qty}} CONSUMED</label>
				      <span class="date"><i class="fa fa-clock-o"></i>{{time}}<small class="">( {{fromnow}} ) </small></span>
                    <span class="circle"></span>
				    </div>'
	serializeData:->
		data = super()
		console.log meta_value = @model.get 'meta_value'
		timezone = App.currentUser.get 'timezone'
		data.time = moment(meta_value.date+timezone, "HH:mm Z").format("hA")
		console.log meta_value.date
		data.fromnow = moment([meta_value.date]).fromNow()
		data.qty = meta_value.qty
		data

class emptyChildView extends Marionette.ItemView

	template : 'No Consumption done for current date'


class ViewProductHistoryView extends Marionette.CompositeView

	template : '#view-history-template'

	childView : ProductHistoryChildView

	childViewContainer : 'ul.viewHistory'

	emptyView : emptyChildView


	onShow:->
		$( '#picker_inline_fixed' ).pickadate
			onOpen:->
				scrollPageTo( @$node )
			,
			onClose:->
				$( 'body' ).css( 'overflow', '' )

	serializeData:->
		data  = super
		name = Marionette.getOption( @, 'name' )
		data.name = name.toUpperCase()
		data


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
		product = model
		date = moment().format("YYYY-MM-DD")
		$.ajax
			method : 'GET'
			data : 'date='+date
			url : "#{_SITEURL}/wp-json/history/#{App.currentUser.get('ID')}/products/#{product}"
			success : @successHandler
			error : @errorHandler	

	successHandler:(response,status,xhr)=>
		console.log coll = new Backbone.Collection response.response
		console.log response.name
		arrColl = []
		coll.each (item)->
			if item.get('meta_value').length != 0
				arrColl.push meta_id:item.get('item') , meta_value : item.get('meta_value') 
		console.log temp = new Backbone.Collection arrColl
		@show new ViewProductHistoryView
				collection : temp
				name   : response.name