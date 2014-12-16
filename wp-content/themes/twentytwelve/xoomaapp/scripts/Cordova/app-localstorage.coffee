_.mixin

	cordovaLocalStorage : ->

		_.localStorage = window.localStorage

	setNotificationBadgeNumber : (Value)->
		_.localStorage.setItem("notification_value", JSON.stringify(Value))

	getNotificationBadgeNumber : ->
		_.localStorage.getItem("notification_value")