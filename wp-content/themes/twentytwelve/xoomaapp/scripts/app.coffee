#start of the Application
jQuery(document).ready ($)->

	App.state 'login1'
		.state 'universities', url : '/universities/:type'

	App.addInitializer ->
		App.currentUser.set 'caps', 'access_login1' : true, 'access_universities' : true
		Backbone.history.start()
	
	App.start()
