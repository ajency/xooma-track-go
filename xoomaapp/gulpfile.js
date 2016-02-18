var gulp = require('gulp'),
    gutil = require('gulp-util'),
    coffee = require('gulp-coffee');

var paths = {
    coffee: ['www/scripts/**/*.coffee'],
};


gulp.task('coffee', function() {
    gulp.src(paths.coffee)
        .pipe(coffee({
            bare: true
        }).on('error', gutil.log))
});

gulp.task('coffee', function() {
    gulp.src(paths.coffee)
        .pipe(coffee({
            bare: true
        }).on('error', gutil.log))
        .pipe(gulp.dest('www/scripts/'));
});


gulp.task('watch', function() {
    gulp.watch(paths.coffee, ['coffee']);
});
