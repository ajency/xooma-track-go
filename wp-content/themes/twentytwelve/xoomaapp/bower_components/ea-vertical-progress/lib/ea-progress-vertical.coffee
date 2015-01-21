( ($)->
	root = @

	class EAProgressVertical 
		change : 0.1

		constructor :(parent,initial,type='fill',time=10000,breakArray=[0,100])->
			if breakArray[0] isnt 0
				breakArray.unshift 0
			if breakArray[breakArray.length-1] isnt 100
				breakArray.push 100
			@breakArray = breakArray
			@parent = parent
			@parent.html '<div class="ea-empty"></div><div class="ea-full"></div>'
			@progress = if not isNaN(initial) and initial <= 100 and initial >=0 then initial else 0
			time = if not isNaN(time) and time > 0 then time else 10000
			delay = time*@change/100
			@delay = if delay >= 0.05 then delay else 0.05
			@type = if type in ['fill','empty'] then type else 'fill' 
			@setProgressUI()


		startProgress : ->
			limit = if @type is 'fill' then 100 else 0
			@animateInterval = setInterval @animateBottle, @delay , @type , limit

		stopProgress : (returnBreak=false)->
			clearInterval @animateInterval
			if returnBreak
				returnValue = 0
				if @type is 'empty'
					i = 0
					while i < @breakArray.length - 1
						if @progress > @breakArray[i] and @progress < @breakArray[i + 1]
							returnValue = @breakArray[i + 1]
							break;
						i++
				else
					i = 0
					while i < @breakArray.length - 1
						if @progress > @breakArray[i] and @progress < @breakArray[i + 1]
							returnValue = @breakArray[i]						
							break;
						i++
				return returnValue
			else
				return @progress

		setProgress : (progress,slow=false)->

			progress = if not isNaN(progress) and progress <= 100 and progress >=0 then progress else 100

			if not slow 
				@progress = progress
				@setProgressUI()


			else if progress > @progress
				@animateInterval = setInterval @animateBottle, @delay , 'fill' , progress

			else
				@animateInterval = setInterval @animateBottle, @delay , 'empty' , progress

			return progress





			
		animateBottle : (direction='fill',limit=100)=>
			if (direction is 'fill' and @progress >= limit) or (direction is 'empty' and @progress <= limit)
				clearInterval @animateInterval
			else
				if direction is 'fill'
					@progress += @change
				else if direction is 'empty'
					@progress -= @change
				@setProgressUI()


		setProgressUI : ->
			empty = 100 - @progress
			full = @progress
			
			@parent.find('.ea-empty').css 'height', empty+'%'
			@parent.find('.ea-full').css 'height', full+'%'

	root.EAProgressVertical = EAProgressVertical

).call @,jQuery