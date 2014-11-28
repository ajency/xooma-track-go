# Generated on 2014-08-22 using generator-angular 0.9.5
"use strict"

# # Globbing
module.exports = (grunt)->

	# Load grunt tasks automatically
	require("load-grunt-tasks") grunt

	# Time how long tasks take. Can help when optimizing build times
	# require("time-grunt") grunt

	# Define the configuration for all the tasks
	grunt.initConfig

		exec : 
			coffee : 
				cmd : 'coffee -cb ./scripts'
			watchCoffee : 
				cmd : 'coffee -cwb ./scripts'

		less :
			develop :
				files:
					"./css/style.css" : ["./css/less/style.less"]

		watch:
			options:
				livereload: true
				spawn: false
				interrupt: true
			less:
				files: [ "./css/less/*.less" ]
				tasks: ["less:develop"]
			coffee : 
				files : [ "./scripts/**/*.coffee" ]
				tasks: ["exec:coffee"]

		concurrent : 
			dev : ['watch:less','watch:coffee']


	grunt.registerTask "dev", "Start develop", (target)->
		grunt.task.run [
				"less:develop"
				"exec:watchCoffee"
			]
