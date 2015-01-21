	
# Generated on 2014-08-22 using generator-angular 0.9.5
"use strict"

# # Globbing
module.exports = (grunt) ->

	grunt.loadNpmTasks('grunt-contrib-uglify');


	grunt.initConfig
		uglify: 
			options: 
				mangle: true
				compress : true
			
			main: 
				files: 
					'dist/ea-progress-vertical.min.js': ['lib/ea-progress-vertical.js']



	grunt.registerTask "default", "Build production resources", (target)->
		grunt.task.run ["uglify:main" ]