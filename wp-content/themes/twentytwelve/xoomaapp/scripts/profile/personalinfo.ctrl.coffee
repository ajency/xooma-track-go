

class PersonalInfoView extends Marionette.ItemView
	template : 'Personal Info details here'


class XoomaApp.ProfileCtrl extends Ajency.RegionController



class XoomaApp.PersonalInfoCtrl extends Ajency.RegionController

	initialize : (options)->
		@show new PersonalInfoView