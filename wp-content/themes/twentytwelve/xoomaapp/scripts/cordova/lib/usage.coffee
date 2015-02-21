#Usage
#Dependency - lodash/underscore, jQuery, jquery.storageapi, moment

do ->

	window.Usage    = window.Usage || {}
	_storage        = $.localStorage
	_track_for_days = 10 #Default

	getCurrentHour = ->
		moment().format 'HH'

	getCurrentDate = ->
		moment().format 'DD/MM/YYYY'

	formatHour = (hour)->
		moment(hour, 'HH').format 'HH'

	getDate = (dayOfWeek)->
		moment().day(dayOfWeek).format 'DD/MM/YYYY'

	inTrackingPeriod = ->
		statistics = _storage.get 'usage_statistics'
		lastDay = moment _.last(statistics).date, 'DD/MM/YYYY'
		today = moment getCurrentDate(), 'DD/MM/YYYY'
		# today = moment '07/03/2015', 'DD/MM/YYYY' #Testing
		before = today.isBefore lastDay
		same = today.isSame lastDay
		before or same


	#Time Slots (24Hrs)
	timeSlots = []
	for i in [0..23] by 1
		start = formatHour i
		end = formatHour i+1
		timeSlots[i] =
			start: start
			end: end
			instances: 0


	inSlot = (hour)->
		slot = null
		_.each timeSlots, (timeSlot, index)->
			startTime = timeSlot.start
			if startTime is hour
				slot = index
		slot


	#
	setTimeSlot = ->
		days = _track_for_days
		dayOfWeek = moment().day()
		statistics = []

		for i in [0..days-1] by 1
			statistics[i] = 
				date: getDate dayOfWeek+i
				# timeSlots: _.cloneDeep timeSlots #If using lodash
				timeSlots: JSON.parse JSON.stringify timeSlots #If using underscore


		statistics[0]
			.timeSlots[inSlot(getCurrentHour())]
			.instances = 1
		_storage.set 'usage_statistics', statistics


	updateTimeSlot = ->
		statistics = _storage.get 'usage_statistics'
		_.each statistics, (usage, index)->

			if usage.date is getCurrentDate()
				slot = inSlot getCurrentHour()
				count = statistics[index].timeSlots[slot].instances
				statistics[index].timeSlots[slot].instances = count+1

		Usage.reset()
		_storage.set 'usage_statistics', statistics

	
	addInstances = (obj)->
		sum = 0
		_.each obj, (value)->
			sum = sum + value.instances
		sum


	get3MaxTimeSlots = (obj)->
		max3TimeSlots = []
		max3TimeSlots[0] = _.max obj, (num)->
			num.instances

		obj = _.reject obj, (num)->
			num.start == max3TimeSlots[0].start

		max3TimeSlots[1] = _.max obj, (num)->
			num.instances

		obj = _.reject obj, (num)->
			num.start == max3TimeSlots[1].start

		max3TimeSlots[2] = _.max obj, (num)->
			num.instances

		max3TimeSlots


	getBestTimes = ->
		#Return max 3 best time slots to send notifications
		statistics = _storage.get 'usage_statistics'
		maxInstanceTimeSlots = []

		_.each statistics, (usage, index)->
			maxInstanceTimeSlots[index] = _.max usage.timeSlots, (num)->
				num.instances

		maxInstanceTimeSlots = _.reject maxInstanceTimeSlots, (num)->
			num.instances == 0

		if _.size(maxInstanceTimeSlots) <=3 then maxInstanceTimeSlots
		else
			groupedFrequentTimeSlots = _.groupBy maxInstanceTimeSlots, (num)->
				num.start
			
			sumInstances = []
			_.each groupedFrequentTimeSlots, (groupedObj)->
				sumInstances.push
					start: groupedObj[0].start
					end: groupedObj[0].end
					instances: addInstances groupedObj

			if _.size(sumInstances) <=3 then sumInstances
			else get3MaxTimeSlots sumInstances


	notify = ->
		bestTimes = getBestTimes()
		size = _.size bestTimes
		index = _.random 0, size-1
		bestTime = bestTimes[index]
		time = "#{bestTime.start}:30"

		_storage.set 'usage_trigger_date', getCurrentDate()
		Usage.notify.trigger '$usage:notification', notificationTime: time


	triggerUsageEvent = ->
		lastTriggerDate = _storage.get 'usage_trigger_date'
		# lastTriggerDate = '09/02/2015' #Testing
		if _.isNull lastTriggerDate
			notify()
		else
			#Notify user every 3 days with the best time of the day 
			#based on usage statistics
			lastDate = moment lastTriggerDate, 'DD/MM/YYYY'
			currentDate = moment getCurrentDate(), 'DD/MM/YYYY'
			difference = currentDate.diff lastDate, 'days'
			if difference > 2
				notify()


	checkTimeSlot = ->
		if _storage.isSet 'usage_statistics'
			if inTrackingPeriod()
				updateTimeSlot()
			else 
				triggerUsageEvent()
		else
			setTimeSlot()


	do (Usage)->

		Usage.track = (options={})->
			console.log 'Tracking Application Usage'
			days = options.days
			if days and (days is parseInt days, 10) and days isnt 0
				_track_for_days = options.days
			
			checkTimeSlot()


		Usage.reset = ->
			_storage.remove 'usage_statistics'
			_storage.remove 'usage_trigger_date'

		
		Usage.notify = $(window)

