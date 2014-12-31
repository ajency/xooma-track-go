class HomeOtherProductsView extends Marionette.ItemView

	template : '<div>dsfs</div>'


class HomeOtherProductsCtrl extends Ajency.RegionController

	initialize:->
		console.log "aaaaaaaaaaaaaaaaa"
		@show new HomeOtherProductsView

class HomeX2OView extends Marionette.ItemView

	template : '<div>dsfs</div>'


class HomeX2OCtrl extends Ajency.RegionController

	initialize:->
		console.log "aaaaaaaaaaaaaaaaa"
		@show new HomeX2OView
		

class HomeView extends Marionette.ItemView

	class : 'animated fadeIn'

	template : '#home-template'

	

class App.HomeCtrl extends Ajency.RegionController

	initialize:->
		@show new HomeView


	
