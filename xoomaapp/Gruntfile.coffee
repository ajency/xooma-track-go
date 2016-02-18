module.exports = (grunt) ->

	require("load-grunt-tasks") grunt
	require('time-grunt')(grunt)

	plugins = [ 
		'bower_components/underscore/underscore.js'
		'bower_components/jquery/dist/jquery.min.js'
		'bower_components/jquery-ui/jquery-ui.min.js'
		'bower_components/backbone/backbone.js'
		'bower_components/backbone.marionette/lib/backbone.marionette.min.js'
		'bower_components/backbone.syphon/lib/backbone.syphon.js'
		'bower_components/bootstrap/dist/js/bootstrap.min.js'
		'bower_components/parsleyjs/dist/parsley.js'
		'bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js'
		'bower_components/handlebars/handlebars.js'
		'bower_components/plupload/js/moxie.min.js'
		'bower_components/plupload/js/plupload.full.min.js'
		'bower_components/jQuery-Storage-API/jquery.storageapi.js'
		'bower_components/cryptojslib/rollups/md5.js'
		'bower_components/rrule/lib/rrule.js'
		'bower_components/rrule/lib/nlp.js'
		'bower_components/jQuery.mmenu/src/js/jquery.mmenu.min.all.js'
		'bower_components/rangeslider.js/dist/rangeslider.min.js'
		'bower_components/classie/classie.js'
		'bower_components/moment/min/moment.min.js'
		'bower_components/chartjs/Chart.js'
		'bower_components/ea-vertical-progress/dist/ea-progress-vertical.min.js'
		'bower_components/moment-timezone/moment-timezone.js'
		'bower_components/bootstrap-timepicker/js/bootstrap-timepicker.min.js'
		'bower_components/marionette.state/dist/marionette.state.js'
		'bower_components/ajency.marionette/dist/ajency.marionette.js'
	]

	appjscode = [
		'dev/js/*.js'	
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
					"dev/scripts/**/*.coffee"
					"dev/scripts/*.coffee"
				]
				tasks: ["coffee:develop"]

		coffee :
			options:
				bare : true
				
			develop:
				files :[
					expand: true
					cwd: "dev/scripts"
					src: ["**/*.coffee"]
					dest: "www/production"
					ext: ".js"
					extDot: 'last'
				]

		uglify:
			app:
				files: [
					'www/dist/plugins.min.js': plugins
					'www/dist/jsfiles.min.js' : appjscode
					
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


