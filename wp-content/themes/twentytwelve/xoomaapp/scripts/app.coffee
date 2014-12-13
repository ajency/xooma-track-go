#start of the Application
(->
	document.addEventListener "deviceready", (->
		_.notificationCall()
		App.state("login").state("xooma",
			url: "/"
		).state "personalInfo",
			url: "/profile/personal-info"
			parent: "xooma"

		App.addInitializer ->
			Backbone.history.start()
			unless App.currentUser.isLoggedIn()
				App.navigate "/login", true
			else
				App.navigate "/", true
		window.plugin.notification.local.onclick = ()->
			App.navigate "/login", true
		App.start()
	), false
).call()