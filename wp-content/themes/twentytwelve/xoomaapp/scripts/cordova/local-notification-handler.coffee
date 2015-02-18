#Local notifications to increase user engagement in the app

	CordovaNotification = 

		schedule : (message, time)->

			window.plugin.notification.local.schedule
				id: '111'
				message: message
				date: @triggerDate time
				autoCancel: true
				icon: 'icon'
				smallIcon: 'icon'


		triggerDate : (time)->

			date = null
			hr = moment().hours()
			min = moment().minutes()
			triggerTime = moment time, 'HH:mm'
			currenttime = moment "#{hr}:#{min}", 'HH:mm'

			if triggerTime.isAfter currenttime
				currentDate = moment().format 'DD/MM/YYYY'
				date = moment "#{currentDate} #{time}", 'DD/MM/YYYY HH:mm'
			else
				#If triggerTime is before current time, set notification for next day.
				tomorrow = moment().add 1, 'd'
				nextDate = moment(tomorrow).format 'DD/MM/YYYY'
				date = moment "#{nextDate} #{time}", 'DD/MM/YYYY HH:mm'

			date.toDate()
