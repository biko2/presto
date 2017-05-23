'use strict';

import autoprefixer from 'gulp-autoprefixer';
import browserSync from 'browser-sync';
import clean from 'gulp-clean-css';
import concat from 'gulp-concat';
import gulp from 'gulp';
import sass from 'gulp-sass';
import sourcemaps from 'gulp-sourcemaps';
import uglify from 'gulp-uglify';

const base = './';

const src = {
  js: `${base}/js-src/**/*.js`,
  scss: `${base}/scss/**/*.scss`,
  images: `${base}/images`,
  fonts: `${base}/fonts`,
  bootstrap: `${base}/node_modules/bootstrap-sass/assets/stylesheets`
};

const dest = {
  js: `${base}/js`,
  css: `${base}/css`,
  maps: `maps`,
  images: `${base}/images`,
  fonts: `${base}/fonts`
}


// Development
// ------------------------------------------------------
gulp.task('development', ['js', 'scss'], () => {
  browserSync({
    proxy: 'http://presto.docker',
    host: 'presto.docker',
    open: false,
    socket: {
        domain: "localhost:3000"
    },
    'snippetOptions': {
      'rule': {
        'match': /<\/body>/i,
        'fn': (snippet) => snippet
      }
    }
  });

  gulp.watch(src.scss, ['scss']);
  gulp.watch(src.js, ['js']);
  // gulp.watch(`${base}/**/*.php`, browserSync.reload);
});


// Sass
// ------------------------------------------------------
gulp.task('scss', () => {
  return gulp.src(src.scss)
    .pipe(sourcemaps.init())
    .pipe(sass({
      outputStyle: 'compressed',
      includePaths: [src.bootstrap]
    }))
      .on('error', sass.logError)
    .pipe(autoprefixer({ browsers: ['> 1%', 'IE 7'], cascade: false }))
    .pipe(clean())
    .pipe(sourcemaps.write(dest.maps))
    .pipe(gulp.dest(dest.css))
    .pipe(browserSync.stream());
});


// Javascript
// ------------------------------------------------------
gulp.task('js', () => {
  return gulp.src(src.js)
    .pipe(sourcemaps.init())
    .pipe(concat('presto_theme_concatenated.js'))
    .pipe(uglify({mangle:false}))
    .pipe(sourcemaps.write(dest.maps))
    .pipe(gulp.dest(dest.js));
});


// Tasks
// ------------------------------------------------------
gulp.task('default', ['development']);
