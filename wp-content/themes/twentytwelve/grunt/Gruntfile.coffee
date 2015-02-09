module.exports = (grunt) ->

	require("load-grunt-tasks") grunt
	require('time-grunt')(grunt);

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


	grunt.registerTask 'sync', ->
		grunt.task.run 'copy'

