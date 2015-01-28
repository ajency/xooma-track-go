App.state 'Settings',
					url : '/settings'
					parent : 'xooma'

class SettingsView extends Marionette.ItemView
	className : 'animated fadeIn'
	template : '#settings-template'

	ui :
		notification : '#notification'
		emails 		: '#emails'
		responseMessage : '.aj-response-message'


	events:
		'click @ui.notification':(e)->
			if $(e.target).prop('checked') == true
				$(e.target).val '1'
				$(e.target).prop('checked',true)
			else
				$(e.target).val '0'
				$(e.target).prop('checked',false)
			data = 'notification='+$(e.target).val()
			$.ajax
					method : 'POST'
					url : "#{_SITEURL}/wp-json/notifications/#{App.currentUser.get('ID')}"
					data : data
					success : @successnotiSave
					error : @errornotiSave

		'click @ui.emails':(e)->
			if $(e.target).prop('checked') == true
				$(e.target).val '1'
				$(e.target).prop('checked',true)
			else
				$(e.target).val '0'
				$(e.target).prop('checked',false)
			data = 'emails='+$(e.target).val()
			$.ajax
					method : 'POST'
					url : "#{_SITEURL}/wp-json/emails/#{App.currentUser.get('ID')}"
					data : data
					success : @successSave
					error : @errorSave

	successnotiSave:(response,status,xhr)=>
		if xhr.status == 201
			App.currentUser.set 'notifications' , parseInt(response.notifications)
			@ui.responseMessage.addClass('alert alert-success').text("Notifications data saved!")
			$('html, body').animate({
							scrollTop: 0
							}, 'slow')
		else
			@showErr()

	showErr:->
		@ui.responseMessage.addClass('alert alert-danger').text("Sorry!Data couldn't be saved!")
		$('html, body').animate({
						scrollTop: 0
						}, 'slow')

	successSave:(response,status,xhr)=>
		if xhr.status == 201
			App.currentUser.set 'emails' , parseInt(response.emails)
			@ui.responseMessage.addClass('alert alert-success').text("Emails data saved!")
			$('html, body').animate({
							scrollTop: 0
							}, 'slow')
		else
			@showErr()

	onShow:->
		notification = App.currentUser.get 'notification'
		if parseInt(notification) == 1
			@ui.notification.prop('checked',true)
			@ui.notification.val '1'
		else
			@ui.notification.prop('checked',false)
			@ui.notification.val '0'


		emails = App.currentUser.get 'emails'
		if parseInt(emails) == 1
			@ui.emails.prop('checked',true)
			@ui.emails.val '1'
		else
			@ui.emails.prop('checked',false)
			@ui.emails.val '0'
	


class App.SettingsCtrl extends Ajency.RegionController
	initialize: (options)->
		@show new SettingsView
