#Parse Keys

#deepak@ajency.in
# APP_ID     = '7yCBpn4nUCUZMV31PSCNETE3bdzTF8kbx7ESGWJ1'
# CLIENT_KEY = 'UEkdQeVTf7lERGv8p0HnKCPrIIr3MXLtAZlU9r7M'
# JS_KEY     = 'pIKddWWKvSdtM8IrsuyURRaHjxAPulgkvdHiQQzP'

#zack@xooma.com
APP_ID     = 'fQBYzCQ6rmU8cTbwBUX5vFqtujZTugSmOPOvm2Tf'
CLIENT_KEY = 'reAavTNAeqb533EiuF0nAK2zl81Wk23gbTnRStz2'
JS_KEY     = 'GBtzJkx64pmyFbm93JMJFpwAfFKAhDoraeF7q5E0'


#Load inline template
$("#inlineTemplate").load "inline-templates.html"

#Init
userData = CordovaStorage.getUserData()
CordovaStorage.publishFeedDialog 'init'


#Xooma URL
#Test site
_SITEURL = 'http://www.xooma.ajency.in'
APIURL   = "#{_SITEURL}/wp-json"

#Live site
#_SITEURL = 'https://mystory.xoomaworldwide.com'
#APIURL   = "#{_SITEURL}/?json_route="



#User capabilities
notLoggedInCaps = 
    'access_login': true
    'access_xooma': true
    'access_signin': true
    'access_signup': true
    'level_0': true


allSystemCaps = [ 'access_login', 'read', 'level_0', 'subscriber', 'access_signin', 'access_signup'
                , 'access_addproducts', 'access_asperbmi', 'access_editinventory', 'access_editproducts'
                , 'access_home', 'access_profile', 'access_schedule', 'access_settings', 'access_usermeasurement'
                , 'access_userpersonalinfo', 'access_userproductlist', 'access_viewinventory'
                , 'access_viewmeasurementhistory', 'access_viewproducthistory', 'access_xooma'
                , 'edit_occurrence', 'edit_schedule', 'editproducts', 'access_faq']


#Messages
Messages = x2oMessages = {}

if _.isNull CordovaStorage.getMessages()
    CordovaStorage.setMessages
        other: {"0":"Swipe down the bottle to consume","0.25":"Great start pal, you consumed 25% of the X2O. ","0.5":"Half full half empty 50% of the bottle consumed.","0.75":"Wow, you are about to finish!  75% of the bottle consumed.","1":"Woolaa! You finished a bottle.Go ahead grab the next.","12AM-11AM":"timeslot1","11AM-4PM":"timeslot2","4PM-9PM":"timeslot3","9PM-12AM":"timeslot4","0_timeslot1":"It's time to say ahhh","25_timeslot1":"Off to a great start","0_25_timeslot1":"Off to a great start","25_50_timeslot1":"Off to a great start","50_timeslot1":"Off to a great start","50_75_timeslot1":"Consistent! I like that.","75_timeslot1":"Consistent! I like that.","75_100_timeslot1":"You're gonna like the way you feel today","100_timeslot1":"You're gonna like the way you feel today","bonus_timeslot1":"You're gonna like the way you feel today","0_timeslot2":"Ready when you are","25_timeslot2":"You're on a roll","0_25_timeslot2":"You're on a roll","25_50_timeslot2":"You're on a roll","50_timeslot2":"You're on a roll","50_75_timeslot2":"Getting close to your goal","75_timeslot2":"Getting close to your goal","75_100_timeslot2":"You're becoming a product of the product!","100_timeslot2":"You're becoming a product of the product!","bonus_timeslot2":"You're becoming a product of the product!","0_timeslot3":"Good health awaits you","25_timeslot3":"It's Xooma Time!","0_25_timeslot3":"It's Xooma Time!","25_50_timeslot3":"It's Xooma Time!","50_timeslot3":"It's Xooma Time!","50_75_timeslot3":"Keep up the momentum","75_timeslot3":"Keep up the momentum","75_100_timeslot3":"Your body thanks you","100_timeslot3":"Your body thanks you","bonus_timeslot3":"Your body thanks you","0_timeslot4":"Don't leave me in the bottle","25_timeslot4":"You are starting it right!","0_25_timeslot4":"You are starting it right!","25_50_timeslot4":"You are starting it right!","50_timeslot4":"You are starting it right!","50_75_timeslot4":"Cheers to great health","75_timeslot4":"Cheers to great health","75_100_timeslot4":"Fully fortified for the day!","100_timeslot4":"Fully fortified for the day!","bonus_timeslot4":"Fully fortified for the day!"}
        x2o: {"0":"Swipe down on the bottle to begin.","0.25":"Great start, you just drank 25% of your X2O. ","0.5":"50% gone already... that was easy!","0.75":"As the water level goes down, your health goes up. 75% gone!","1":"100% consumed! Time for a fresh bottle of X2O!","12AM-11AM":"timeslot1","11AM-4PM":"timeslot2","4PM-9PM":"timeslot3","9PM-12AM":"timeslot4","0_timeslot1":"Start your day the healthy way with X2O","25_timeslot1":"Cool! You're off to a great start","0_25_timeslot1":"Cool! You're off to a great start","25_50_timeslot1":"Don't worry - no hurry. You're doing fine","50_timeslot1":"A super hydrated way to start your day","50_75_timeslot1":"Wow! You're off to a supercharged day","75_timeslot1":"Wow! You're an overachiever","75_100_timeslot1":"Wow! You're an overachiever","100_timeslot1":"Amazing! That may be a new X2O world record","bonus_timeslot1":"Amazing! You already surpassed your goal for the entire day!","0_timeslot2":"Your body is craving that refreshing X2O water!","25_timeslot2":"Wouldn't a bottle of X2O be great right now?","0_25_timeslot2":"Wouldn't a bottle of X2O be great right now?","25_50_timeslot2":"You started strong - keep going","50_timeslot2":"So far so good","50_75_timeslot2":"You still have plenty of fuel in your tank","75_timeslot2":"Your body is powered by X2O today!","75_100_timeslot2":"Your body is powered by X2O today!","100_timeslot2":"You're like a gold medalist in the Hydration Olympics","bonus_timeslot2":"You're like a superhero who drinks X2O faster than a speeding bullet","0_timeslot3":"Your hydration level is way low. Grab some X2O now!","25_timeslot3":"Your 'low fuel' light is on. Re-fuel with some X2O","0_25_timeslot3":"Your 'low fuel' light is on. Re-fuel with some X2O","25_50_timeslot3":"Wouldn't another bottle of X2O be great right now?","50_timeslot3":"There's still time to reach your goal","50_75_timeslot3":"Keep up the pace and you'll win the race","75_timeslot3":"You're on the right pace...so let's win this race","75_100_timeslot3":"You're on the right pace...so let's win this race","100_timeslot3":"You didn't just set a goal today - you achieved it!","bonus_timeslot3":"You're like a gold medalist in the Hydration Olympics","0_timeslot4":"Don't go to bed dehydrated. End your day with some X2O","25_timeslot4":"Don't go to bed dehydrated. End your day with some X2O","0_25_timeslot4":"Don't go to bed dehydrated. End your day with some X2O","25_50_timeslot4":"End your day right with some X2O tonight","50_timeslot4":"End your day right with some X2O tonight","50_75_timeslot4":"The finish line is still in sight. Drink your X2O tonight","75_timeslot4":"No fear...the finish line is near","75_100_timeslot4":"No fear...the finish line is near","100_timeslot4":"Applause! Congratulations on being an X2O rockstar!","bonus_timeslot4":"Applause! Congratulations on being an X2O rockstar!"}
        date: null

do ->
    storedMessages = CordovaStorage.getMessages()
    Messages = storedMessages.other
    x2oMessages = storedMessages.x2o


    