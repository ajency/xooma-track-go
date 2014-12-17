
class Marionette.StateProcessor extends Marionette.Object

	initialize : (options = {})->
		@_state = stateModel = @getOption 'state'
		@_regionContainer = _regionContainer = @getOption 'regionContainer'

		if _.isUndefined(stateModel) or (stateModel instanceof Marionette.State isnt true)
			throw new Marionette.Error 'State model needed'

		if _.isUndefined(_regionContainer) or (_regionContainer instanceof Marionette.Application isnt true and _regionContainer instanceof Marionette.View isnt true)
			throw new Marionette.Error 'regionContainer needed. This can be Application object or layoutview object'

		@_stateParams = if options.stateParams then options.stateParams else []
		@_parentCtrl = options.parentCtrl
		@_deferred = new Marionette.Deferred()

	process : ->
		_ctrlClassName = @_state.get 'ctrl'
		sections =


		_region = @_regionContainer.dynamicRegion

		promise =  @_runCtrl _ctrlClassName, _region, @_parentCtrl
		promise.done (ctrl)=>

			if ctrl instanceof Marionette.RegionController isnt true
				@_state.set 'status', 'resolved'
				@_deferred.resolve ctrl
				return

			promises = []
			_regionContainer = ctrl._region.currentView
			if @_state.has('sections')
				sections = @_state.get('sections')
				_.each sections, (section, regionName)=>
					_ctrlClassName = section['ctrl']
					if regionName is '@'
						_region = _regionContainer.dynamicRegion
					else
						_region = _regionContainer["#{regionName}Region"]
					promises.push @_runCtrl _ctrlClassName, _region, ctrl

			$.when(promises...).done (ctrls...)=>
				@_state.set 'status', 'resolved'
				@_deferred.resolve ctrl

		@_deferred.promise()

	_runCtrl : (_ctrlClassName, _region, _parentCtrl)->
		deferred = Marionette.Deferred()

		if _region instanceof Marionette.Region isnt true
			deferred.resolve false
			return deferred.promise()

		currentCtrlClass = if _region._ctrlClass then _region._ctrlClass else false
		ctrlStateParams = if _region._ctrlStateParams then _region._ctrlStateParams else false
		arrayCompare = JSON.stringify(ctrlStateParams) is JSON.stringify(@_stateParams)
		if currentCtrlClass is _ctrlClassName and arrayCompare
			@_ctrlInstance = ctrlInstance = _region._ctrlInstance
			@listenTo ctrlInstance, 'view:rendered', -> deferred.resolve ctrlInstance
			ctrlInstance.trigger "view:rendered", ctrlInstance._view
			return deferred.promise()

		# first empty the region for new controller
		_region.empty()

		@_ctrlClass = CtrlClass = Marionette.RegionControllers::getRegionController _ctrlClassName

		@_ctrlInstance = ctrlInstance = new CtrlClass
											region : _region
											stateParams : @_stateParams
											stateName : @_state.get 'name'
											parentCtrl : _parentCtrl

		_region.setController _ctrlClassName
		_region.setControllerStateParams @_stateParams
		_region.setControllerInstance ctrlInstance
		@listenTo ctrlInstance, 'view:rendered', -> deferred.resolve ctrlInstance
		return deferred.promise()

	getStatus : ->
		@_deferred.state()
