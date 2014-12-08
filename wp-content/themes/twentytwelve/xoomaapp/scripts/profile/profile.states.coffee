class XoomaApp.ProfileStates extends Marionette.AppStates
	appStates : 
		'profile' :
			url : '/profile/:id' 
		'personalInfo' : 
			url : '/personal-info'
			parent : 'profile'
		'measurements' : 
			url : '/measurements'
			parent : 'profile'
		