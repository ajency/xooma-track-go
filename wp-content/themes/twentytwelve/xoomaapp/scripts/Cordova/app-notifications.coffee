_.mixin

	setNotificationTime : ()->

		current_time = moment().format("HH:mm")

		getNotificationTime = $("#timeupdate").val();
		time_selected = moment(getNotificationTime,"HH:mm").format("HH:mm")
		today = new Date()
		date = "#{today.getFullYear()}-#{today.getMonth()+1}-#{today.getDate()}"

		laterDate = moment(date+" "+getNotificationTime)
		dateValue = laterDate.toDate()

		scheduledTime = dateValue.getTime();
		timeDifference = moment(current_time,"HH:mm").diff(moment(time_selected,"HH:mm"))

		if timeDifference <= 0
			time_for_notification = new Date(scheduledTime);
			window.plugin.notification.local.add
				id:         '3',
				title:      "Xooma Track & Go",
				message: 'Time Scheduled Gear up xooma time! ',
				date:    time_for_notification

			# cordova.plugins.notification.badge.set(1);


		else
			alert "Select a valid time"

		return




	notificationCall : (id)->
		
		if id is '1'
			badgeValue = window.plugin.notification.local.getDefaults().badge;
		else
			badgeValue = window.plugin.notification.local.getDefaults().badge;

		scheduledTimeAfterEverySec = new Date().getTime();

		_60_seconds_from_now = new Date(scheduledTimeAfterEverySec + 60*1000);

		window.plugin.notification.local.add
			id:         id,
			autoCancel: true,
			title:      "Xooma Track & Go for product"+id+"",
			message: 'Gear up xooma time!',
			badge: badgeValue,
			date:    _60_seconds_from_now



		window.plugin.notification.local.ontrigger = (id, state, json)->
			console.log "ontrigger"
			# window.plugin.notification.local.cancel(id, ->
			# 		alert "cancelled"
			# 	)
			# cordova.plugins.notification.badge.set(badgeValue);
			badgeValue = badgeValue+1
			badge = {badge : badgeValue}
			window.plugin.notification.local.setDefaults(badge)

		return