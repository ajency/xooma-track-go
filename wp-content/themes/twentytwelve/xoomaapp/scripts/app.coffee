#start of the Application
jQuery(document).ready ($)->
	App.currentUser = window.currentUser
	App.currentUser.set 'caps','access_root1' : true,'access_login' : true, 'access_login1' : true
	App.addInitializer ->
		App.registerStates()
		Backbone.history.start()

	App.start()
