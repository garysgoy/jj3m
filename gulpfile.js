const gulp = require('gulp');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const cssmin = require('gulp-cssmin');
const browserSync = require('browser-sync').create();
const concat = require('gulp-concat');
const minify = require('gulp-minify');
const rename = require('gulp-rename');
const imagemin = require('gulp-imagemin');

// CSS Tasks
gulp.task('css-compile', function() {
  gulp.src('./src/scss/*.scss')
    .pipe(sass({outputStyle: 'nested'}).on('error', sass.logError))
    .pipe(autoprefixer({
      browsers: ['last 10 versions'],
      cascade: false
    }))
    .pipe(gulp.dest('./src/css'));
});

gulp.task('css-minify', function() {
    gulp.src(['./src/css/*.css', '!css/*.min.css'])
      .pipe(cssmin())
      .pipe(rename({suffix: '.min'}))
      .pipe(gulp.dest('./css'))
});

// Watch on everything
gulp.task('default', function() {
  gulp.watch("./src/scss/*.scss", ['css-compile']);
  gulp.watch(["./src/css/*.css", "!css/*.min.css"], ['css-minify']);
});
