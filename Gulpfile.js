var gulp = require('gulp'),
    sass = require('gulp-sass'),
    concat = require('gulp-concat'),
    imagemin = require('gulp-imagemin'),
    pngquant = require('imagemin-pngquant'),
    paths = {
      scripts: {
        site: 'assets/js/**/*.js',
        vendor: [
          'bower_components/d3/d3.js',
          'bower_components/topojson/topojson.js'
        ]
      },
      styles: {
        main: 'assets/scss/main.scss',
        all: 'assets/scss/**/*.scss'
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

gulp.task('sass', function () {
  gulp.src(paths.styles.main)
  .pipe(sass())
  .pipe(gulp.dest('dist/'));
});

gulp.task('images', function () {
  gulp.src('assets/images/**/*')
  .pipe(imagemin({
    progressive: true,
    use: [pngquant()]
  }))
  .pipe(gulp.dest('dist/images'));
});

gulp.task('build', ['js:site', 'js:vendor', 'sass', 'images']);
gulp.task('default', ['build']);
gulp.task('watch', ['default'], function () {
  gulp.watch(paths.scripts.site, ['js:site']);
  gulp.watch(paths.styles.all, ['sass']);
  gulp.watch('assets/images/**/*', ['images']);
});
