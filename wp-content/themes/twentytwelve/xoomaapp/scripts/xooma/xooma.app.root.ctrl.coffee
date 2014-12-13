

class XoomaAppRootView extends Marionette.LayoutView
	className : 'animated zoomIn'
	template : '#xooma-app-template'
	
class ProfilePersonalInfoView extends Marionette.ItemView
	className : 'animated zoomIn'
	template : '#profile-personal-info-template'

class App.ProfilePersonalInfoCtrl extends Marionette.RegionController
	initialize: (options)->
		@show new ProfilePersonalInfoView

class ProfileMeasurementsView extends Marionette.ItemView
	className : 'animated zoomIn'
	template : '#profile-measurements-template'

class App.ProfileMeasurementsCtrl extends Marionette.RegionController
	initialize: (options)->
		@show new ProfileMeasurementsView

class App.XoomaCtrl extends Marionette.RegionController
	initialize: (options)->
		@show new XoomaAppRootView
