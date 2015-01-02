#This file has refrence to all the localstorage used

_.mixin

#Store the User data for logged in user
	setUserData : (userData)->
		window.localStorage.setItem "user_data", JSON.stringify(userData)

	getUserData : ->
		JSON.parse window.localStorage.getItem "user_data"

#Store the badge number for respective notification id
	setNotificationBadgeNumber : (Value)->
		window.localStorage.setItem "notification_value", JSON.stringify(Value)

	getNotificationBadgeNumber : ->
		window.localStorage.getItem "notification_value"

