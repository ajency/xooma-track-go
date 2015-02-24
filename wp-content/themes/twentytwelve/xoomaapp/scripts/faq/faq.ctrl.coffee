App.state 'faq',
				url : 'faq'
				parent : 'xooma'			


class FaqView extends Marionette.ItemView

	template  : '#faq-template'




	
				
	onShow:->
		$('.menulink').hide()




	








class App.FaqCtrl extends Ajency.RegionController
	initialize : (options = {})->

		@show new FaqView
						






		
		