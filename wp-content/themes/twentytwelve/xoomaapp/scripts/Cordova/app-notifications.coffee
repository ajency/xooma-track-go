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
				id:         '1',
				autoCancel: true,
				title:      "Xooma Track & Go",
				message: 'Time Scheduled Gear up xooma time! ',
				date:    time_for_notification

		else
			alert "Select a valid time"

		return




	notificationCall :->
		count = 0;
		scheduledTimeAfterEverySec = new Date().getTime();

		_60_seconds_from_now = new Date(scheduledTimeAfterEverySec + 60*1000);

		window.plugin.notification.local.add
			id:         '2',
			autoCancel: true,
			title:      "Xooma Track & Go",
			message: 'Gear up xooma time!',
			repeat:  'minutely',
			date:    _60_seconds_from_now

		return