App.state 'Faq',
				url : '/faq'
				parent : 'xooma'
							


class FaqView extends Marionette.ItemView

	template  : '#faq-template'




	
				
	
		




	








class App.FaqCtrl extends Ajency.RegionController
	initialize : (options = {})->
		console.log "aaaaaaaaaaaaaaaa"
		@show new FaqView
						






		
		