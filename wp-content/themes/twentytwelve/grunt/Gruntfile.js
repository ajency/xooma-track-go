// Generated by CoffeeScript 1.7.1
module.exports = function(grunt) {
  require("load-grunt-tasks")(grunt);
  require('time-grunt')(grunt);
  grunt.initConfig({
    copy: {
      project: {
        cwd: '../xoomaapp',
        src: ['**', '!node_modules/**', '!bower_components/**'],
        dest: '../../../../../xooma-app/www/',
        expand: true
      },
      indexfile: {
        cwd: 'cordova-app',
        src: ['index.html'],
        dest: '../../../../../xooma-app/www/',
        expand: true,
        options: {
          process: function(content, srcPath) {
            var templates;
            templates = grunt.file.read('../xoomaapp/inline-templates.php');
            content = content.replace('<!-- TEMPLATES HERE -->', templates);
            return content;
          }
        }
      }
    }
  });
  return grunt.registerTask('sync', function() {
    return grunt.task.run('copy');
  });
};
