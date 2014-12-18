_.mixin


	cordovaHideSplashscreen : ->

		navigator.splashscreen.hide()


	enableCordovaBackbuttonNavigation : ->

		navigator.app.overrideBackbutton(true)
		
		document.addEventListener("backbutton", _.onDeviceBackButtonClick, false)



	disableCordovaBackbuttonNavigation : ->

		navigator.app.overrideBackbutton(false)


	onDeviceBackButtonClick : ->

		currentRoute = App.getCurrentRoute()
		console.log 'Fired cordova back button event for '+currentRoute

		if currentRoute is 'login' or currentRoute is 'profile/personal-info'
			navigator.app.exitApp()
		# else    
		# 	App.navigate('app-login', trigger: true)

		_.removeCordovaBackbuttonEventListener()



	removeCordovaBackbuttonEventListener : ->

		document.removeEventListener("backbutton", _.onDeviceBackButtonClick, false)


	
