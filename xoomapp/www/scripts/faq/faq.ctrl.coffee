App.state 'Faq',
				url : '/faq'
				parent : 'xooma'
							


class FaqView extends Marionette.ItemView

	template  : '#faq-template'

	ui :
		faqlink : '.faqlink'

	events:
		'click @ui.faqlink':(e)->
			e.preventDefault()
			state = App.currentUser.get 'state'
			if state == '/home'
				App.navigate '#/home', trigger:true , replace :true
			else
				App.navigate '#'+App.currentUser.get('state'), trigger:true , replace :true




	
				
	
		




	








class App.FaqCtrl extends Ajency.RegionController
	initialize : (options = {})->
		console.log "aaaaaaaaaaaaaaaa"
		@show new FaqView
						






		
		