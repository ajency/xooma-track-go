#Parse Keys
APP_ID     = '7yCBpn4nUCUZMV31PSCNETE3bdzTF8kbx7ESGWJ1'
CLIENT_KEY = 'UEkdQeVTf7lERGv8p0HnKCPrIIr3MXLtAZlU9r7M'
JS_KEY     = 'pIKddWWKvSdtM8IrsuyURRaHjxAPulgkvdHiQQzP'


#Load inline template
$("#inlineTemplate").load "inline-templates.html"

#Init
userData = CordovaStorage.getUserData()


#Xooma URL
APIURL   = 'http://www.xooma.ajency.in/wp-json'
_SITEURL = 'http://www.xooma.ajency.in'


#User capabilities
notLoggedInCaps = 
	'access_login': true
	'level_0': true


allSystemCaps = [ 'access_login', 'read', 'level_0', 'subscriber'
				, 'access_addproducts', 'access_asperbmi', 'access_editinventory', 'access_editproducts'
				, 'access_home', 'access_profile', 'access_schedule', 'access_settings', 'access_usermeasurement'
				, 'access_userpersonalinfo', 'access_userproductlist', 'access_viewinventory'
				, 'access_viewmeasurementhistory', 'access_viewproducthistory', 'access_xooma'
				, 'edit_occurrence', 'edit_schedule', 'editproducts']


#Messages
Messages = x2oMessages = {}

if _.isNull CordovaStorage.getMessages()
	CordovaStorage.setMessages
		other: {"0":"Press on the bottle to hydrate","0.25":"Great start pal, you consumed 25% of the X2O. ","0.5":"Half full half empty 50% of the bottle consumed.","0.75":"Wow, you are about to finish!  75% of the bottle consumed.","1":"Woolaa! You finished a bottle.Go ahead grab the next.","12AM-11AM":"timeslot1","11AM-4PM":"timeslot2","4PM-9PM":"timeslot3","9PM-12PM":"timeslot4","0_timeslot1":"Start your day the healthy way","25_timeslot1":"Cool! That's a right start","0_25_timeslot1":"Cool! That's a right start","25_50_timeslot1":"Don't worry no hurry","50_timeslot1":"Slow and steady wins the race","50_75_timeslot1":"Steady pal! You are gaining speed","75_timeslot1":"That's amazing fast pace","75_100_timeslot1":"That's amazing fast pace","100_timeslot1":"You are lightning fast! Aint you?","bonus_timeslot1":"Wow!You are speedaholic","0_timeslot2":"Long way to go. Gear up!","25_timeslot2":"Keep going","0_25_timeslot2":"Keep going","25_50_timeslot2":"Speed up! Time is running","50_timeslot2":"So far so good","50_75_timeslot2":"Great going my friend","75_timeslot2":"Wisely paced it is","75_100_timeslot2":"Wisely paced it is","100_timeslot2":"Applause! Amazingly quick","bonus_timeslot2":"Wow!You are speedaholic","0_timeslot3":"How did it get so late so soon?Get started","25_timeslot3":"Pal, you need to accelerate now","0_25_timeslot3":"Pal, you need to accelerate now","25_50_timeslot3":"Going slow.Doesn't matter supercharge now","50_timeslot3":"Going slow.Doesn't matter supercharge now","50_75_timeslot3":"Keep up the pace to put things in place","75_timeslot3":"Woohoo.. keep the boost going","75_100_timeslot3":"Woohoo.. keep the boost going","100_timeslot3":"Applause! Well done","bonus_timeslot3":"You might be awestruck at your self","0_timeslot4":"Never too late to stay healthy","25_timeslot4":"Time is always right to do what is right","0_25_timeslot4":"Time is always right to do what is right","25_50_timeslot4":"Time is always right to do what is righ","50_timeslot4":"Little hurry is all you need","50_75_timeslot4":"No stopping keep going","75_timeslot4":"Woohoo.. keep the boost going","75_100_timeslot4":"Woohoo.. keep the boost going","100_timeslot4":"Applause! Well done","bonus_timeslot4":"You might be awestruck at your self"}
		x2o: {"0":"Swipe down the bottle to consume","0.25":"Great start pal, you consumed 25% of the X2O. ","0.5":"Half full half empty 50% of the bottle consumed.","0.75":"Wow, you are about to finish!  75% of the bottle consumed.","1":"Woolaa! You finished a bottle.Go ahead grab the next.","12AM-11AM":"timeslot1","11AM-4PM":"timeslot2","4PM-9PM":"timeslot3","9PM-12PM":"timeslot4","0_timeslot1":"Start your day the healthy way","25_timeslot1":"Cool! That's a right start","0_25_timeslot1":"Cool! That's a right start","25_50_timeslot1":"Don't worry no hurry","50_timeslot1":"Slow and steady wins the race","50_75_timeslot1":"Steady pal! You are gaining speed","75_timeslot1":"That's amazing fast pace","75_100_timeslot1":"That's amazing fast pace","100_timeslot1":"You are lightning fast! Aint you?","bonus_timeslot1":"Wow!You are speedaholic","0_timeslot2":"Long way to go. Gear up!","25_timeslot2":"Keep going","0_25_timeslot2":"Keep going","25_50_timeslot2":"Speed up! Time is running","50_timeslot2":"So far so good","50_75_timeslot2":"Great going my friend","75_timeslot2":"Wisely paced it is","75_100_timeslot2":"Wisely paced it is","100_timeslot2":"Applause! Amazingly quick","bonus_timeslot2":"Wow!You are speedaholic","0_timeslot3":"How did it get so late so soon?Get started","25_timeslot3":"Pal, you need to accelerate now","0_25_timeslot3":"Pal, you need to accelerate now","25_50_timeslot3":"Going slow.Doesn't matter supercharge now","50_timeslot3":"Going slow.Doesn't matter supercharge now","50_75_timeslot3":"Keep up the pace to put things in place","75_timeslot3":"Woohoo.. keep the boost going","75_100_timeslot3":"Woohoo.. keep the boost going","100_timeslot3":"Applause! Well done","bonus_timeslot3":"You might be awestruck at your self","0_timeslot4":"Never too late to stay healthy","25_timeslot4":"Time is always right to do what is right","0_25_timeslot4":"Time is always right to do what is right","25_50_timeslot4":"Time is always right to do what is righ","50_timeslot4":"Little hurry is all you need","50_75_timeslot4":"No stopping keep going","75_timeslot4":"Woohoo.. keep the boost going","75_100_timeslot4":"Woohoo.. keep the boost going","100_timeslot4":"Applause! Well done","bonus_timeslot4":"You might be awestruck at your self"}
		date: null

do ->
	storedMessages = CordovaStorage.getMessages()
	Messages = storedMessages.other
	x2oMessages = storedMessages.x2o