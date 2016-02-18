var gulp = require('gulp'),
    gutil = require('gulp-util'),
    concat = require('gulp-concat'),
    coffee = require('gulp-coffee');

var paths = {
    coffee: ['www/scripts/**/*.coffee'],
    concat: ['www/production/**/**/*.js']
};


gulp.task('coffee', function() {
    gulp.src(paths.coffee)
        .pipe(coffee({
            bare: true
        }).on('error', gutil.log))
        .pipe(gulp.dest('www/scripts/'));
});

gulp.task('concatfiles', function() {
    gulp.src(paths.concat)
    .pipe(concat('app.js'))
    .pipe(gulp.dest('www/test/'));
});



gulp.task('watch', function() {
    gulp.watch(paths.coffee, ['coffee']);
});


gulp.task('concat',['concatfiles']);
