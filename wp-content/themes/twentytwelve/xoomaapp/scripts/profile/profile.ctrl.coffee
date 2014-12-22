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


class App.ProfileCtrlView extends Marionette.LayoutView
	className : 'animated fadeIn'
	template : '#profile-template'
	ui :
		ul : '.list-inline'
	events :
		'click @ui.ul li a' : 'preventClick'

	initialize : (options = {})->
		super options
		@listenTo App, 'state:transition:complete', @handleMenu

	preventClick : (evt)->
		evt.preventDefault()

	handleMenu : (evt, state, args)->
		url = "#/#{state.get 'computed_url'}"
		@ui.ul.find('a').removeAttr 'disabled'
		@$('a[href="'+url+'"]').parent()
			.siblings().removeClass 'active'
		@$('a[href="'+url+'"]').parent().addClass 'active'


class App.ProfileCtrl extends Marionette.RegionController
	initialize: (options)->
		@show new App.ProfileCtrlView
