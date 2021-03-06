module.exports = (grunt) ->

	require("load-grunt-tasks") grunt
	require('time-grunt')(grunt)

	plugins = [ 
		'../xoomaapp/bower_components/underscore/underscore.js'
		'../xoomaapp/bower_components/jquery/dist/jquery.min.js'
		'../xoomaapp/bower_components/jquery-ui/jquery-ui.min.js'
		'../xoomaapp/bower_components/backbone/backbone.js'
		'../xoomaapp/bower_components/backbone.marionette/lib/backbone.marionette.min.js'
		'../xoomaapp/bower_components/backbone.syphon/lib/backbone.syphon.js'
		'../xoomaapp/bower_components/bootstrap/dist/js/bootstrap.min.js'
		'../xoomaapp/bower_components/parsleyjs/dist/parsley.js'
		'../xoomaapp/bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js'
		'../xoomaapp/bower_components/handlebars/handlebars.js'
		'../xoomaapp/bower_components/plupload/js/moxie.min.js'
		'../xoomaapp/bower_components/plupload/js/plupload.full.min.js'
		'../xoomaapp/bower_components/jQuery-Storage-API/jquery.storageapi.js'
		'../xoomaapp/bower_components/cryptojslib/rollups/md5.js'
		'../xoomaapp/bower_components/rrule/lib/rrule.js'
		'../xoomaapp/bower_components/rrule/lib/nlp.js'
		'../xoomaapp/bower_components/jQuery.mmenu/src/js/jquery.mmenu.min.all.js'
		'../xoomaapp/bower_components/rangeslider.js/dist/rangeslider.min.js'
		'../xoomaapp/bower_components/classie/classie.js'
		'../xoomaapp/bower_components/moment/min/moment.min.js'
		'../xoomaapp/bower_components/chartjs/Chart.js'
		'../xoomaapp/bower_components/ea-vertical-progress/dist/ea-progress-vertical.min.js'
		'../xoomaapp/bower_components/moment-timezone/moment-timezone.js'
		'../xoomaapp/bower_components/bootstrap-timepicker/js/bootstrap-timepicker.min.js'
		'../xoomaapp/bower_components/marionette.state/dist/marionette.state.js'
		'../xoomaapp/bower_components/ajency.marionette/dist/ajency.marionette.js'
	]

	appcode = [
		'../js/tooltip.js'
		'../js/slick.min.js'
		'../js/offline.min.js'
		'../js/android.ios.html.class.js'
		'../xoomaapp/scripts/common/common.js'
		'../xoomaapp/scripts/xooma/xooma.app.root.ctrl.js'
		'../xoomaapp/scripts/profile/profile.ctrl.js'
		'../xoomaapp/scripts/profile/personalinfo.ctrl.js'
		'../xoomaapp/scripts/profile/measurements.ctrl.js'
		'../xoomaapp/scripts/products/product.entity.js'
		'../xoomaapp/scripts/products/add/add.products.ctrl.js'
		'../xoomaapp/scripts/products/products.js'
		'../xoomaapp/scripts/profile/userproductlistctrl.js'
		'../xoomaapp/scripts/home/homectrl.js'
		'../xoomaapp/scripts/products/edit/edit.products.ctrl.js'
		'../xoomaapp/scripts/products/inventory/update.inventory.ctrl.js'
		'../xoomaapp/scripts/products/history/history.inventory.ctrl.js'
		'../xoomaapp/scripts/consumption/asperbmi/asperbmi.ctrl.js'
		'../xoomaapp/scripts/consumption/scheduled/products.schedule.ctrl.js'
		'../xoomaapp/scripts/history/history.product.ctrl.js'
		'../xoomaapp/scripts/settings/settings.ctrl.js'
		'../xoomaapp/scripts/history/history.measurements.ctrl.js'
		'../xoomaapp/scripts/loading/loading.ctrl.js'
		'../xoomaapp/scripts/loading/workflow.ctrl.js'
		'../xoomaapp/scripts/admin/admin.ctrl.js'
		'../xoomaapp/scripts/faq/faq.ctrl.js'
		'../xoomaapp/scripts/app.js'		
	]

	grunt.initConfig

		copy :
			project :
				cwd : '../xoomaapp'
				src: ['**', '!node_modules/**', '!bower_components/**']
				dest: '../../../../../xooma-app/www/'
				expand : true
			indexfile :
				cwd : 'cordova-app'
				src : ['index.html']
				dest : '../../../../../xooma-app/www/'
				expand : true
				options :
					process : (content, srcPath)->
						templates = grunt.file.read '../xoomaapp/inline-templates.php'
						content = content.replace '<!-- TEMPLATES HERE -->', templates
						content

		watch:
			options:
				livereload: true
				spawn: false
				interrupt: true

			develop:
				files: [
					"../xoomaapp/scripts/**/*.coffee"
					"../xoomaapp/scripts/*.coffee"
				]
				tasks: ["coffee:develop"]

		coffee :
			options:
				bare : true
				
			develop:
				files :[
					expand: true
					cwd: "../xoomaapp/scripts"
					src: ["**/*.coffee"]
					dest: "../xoomaapp/production"
					ext: ".js"
					extDot: 'last'
				]

		uglify:
			app:
				files: [
					'../xoomaapp/dist/plugins.min.js': plugins
					'../xoomaapp/dist/appliction.min.js': appcode
				]



	grunt.registerTask 'sync', ->
		grunt.task.run 'copy'

	grunt.registerTask "default", "Start develop", (target)->
		grunt.task.run [
				"coffee:develop"
				"watch"
			]

	grunt.registerTask "dist", "Start develop", (target)->
		grunt.task.run [
				"uglify"
			]


