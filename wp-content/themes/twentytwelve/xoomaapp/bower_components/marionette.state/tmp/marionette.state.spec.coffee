afterEach ->
	window.statesCollection.set []
	window.location.hash = ''
	Backbone.history.stop()
	Backbone.history.handlers.length = 0


describe 'Marionette.Application', ->

	describe 'on before start', ->

		beforeEach ->
			setFixtures '<div ui-region>Region</div><div ui-region="named">Region</div>'
			@app = new Marionette.Application
			@app.start()

		it 'must identify regions based on ui-region attribute', ->
			expect(@app.dynamicRegion).toEqual jasmine.any Marionette.Region
			expect(@app.namedRegion).toEqual jasmine.any Marionette.Region

	describe 'when dynamic region is not setup', ->

		beforeEach ->
			setFixtures '<div ui-region="named">Region</div>'
			@app = new Marionette.Application

		it 'app.start() must throw error', ->
			expect( -> @app.start() ).toThrow()

describe 'Marionette.LayoutView', ->

	layoutView = null
	beforeEach ->
		class LV extends Marionette.LayoutView
			template : '<div>
							<div ui-region>Region</div>
							<div ui-region="named">Region named</div>
						</div>'

		layoutView = new LV
		layoutView.render()

	describe 'on render of layout view', ->
		it 'must identify regions based on ui-region', ->
			expect(layoutView.dynamicRegion).toEqual jasmine.any Marionette.Region
			expect(layoutView.namedRegion).toEqual jasmine.any Marionette.Region


describe 'Marionette.Region', ->

	beforeEach ->
		setFixtures sandbox()
		@region = new Marionette.Region el : '#sandbox'

	describe 'When seting the controller', ->

		beforeEach ->
			@region.setController 'CtrlClass'

		it 'must hold the ctrlclass property', ->
			expect(@region._ctrlClass).toEqual 'CtrlClass'


	describe 'When seting the controller states params', ->

		beforeEach ->
			@region.setControllerStateParams [12, 23]

		it 'must hold the _ctrlStateParams property', ->
			expect(@region._ctrlStateParams).toEqual [12, 23]








describe 'Marionette.RegionControllers', ->

	describe 'Lookup place for controllers', ->

		afterEach ->
			Marionette.RegionControllers::controllers = {}

		describe 'When the object is defined', ->

			beforeEach ->
				Marionette.RegionControllers::setLookup window

			it 'must be define', ->
				expect(Marionette.RegionControllers::controllers).toEqual window

		describe 'When the object is not defined', ->

			it 'must throw', ->
				expect(-> Marionette.RegionControllers::setLookup xooma ).toThrow()



	describe 'when getting a region controller', ->

		describe 'when controller exists', ->

			beforeEach ->
				Marionette.RegionControllers::controllers =
										'LoginCtrl' : Marionette.RegionController.extend()

			it 'must not throw an error', ->
				expect( -> Marionette.RegionControllers::getRegionController 'LoginCtrl').not.toThrow()

		describe 'when controller is not present', ->
			it 'must throw an error', ->
				expect( -> Marionette.RegionControllers::getRegionController 'NoCtrl').toThrow()

describe 'Marionette.RegionController', ->

	describe 'when initializing the region controller', ->

		describe 'when region is not passed', ->

			it 'must throw an error', ->
				expect( -> new Marionette.RegionController ).toThrow()

		describe 'when region instance is passed', ->

			beforeEach ->
				setFixtures sandbox()
				@_region = new Marionette.Region el : '#sandbox'
				@regionCtrl = new Marionette.RegionController region : @_region

			it 'must have a unique controllerid', ->
				expect(@regionCtrl._ctrlID).toBeDefined()

			it 'must have _region property', ->
				expect(@regionCtrl._region).toEqual @_region

	describe 'when showing the view inside the region', ->

		beforeEach ->
			setFixtures sandbox()
			@_region = new Marionette.Region el : '#sandbox'
			@regionCtrl = new Marionette.RegionController region : @_region

		describe 'when view is not instance of Backbone.View', ->

			it 'must throw an error', ->
				regionCtrl = @regionCtrl
				expect(-> regionCtrl.show('abc')).toThrow()

		describe 'when view instance passed', ->

			beforeEach ->
				spyOn(@_region, 'show')
				spyOn(@regionCtrl, 'trigger')
				@view  = new Marionette.ItemView()
				@regionCtrl.show @view
				@view.trigger 'show'

			it 'must have _view property equal to view', ->
				expect(@regionCtrl._view).toEqual @view

			it 'must run show function on the passed region', ->
				expect(@_region.show).toHaveBeenCalledWith @view

			describe 'when the view is rendered on screen', ->

				it 'ctrl must tigger "view:rendered" event', (done)->
					_.delay =>
						expect(@regionCtrl.trigger).toHaveBeenCalledWith 'view:rendered', @view
						done()
					, 101

	describe 'When the view inside is destroyed', ->

		beforeEach ->
			@view  = new Marionette.ItemView()
			setFixtures sandbox()
			@_region = new Marionette.Region el : '#sandbox'
			@regionCtrl = new Marionette.RegionController region : @_region
			@regionCtrl.show @view
			@view.destroy()











describe 'Marionette.State', ->

	describe 'when initializing the State', ->

		describe 'when state name is not pased', ->

			it 'must throw an error', ->
				expect(-> new Marionette.State).toThrow()

		describe 'when state name is passed', ->

			beforeEach ->
				spyOn(Marionette.State::, 'on').and.callThrough()
				@state = new Marionette.State 'name' : 'stateName'

			it 'must listen to "change:parentStates" event', ->
				expect(@state.on).toHaveBeenCalledWith 'change:parentStates', @state._processParentStates

			it 'must have state name as ID', ->
				expect(@state.id).toBe 'stateName'

			it 'must have parentStates as an array', ->
				expect(@state.get 'parentStates').toEqual jasmine.any Array

			it 'must have the url property', ->
				expect(@state.get 'url').toBe '/stateName'

			it 'must have the parent property', ->
				expect(@state.get 'parent').toEqual false

			it 'must have the computed_url property', ->
				expect(@state.get 'computed_url').toBe 'stateName'

			it 'must have the url_to_array property', ->
				expect(@state.get 'url_to_array').toEqual ['/stateName']

			it 'must have the status property', ->
				expect(@state.get 'status').toBe 'inactive'

			it 'must have the ctrl property', ->
				expect(@state.get 'ctrl').toBe 'StateNameCtrl'

		describe 'when full options are passed', ->

			beforeEach ->
				@state = new Marionette.State
								'name' : 'stateName'
								'url' : '/customUrl'
								'ctrl' : 'MyCustomCtrl'
								'parent' : 'parentState'

			it 'must have state name as ID', ->
				expect(@state.id).toBe 'stateName'

			it 'must have the url property', ->
				expect(@state.get 'url').toBe '/customUrl'

			it 'must have the computed_url property', ->
				expect(@state.get 'computed_url').toBe 'customUrl'

			it 'must have the parent property', ->
				expect(@state.get 'parent').toEqual 'parentState'

			it 'must have the url_to_array property', ->
				expect(@state.get 'url_to_array').toEqual ['/customUrl']

			it 'must have the status property', ->
				expect(@state.get 'status').toBe 'inactive'

			it 'must have the ctrl property', ->
				expect(@state.get 'ctrl').toBe 'MyCustomCtrl'

	describe 'When parentStates property changes', ->

		beforeEach ->
			@parentState1 = new Marionette.State 'name' : 'parentState1'
			@parentState2 = new Marionette.State 'name' : 'parentState2', parent : 'parentState1'
			@state = new Marionette.State 'name' : 'stateName', parent : 'parenState2'
			@state.set 'parentStates', [@parentState2, @parentState1]

		it 'must have computed_url equal to /parentState1/parentState2/stateName', ->
			cUrl = 'parentState1/parentState2/stateName'
			expect(@state.get 'computed_url').toBe cUrl

		it 'must have url_to_array ', ->
			arr = ['/parentState1','/parentState2','/stateName']
			expect(@state.get 'url_to_array').toEqual arr

	describe 'when url has params', ->

		beforeEach ->
			@state = new Marionette.State
								'name' : 'stateName'
								'url' : '/customUrl/:someparam'

		it 'hasParams() must return true', ->
			expect(@state.hasParams()).toBe true








describe 'Application StateCollection', ->

	it 'window.statesCollection must be defined', ->
		expect(window.statesCollection).toEqual jasmine.any Marionette.StateCollection


describe 'Marionette.StateCollection', ->

	it 'must have Marionette.State as its model', ->
		expect(Marionette.StateCollection::model).toEqual Marionette.State

	describe 'Adding states', ->

		beforeEach ->
			@collection = new Marionette.StateCollection
			states  =
				'someState' : false
				'login' : url : '/login'
				'forgot-password':
					url : '/forgot-password'
					ctrl : 'ForgotPwdCtrl'
				'register' : url : '/register'

			_.each states, (def, name) => @collection.addState name, def

		afterEach ->
			@collection.set []

		it 'must add the states to collection', ->
			expect(@collection.length).toBe 4

		it 'all states must have name and url property',->
			@collection.each (state)->
				expect(state.has 'name').toBe true
				expect(state.has 'url').toBe true

describe 'Marionette.StateProcessor', ->

	beforeEach ->
		setFixtures '<div ui-region></div>'
		@app = new Marionette.Application
		@state = statesCollection.addState 'stateOne'
		@paramState = statesCollection.addState 'paramState',
													url : '/paramstate/:id'
													ctrl : 'ParamCtrl'
		Marionette.RegionControllers::controllers =
									'StateOneCtrl' : Marionette.RegionController.extend()

	afterEach ->
		Marionette.RegionControllers::controllers = {}

	describe 'When initializing the StateProcessor', ->

		describe 'when initializing without statemodel and Application instance', ->

			it 'must throw ', ->
				expect(-> new Marionette.StateProcessor ).toThrow()
				expect(=> new Marionette.StateProcessor state : @state).toThrow()

		describe 'When initializing with statemodel and regionContainer instance', ->

			beforeEach ->
				@stateProcessor = new Marionette.StateProcessor
													state : @state
													regionContainer : @app

			it 'must not throw', ->
				expect(=> new Marionette.StateProcessor state : @state, regionContainer : @app ).not.toThrow()

			it 'must have _state property', ->
				expect(@stateProcessor._state).toEqual @state

			it 'must have _deferred object', ->
				expect(@stateProcessor._deferred.done).toEqual jasmine.any Function

			it 'must have regionContainer object', ->
				expect(@stateProcessor._regionContainer).toEqual @app

		describe 'When processing a state', ->

			beforeEach ->
				class @StateCtrl extends Marionette.RegionController
					initialize : (options = {}) ->

				spyOn(Marionette.RegionControllers::, 'getRegionController').and.returnValue @StateCtrl
				spyOn(@StateCtrl::, 'initialize')
				@app.dynamicRegion = new Marionette.Region el : $('[ui-region]')
				@setCtrlSpy = spyOn(@app.dynamicRegion,'setController')
				@setCtrlParamSpy = spyOn(@app.dynamicRegion,'setControllerStateParams')
				@stateProcessor = new Marionette.StateProcessor
														state : @state
														regionContainer : @app

				spyOn(@stateProcessor, 'listenTo').and.callThrough()
				@promise = @stateProcessor.process()

			it 'must have _ctrlClass defined', ->
				expect(@stateProcessor._ctrlClass).toEqual @StateCtrl



describe 'Maroinette.AppStates', ->

	beforeEach ->
		@app = new Marionette.Application
		@inValidStates = "" : url : '/someurl'
		@validStates =
				"stateName" : url : '/someurl'
				"stateName2" : url : '/statenameurl/:id'
				"stateName3" : url : '/statename3', parent : 'stateName2'
				"stateName4" : url : '/statename4/:id', parent : 'stateName3'

	afterEach ->
		@app = null



	describe 'When initializing without the application object', ->
		it 'must throw ', ->
			expect(-> new Marionette.AppStates ).toThrow()

	describe 'When initializing with application object', ->
		beforeEach ->
			@app = new Marionette.Application
			spyOn(Marionette.AppStates::, '_registerStates').and.stub()
			spyOn(Marionette.AppStates::, 'on').and.stub()
			@appStates = new Marionette.AppStates app : @app

		it 'must have _app property', ->
			expect(@appStates._app).toEqual @app
		it 'must call _registerStates', ->
			expect(@appStates._registerStates).toHaveBeenCalled()
		it 'must reference the global statesCollection', ->
			expect(@appStates._statesCollection).toEqual window.statesCollection
		it 'must listen to "route" event',->
			expect(@appStates.on).toHaveBeenCalledWith 'route', @appStates._processStateOnRoute, @appStates

	describe 'Registering States', ->

		describe 'register state with no name ""', ->
			beforeEach ->
				MyStates = Marionette.AppStates.extend appStates : @inValidStates
			it 'must throw error', ->
				_app = @app
				expect(-> new MyStates app : _app).toThrow()

		describe 'Register state with valid definition', ->
			beforeEach ->
				@MyStates = Marionette.AppStates.extend appStates : @validStates
				spyOn(window.statesCollection, 'addState').and.callThrough()
				@routeSpy = spyOn(Backbone.Router::, 'route').and.callThrough()
				@myStates = new @MyStates app : @app
				@childState = statesCollection.get 'stateName4'

			it 'must call statesCollection.addState', ->
				expect(window.statesCollection.addState).toHaveBeenCalledWith "stateName" , url : '/someurl'

	describe 'Getting parent states of child state', ->
		beforeEach ->
			@MyStates = Marionette.AppStates.extend appStates : @validStates
			spyOn(window.statesCollection, 'addState').and.callThrough()
			@routeSpy = spyOn(Backbone.Router::, 'route').and.callThrough()
			@myStates = new @MyStates app : @app
			@childState = statesCollection.get 'stateName4'
			@parentStates = @myStates._getParentStates @childState

		it 'must return the array of parent states', ->
			expect(@parentStates.length).toEqual 2
			#expect(@parentStates).toEqual [jasmine.any(Marionette.State)]


	describe 'Registering states with backbone router', ->
		beforeEach ->
			@MyStates = Marionette.AppStates.extend appStates : @validStates
			spyOn(window.statesCollection, 'addState').and.callThrough()
			@routeSpy = spyOn(Backbone.Router::, 'route').and.callThrough()
			@myStates = new @MyStates app : @app
			@childState = statesCollection.get 'stateName4'

		it 'must call .route() with path and state name', ->
			expect(@routeSpy).toHaveBeenCalledWith 'statenameurl/:id', 'stateName2', jasmine.any Function
			expect(@routeSpy).toHaveBeenCalledWith 'someurl', 'stateName', jasmine.any Function

	describe 'When processing a state', ->
		beforeEach ->
			@app = new Marionette.Application
			MyStates = Marionette.AppStates.extend appStates : @validStates
			@states = new MyStates app : @app

		describe 'When the state is not present', ->
			it 'must throw', ->
				expect( -> @states._processStateOnRoute 'stateName6', [1,2]	).toThrow()




































				# xdescribe 'When processing state', ->
				# 	beforeEach ->
				# 		statesCollection.addState 'stateName'
				# 		spyOn(Marionette.StateProcessor::, 'initialize')
				# 		@promise = @myStates._processStateOnRoute 'stateName', [23]
				# 		console.log @promise

				# 	it 'must call state processor with state model and regionContainer object',(done)->
				# 		@promise.done (stateProcessor)->
				# 			expect(stateProcessor.initialize).toHaveBeenCalledWith
				# 								state : jasmine.any Marionette.State
				# 								regionContainer : jasmine.any(Marionette.Application)
				# 								stateParams : [23]
				# 			done()

				# 	xit 'must call process function', ->
				# 		@promise.done (stateProcessor)=>
				# 			expect(@p).toHaveBeenCalled()



				# xdescribe 'When processing a child state', ->

				# 	beforeEach ->
				# 		MyStates = Marionette.AppStates.extend appStates : @validStates
				# 		@myStates = new MyStates app : @app
				# 		spyOn(Marionette.StateProcessor::, 'initialize').and.callThrough()
				# 		spyOn(Marionette.StateProcessor::, 'process').and.callFake ->
				# 			a = Marionette.Deferred()
				# 			a.resolve new Marionette.Object
				# 			a.promise()
				# 		@promise = @myStates._processStateOnRoute 'stateName3', [1,3]
				# 		console.log @promise

				# 	it 'must call Marionette.StateProcessor 3 times',->
				# 		expect(Marionette.StateProcessor::initialize.calls.count()).toBe 2

					# xit 'must call Marionette.StateProcessor in proper sequence 1', (done)->
					# 	state2 = statesCollection.get 'stateName2'
					# 	@promise.always ->
					# 		s = Marionette.StateProcessor::initialize.calls.argsFor(0)
					# 		expect(s).toEqual [
					# 					state : state2
					# 					regionContainer : @app
					# 					stateParams : [1]
					# 			]
					# 		done()

					# xit 'must call Marionette.StateProcessor in proper sequence 2', (done)->
					# 	state3 = statesCollection.get 'stateName3'
					# 	@promise.always ->
					# 		s = Marionette.StateProcessor::initialize.calls.argsFor(1)
					# 		expect(s).toEqual [
					# 				state : state3
					# 				regionContainer : jasmine.any Marionette.View
					# 				stateParams : []
					# 			]
					# 		done()

					# xit 'must call Marionette.StateProcessor in proper sequence 3', (done)->
					# 	state4 = statesCollection.get 'stateName4'
					# 	@promise.always ->
					# 		s = Marionette.StateProcessor::initialize.calls.argsFor(2)
					# 		expect(s).toEqual [
					# 				state : state4
					# 				regionContainer : jasmine.any Marionette.View
					# 				stateParams : [3]
					# 			]
					# 		done()










