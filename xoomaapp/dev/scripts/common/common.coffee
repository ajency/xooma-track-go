App.state 'SignIn',
			url : '/signIn'
			parent : 'xooma'

	.state 'SignUp',
			url : '/signUp'
			parent : 'xooma'

App.LoginCtrl = Ajency.LoginCtrl
App.NothingFoundCtrl  = Ajency.NothingFoundCtrl
Ajency.CurrentUserView::template = '#current-user-template'
Ajency.LoginView::template = '#login-template'
Ajency.CurrentUserView::template = '#current-user-template'
Ajency.LoginView::template = '#login-template'

class SignInView extends Marionette.ItemView
	template : '#sign_in_template'
	class : 'animated fadeIn'

class SignUpView extends Marionette.ItemView
	template : '#sign_up_template'
	class : 'animated fadeIn'

class App.SignInCtrl extends Marionette.RegionController
	@show new SignInView

class App.SignUpCtrl extends Marionette.RegionController
	@show new SignUpView

_.extend Ajency.LoginView::,

	onShow:->
		App.trigger 'cordova:hide:splash:screen'
		$('.single-item').slick(
			dots: true,
			infinite: true,
			speed: 500,
			slidesToShow: 1,
			slidesToScroll: 1,
			autoplay: true,
  			autoplaySpeed: 2000,
		);

class Ajency.FormView extends Marionette.LayoutView
	behaviors : 
		FormBehavior : 
			behaviorClass : Ajency.FormBehavior

_.extend Ajency.CurrentUser::,

	loginCheck:->
		_successHandler= (resp)=>
			console.log "aaaaaaaaa"
		$.ajax
			method : 'POST'
			url : _SITEURL+'/wp-content/themes/twentytwelve/xooma-template.php?action=logout_user'
			success: _successHandler


	_getUrl : (property)->
		"#{APIURL}/users/#{App.currentUser.get('ID')}/#{property}"

	saveMeasurements : (measurements)->
		formdata = $.param measurements
		_successHandler = (resp)=>
			@set 'measurements', measurements
			App.currentUser.set 'weight' , measurements.weight

		$.ajax
			method : 'POST'
			url : @_getUrl 'measurements'
			data : formdata
			success: _successHandler

	getProfile : ()->
		deferred = Marionette.Deferred()

		_successHandler = (response, status,responseCode)=>
			@set 'profile', response
			deferred.resolve @

		if not @has 'profile'
			$.ajax
				method : 'GET'
				url : @_getUrl 'profile'
				success: _successHandler
		else
			deferred.resolve @

		deferred.promise()

	saveProfile : (profile)->

		_successHandler = (resp)=>
			if App.currentUser.get('caps').administrator == undefined
				@set 'profile', profile

		$.ajax
			method : 'PUT'
			url : @_getUrl 'profile'
			data : JSON.stringify profile
			success:_successHandler


	hasProfilePicture : ->
		return false unless @has 'profile_picture'
		profilePicture = @get 'profile_picture'
		(parseInt(profilePicture.id) isnt 0) or not _.isUndefined profilePicture.type

	addProduct : (id)->
		_successHandler = (response, status, xhr)=>
			if xhr.status is 201
				products = @get 'products'
				if typeof products == 'undefined'
					products = []
				products = _.union products, [response]
				@set 'products', products

		$.ajax
			method : 'POST'
			url : @_getUrl 'products'
			data : 'productId='+id
			success: _successHandler

	getUserProducts : ->
		date = ""
		if App.currentUser.get('homeDate') != undefined && App.currentUser.get('homeDate') != ""
		 	date = App.currentUser.get('homeDate')
		else
			console.log date =  ""
			
		_successHandler = (response, status, xhr)=>
			if xhr.status is 200
				data = response.response
				dates = response.graph['dates']
				param = response.graph['param']
				App.graph = new Backbone.Model
				App.currentUser.set 'weight', response.weight
				App.graph.set 'dates' , dates
				App.graph.set 'param' , param
				App.graph.set 'reg_date' , response.reg_date
				App.currentUser.set 'today', response.today
				App.currentUser.set 'homeDate' , response.homeDate
				products = []
				$.each data , (ind,val)->
					products.push parseInt(val.id)
					App.useProductColl.add val
				@set 'products', products


		$.ajax
			method : 'GET'
			data : 'date='+date
			url : @_getUrl 'products'
			success: _successHandler

	getHomeProducts : ->
		deferred = Marionette.Deferred()
		date = ""
		if App.currentUser.get('homeDate') != undefined && App.currentUser.get('homeDate') != ""
		 	date = App.currentUser.get('homeDate')
		else
			console.log date =  ""
			
			
		_successHandler = (response, status, xhr)=>
			data = response.response
			dates = response.graph['dates']
			param = response.graph['param']
			App.graph = new Backbone.Model
			App.currentUser.set 'weight', response.weight
			App.graph.set 'dates' , dates
			App.graph.set 'param' , param
			App.graph.set 'reg_date' , response.reg_date
			App.currentUser.set 'today', response.today
			App.currentUser.set 'homeDate' , response.homeDate
			if xhr.status is 200
				$.each data, (index,value)->
					App.useProductColl.add value
				deferred.resolve response

			
						

		$.ajax
			method : 'GET'
			data : 'date='+date
			url : "#{APIURL}/records/#{App.currentUser.get('ID')}"
			success: _successHandler


	
		deferred.promise()		



class Ajency.HTTPRequestFailView extends Marionette.ItemView
	
	template : 'Requested page not Found'


class Ajency.HTTPRequestCtrl extends Marionette.RegionController
	initialize: (options)->
		@show new Ajency.HTTPRequestFailView

