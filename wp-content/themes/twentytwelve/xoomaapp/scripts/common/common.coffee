_.extend Ajency.CurrentUser::,
	authenticates : (args...)->
	    _currentUser = this
	    _this = this
	    responseFn = (response, status, xhr) ->
	        if _.isUndefined(response.ID)
	            _currentUser.trigger "user:auth:failed", response
	            _this.trigger "user:auth:failed", response
	        else
	            authNS.localStorage.set "HTTP_X_API_KEY", xhr.getResponseHeader("HTTP_X_API_KEY")
	            authNS.localStorage.set "HTTP_X_SHARED_SECRET", xhr.getResponseHeader("HTTP_X_SHARED_SECRET")
	            currentUserNS.localStorage.set "userModel", response
	            _currentUser.set response
	            _currentUser.trigger "user:auth:success", _currentUser

	    if _.isString(args[0])
	        userData = args[1]
	        accessToken = args[2]
	        userLogin = "FB_" + userData.id
	        data =
	            user_login: userLogin
	            user_pass: accessToken
	            type: "facebook"
	            userData: userData

	        $.post "" + APIURL + "/authenticate", data, responseFn, "json"
	    else if _.isObject(args[0])
	    	$.post "" + APIURL + "/authenticate", args[0], responseFn, "json"  




class LoginView extends Marionette.ItemView
	template : '#login-template'
	className: 'text-center'
	initialize : (opts)->
		super opts
		@on 'show', @checkFbLoginStatus
	ui : 
		fbLoginButton : '.f-login-button'
	events : 
		'click @ui.fbLoginButton' : 'loginWithFacebook'
	loginWithFacebook : (evt)=>
		FB.login (response)=>
			if response.authResponse
				FB.api '/me', (user)=>
					@triggerMethod 'facebook:login:success', user, response.authResponse.accessToken
			else
				@triggerMethod 'facebook:login:cancel'
		, scope: 'email'

	checkFbLoginStatus : =>
		if @ui.fbLoginButton.length is 0
			return

class App.LoginCtrl extends Ajency.LoginCtrl
	initialize : ->
		loginView = new LoginView
		@listenTo loginView, 'facebook:login:success', @_facebookAuthSuccess
		@listenTo loginView, 'facebook:login:cancel', @_facebookAuthCancel
		@show loginView

	_facebookAuthSuccess : (args...)->
		App.currentUser.authenticate 'facebook', args...

	_facebookAuthCancel : ->
		App.currentUser.trigger 'user:auth:cancel'