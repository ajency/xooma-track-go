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
			@parent.html '<div class="empty"></div><div class="full"></div>'
			@progress = initial
			@time = time
			@delay = @time*@change/100
			@type = type


		startProgress : ->
			console.log @delay
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

		setProgress : (progress,speed='fast')->

			if speed is 'fast'
				@progress = progress
				@setProgressUI()


			else if progress > @progress
				@animateInterval = setInterval @animateBottle, @delay , 'fill' , progress

			else
				@animateInterval = setInterval @animateBottle, @delay , 'empty' , progress





			
		animateBottle : (direction='fill',limit=100)=>
			# console.log change
			if (direction is 'fill' and @progress >= limit) or (direction is 'empty' and @progress <= limit)
				console.log 's'
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
			
			# console.log @progress
			@parent.find('.empty').css 'height', empty+'%'
			@parent.find('.full').css 'height', full+'%'

	root.EAProgressVertical = EAProgressVertical

).call @,jQuery