notificationIdAndBadgeValue = []
_.mixin


	setNotificationTime : ()->
		current_time = moment().format("HH:mm")

		getNotificationTime = $("#timeupdate").val();
		time_selected = moment(getNotificationTime,"HH:mm").format("HH:mm")
		today = new Date()
		date = "#{today.getFullYear()}-#{today.getMonth()+1}-#{today.getDate()}"

		laterDate = moment(date+" "+getNotificationTime)

		convertTo12hourFormat = laterDate.format('hh:mm:ss A');

		dateValue = laterDate.toDate()

		scheduledTime = dateValue.getTime();
		timeDifference = moment(current_time,"HH:mm").diff(moment(time_selected,"HH:mm"))

		if timeDifference <= 0
			
			badgeValue = window.plugin.notification.local.getDefaults().badge;

			time_for_notification = new Date(scheduledTime);
			window.plugin.notification.local.add
				id:         '4',
				autoCancel: true,
				title:      "Xooma Track & Go",
				message: 'Time Scheduled Gear up xooma time! ',
				date:    time_for_notification,
				json : JSON.stringify({ test: "Its Xooma Time!!", date: convertTo12hourFormat}),
				badge: badgeValue

			# cordova.plugins.notification.badge.set(1);
				

		else
			alert "Select a valid time"

		window.plugin.notification.local.ontrigger = (id, state, json)->
			console.log "ontrigger"
			badgeValue = badgeValue+1
			badge = {badge : badgeValue}
			if id is '4'
				window.plugin.notification.local.setDefaults(badge)
			
		return



	notificationCall : (id)->
		
		value = _.getNotificationBadgeNumber()
		ids = []
		badgeValues = []
		
		if not _.isNull(value)
			
			option = JSON.parse(value)

			collection = new Backbone.Collection option

			# badgeValue = _.chain(collection.where({'ids':id})).last().value().get('badgeValues');
			getId = _.chain(collection.where({'ids':id})).last().value()

			if _.isUndefined(getId) 
				badgeValue = 0;
				notificationIdAndBadgeValue.push { ids : id, badgeValues : badgeValue}
				_.setNotificationBadgeNumber(notificationIdAndBadgeValue);
			else
				badgeValue = getId.get('badgeValues');

			# if not badgeValue
			# 	badgeValue = 0;
			# 	notificationIdAndBadgeValue.push { ids : id, badgeValues : badgeValue}
			# 	_.setNotificationBadgeNumber(notificationIdAndBadgeValue);



		else
			badgeValue = window.plugin.notification.local.getDefaults().badge;
			
			notificationIdAndBadgeValue.push { ids : id, badgeValues : badgeValue}

			_.setNotificationBadgeNumber(notificationIdAndBadgeValue);


			# lengthOfOption = _.size(option)
			# for i in [0..lengthOfOption-1] by 1

			# 	if _.has(option[i].ids, id)
			# 		badgeValue = option[i].badgeValues;
			# 		# notificationIdAndBadgeValue.push { ids : id, badgeValues : badgeValue}

			# 		# _.setNotificationBadgeNumber(notificationIdAndBadgeValue);

			# 	else
			# 		badgeValue = 0;
					
					
			# 		notificationIdAndBadgeValue.push { ids : id, badgeValues : badgeValue}

			# 		_.setNotificationBadgeNumber(notificationIdAndBadgeValue);
		# 	forEach = (values, i)->
		# 		if values.ids is id
		# 			badgeValue = values.badgeValues;
		# 			i = i+1
		# 			if i<lengthOfOption
		# 				forEach option[i], i
		# 			else
		# 				badgeValue = values.badgeValues;
						
		# 		else
		# 			i = i+1
		# 			if i<lengthOfOption
		# 				forEach option[i], i

		# 			else
		# 				badgeValue = 0;
		# 				notificationIdAndBadgeValue.push { ids : id, badgeValues : badgeValue}
		# 				_.setNotificationBadgeNumber(notificationIdAndBadgeValue);
		# 				return true


		# 	forEach option[0], 0
		
		# else
		# 	badgeValue = window.plugin.notification.local.getDefaults().badge;
		# 	# ids = ids[0]
		# 	# badgeValues = badgeValues[0]
			
		# 	notificationIdAndBadgeValue.push { ids : id, badgeValues : badgeValue}

		# 	_.setNotificationBadgeNumber(notificationIdAndBadgeValue);

		


		if badgeValue is 0
			notificationMessage = 'Gear up xooma time!'
		else
			notificationMessage = 'Gear up xooma time! '+ "                                     "+' ' + badgeValue + ' '

		newDate = new Date()

		date = "#{newDate.getFullYear()}-#{newDate.getMonth()+1}-#{newDate.getDate()}"

		convertToMilliSecs = newDate.getTime();

		#change secs to 60 once testing is done
		one_min = new Date(convertToMilliSecs + 3*1000);

		time = one_min.getHours()+':'+one_min.getMinutes()+':'+one_min.getSeconds()

		concatDateAndTime = moment(date+" "+time)

		convertTo12hourFormat = concatDateAndTime.format('hh:mm:ss A');


		window.plugin.notification.local.add
			id:         id,
			autoCancel: true,
			title:      "Xooma Track & Go for product"+id+"",
			message: notificationMessage,
			badge: badgeValue,
			json : JSON.stringify({ test: "Xooma Track & Go!!", date: convertTo12hourFormat}),
			date : time




		window.plugin.notification.local.ontrigger = (id, state, json)->
			ids = []
			badgeValues = []
			value = _.getNotificationBadgeNumber()
			console.log "ontrigger"

			
			option = JSON.parse(value)
			lengthOfOption = _.size(option)
			console.log notificationIdAndBadgeValue
			for i in [0..lengthOfOption-1] by 1
				if id is option[i].ids
					option[i].badgeValues = badgeValue+1

				
					badge = {badge : option[i].badgeValues}

					# ids = ids[i]
					# badgeValues = badgeValues[i]
					# if id is option.id
					window.plugin.notification.local.setDefaults(badge)
					console.log notificationIdAndBadgeValue
					notificationIdAndBadgeValue.push { ids : option[i].ids, badgeValues : option[i].badgeValues}
					# delete notificationIdAndBadgeValue[i];
					console.log notificationIdAndBadgeValue
					notificationIdAndBadgeValue.splice(i, 1);
					_.setNotificationBadgeNumber(notificationIdAndBadgeValue);
				
				# else if id is '2'
				# 	window.plugin.notification.local.setDefaults(badge)

				# else if id is '3'
			# 	window.plugin.notification.local.setDefaults(badge)
			
		







	# notificationCallForBadgeValues : (id)->

	# 	badgeValue = window.plugin.notification.local.getDefaults().badge;
	# 	scheduledTimeAfterEverySec = new Date().getTime();

	# 	_60_seconds_from_now = new Date(scheduledTimeAfterEverySec + 60*1000);

	# 	if badgeValue is 0
	# 		notificationMessage = 'Gear up xooma time!'
	# 	else
	# 		notificationMessage = 'Gear up xooma time! '+ "                                     "+' ' + badgeValue + ' '
		

	# 	window.plugin.notification.local.add
	# 		id:         id,
	# 		autoCancel: true,
	# 		title:      "Xooma Track & Go for product"+id+"",
	# 		message: notificationMessage,
	# 		badge: badgeValue,
	# 		json: JSON.stringify({ test: "Its Xooma Time!!"})

	# 	window.plugin.notification.local.ontrigger = (id, state, json)->
	# 		console.log "ontrigger"
	# 		# window.plugin.notification.local.cancel(id, ->
	# 		# 		alert "cancelled"
	# 		# 	)
	# 		# cordova.plugins.notification.badge.set(badgeValue,
	# 		# 	id,
	# 		# 	JSON.parse(json).test)
				

	# 		badgeValue = badgeValue+1
	# 		badge = {badge : badgeValue}
	# 		window.plugin.notification.local.setDefaults(badge)


	# 	return