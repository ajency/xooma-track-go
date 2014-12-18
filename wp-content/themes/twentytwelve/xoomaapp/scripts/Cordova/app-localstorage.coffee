#TODO: @Nikhil- Put Comments

_.mixin

	localStorage : ->
		window.localStorage

	setNotificationBadgeNumber : (Value)->
		@localStorage().setItem "notification_value", JSON.stringify(Value)

	getNotificationBadgeNumber : ->
		@localStorage().getItem "notification_value"