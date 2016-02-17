App.state 'profile',
			url : '/profile'
			parent : 'xooma'
			data:
				arule : 'SOME:ACCESS;RULES:HERE'
				trule : 'SOME:TRANSITION;RUlES:HERE'

	.state 'userPersonalInfo',
			url : '/personal-info'
			parent : 'profile'

	.state 'userMeasurement',
			url : '/measurements'
			parent : 'profile'
	.state 'UserProductList',
					url : '/my-products'
					parent : 'profile'
	


class ProfileCtrlView extends Marionette.LayoutView
	className : 'animated fadeIn'
	template : '#profile-template'
	ui :
		ul : '.list-inline'
	events :
		'click @ui.ul li' : 'preventClick'

	initialize : (options = {})->
		super options
		@listenTo App, 'state:transition:complete', @handleMenu

	preventClick : (evt)->
		console.log $(evt.target).closest('li')
		$(evt.target).closest('li').removeClass 'done'
		$(evt.target).closest('li').addClass 'selected'
		$(evt.target).closest('li').siblings().removeClass 'selected'

	onShow:->
		if App.currentUser.get('ID') == undefined || App.currentUser.get('caps').administrator == true
			$('.profile-template').hide()
			$('.menulink').hide()

		
		@handleMenu
		# evt.preventDefault()

	handleMenu : (evt, state, args)->
		url = '#'+App.currentUser.get 'state'
		computed_url = '#'+window.location.hash.split('#')[1]
		if url == computed_url 
			@$('a[href="'+url+'"]').parent().addClass 'selected'
			@$('a[href="'+url+'"]').parent().unbind()
			@$('a[href="'+url+'"]').parent().find('a').css(cursor:'pointer')
			@$('a[href="'+url+'"]').parent().nextAll().bind('click',@disableEvent)
			@$('a[href="'+url+'"]').parent().nextAll().find('a').css(cursor:'default')
			@$('a[href="'+url+'"]').parent().prevAll().unbind()
			@$('a[href="'+url+'"]').parent().prevAll().find('a').css(cursor:'pointer')
			@$('a[href="'+url+'"]').parent().prevAll().removeClass 'selected'
			@$('a[href="'+url+'"]').parent().prevAll().addClass 'done'
		else if url == '#/home' && url != computed_url
			$('a[href="'+computed_url+'"]').parent().addClass 'selected'
			$('a[href="'+computed_url+'"]').parent().prevAll().addClass 'done'
			$('a[href="'+computed_url+'"]').parent().nextAll().addClass 'done'
			# $('.tag').addClass 'done'
		
		else if url != '#/home' && url != computed_url
			@$('a[href="'+url+'"]').parent().prevAll().find('a').css(cursor:'pointer')
			@$('a[href="'+url+'"]').parent().prevAll().removeClass 'selected'
			@$('a[href="'+url+'"]').parent().prevAll().addClass 'done'
			@$('a[href="'+url+'"]').parent().nextAll().bind('click',@disableEvent)
			@$('a[href="'+url+'"]').parent().nextAll().find('a').css(cursor:'default')
			@$('a[href="'+computed_url+'"]').parent().addClass 'selected'
			@$('a[href="'+computed_url+'"]').parent().removeClass 'done'
			@$('a[href="'+computed_url+'"]').parent().unbind()
			@$('a[href="'+computed_url+'"]').parent().find('a').css(cursor:'pointer')
			@$('a[href="'+url+'"]').parent().find('a').css(cursor:'default')
			@$('a[href="'+url+'"]').parent().bind('click',@disableEvent)
			
			
		

	disableEvent:(evt)->
		evt.preventDefault()
		return false;
		

	

	

class App.ProfileCtrl extends Marionette.RegionController
	initialize: (options)->
		@show new ProfileCtrlView

	