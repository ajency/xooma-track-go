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
		@$('#'+evt.target.id).parent().addClass 'selected'
		@$('#'+evt.target.id).parent().siblings().removeClass 'selected'
		# evt.preventDefault()

	handleMenu : (evt, state, args)->
		url = '#'+App.currentUser.get 'state'
		console.log computed_url = '#'+window.location.hash.split('#')[1]
		if url == computed_url
			@$('a[href="'+url+'"]').parent().addClass 'selected'
			@$('a[href="'+url+'"]').parent().unbind()
			@$('a[href="'+url+'"]').parent().find('a').css(cursor:'pointer')
			@$('a[href="'+url+'"]').parent().nextAll().bind('click',@disableEvent)
			@$('a[href="'+url+'"]').parent().nextAll().find('a').css(cursor:'default')
			@$('a[href="'+url+'"]').parent().prevAll().unbind()
			@$('a[href="'+url+'"]').parent().prevAll().find('a').css(cursor:'pointer')
			@$('a[href="'+url+'"]').parent().prevAll().removeClass 'selected'
		else
			@$('a[href="'+computed_url+'"]').parent().addClass 'selected'
		

	disableEvent:(evt)->
		evt.preventDefault()
		return false;
		

	

	

class App.ProfileCtrl extends Marionette.RegionController
	initialize: (options)->
		@show new ProfileCtrlView
