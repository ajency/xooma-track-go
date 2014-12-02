_.extend Marionette.Application::,

	appStates : {}

	state : (name, def = {})->
		@appStates[name] = def
		@

	registerStates : ->
		Marionette.RegionControllers.prototype.controllers = @
		_.extend Marionette.AppStates::, appStates : @appStates
		new Marionette.AppStates app : @

	controller : (name, ctrlPrototype)->
		if _.isFunction ctrlPrototype
			CtrlClass = ctrlPrototype
		else
			class CtrlClass extends Ajency.RegionController
			_.extend CtrlClass::, ctrlPrototype
			
		@[name] = CtrlClass
		@

