var gulp = require('gulp'),
    less = require('gulp-less'),
    concat = require('gulp-concat'),
    paths = {
      scripts: {
        site: 'assets/js/**/*.js',
        vendor: ['bower_components/d3/d3.js']
      },
      styles: {
        main: 'assets/less/main.less',
        all: 'assets/less/**/*.less'
      }
    };

gulp.task('js:vendor', function () {
  gulp.src(paths.scripts.vendor)
  .pipe(concat('vendor.js'))
  .pipe(gulp.dest('dist/'));
});

gulp.task('js:site', function () {
  gulp.src(paths.scripts.site)
  .pipe(concat('site.js'))
  .pipe(gulp.dest('dist/'));
});

gulp.task('less', function () {
  gulp.src(paths.styles.main)
  .pipe(less())
  .pipe(gulp.dest('dist/'));
});

gulp.task('build', ['js:site', 'js:vendor', 'less']);
gulp.task('default', ['build']);
gulp.task('watch', ['default'], function () {
  gulp.watch(paths.scripts.site, ['js:site']);
  gulp.watch(paths.styles.all, ['less']);
});
