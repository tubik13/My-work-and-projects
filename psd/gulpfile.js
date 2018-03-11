'use strict';

var gulp = require('gulp'),
    scss = require('gulp-scss'),
    rename = require('gulp-rename'),
    minifyCSS = require('gulp-minify-css');

gulp.task('scss-to-css', function () {
    gulp.src('assets/sass/style.scss')
        .pipe(scss())
        .pipe(gulp.dest(''));
});

gulp.task('minify-css', function() {
    return gulp.src('style.css')
        .pipe(minifyCSS())
        .pipe(rename('style.min.css'))
        .pipe(gulp.dest('css/'));
});

gulp.task('watch', function () {
    gulp.watch('assets/sass/style.scss', ['scss-to-css']);
    gulp.watch('style.css', ['minify-css']);
});