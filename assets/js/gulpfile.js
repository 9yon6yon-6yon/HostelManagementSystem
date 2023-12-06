const gulp = require('gulp'),
    imagemin = require('gulp-imagemin'),
    cssmin = require('gulp-cssmin'),
    autoprefixer = require('gulp-autoprefixer'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat');
 
gulp.task('images', () =>
    gulp.src('./images/*')
        .pipe(imagemin())
        .pipe(gulp.dest('./build/images'))
);
 
gulp.task('css', function () {
    gulp.src('css/*.css')
        .pipe(cssmin())
        .pipe(autoprefixer())
        .pipe(rename({suffix: '.min'}))
        .pipe(concat('styles.min.css'))
        .pipe(gulp.dest('./css'));
});

gulp.task('default', ['css', 'images']);