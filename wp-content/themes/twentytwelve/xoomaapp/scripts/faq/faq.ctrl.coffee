App.state 'Admin',
				url : '/user_id/:id'
				parent : 'xooma'
				


class FaqView extends Marionette.ItemView

	template  : '#faq-template'




	
				
	onShow:->
		$('.menulink').hide()




	








class App.FaqCtrl extends Ajency.RegionController
	initialize : (options = {})->

		@show new FaqView
						






		
		