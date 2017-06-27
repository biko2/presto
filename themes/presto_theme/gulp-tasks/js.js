import globby from 'globby';
import gutil from 'gulp-util';
import through from 'through2';
import babelify from 'babelify';
import uglify from 'gulp-uglify';
import buffer from 'vinyl-buffer';
import browserify from 'browserify';
import source from 'vinyl-source-stream';
import sourcemaps from 'gulp-sourcemaps';
import * as paths from './paths';

module.exports = (gulp/* , callback */) => {
  let bundledStream = through();

  bundledStream
    .pipe(source(paths.OUTPUT_JS_FILE))
    .pipe(buffer())
    .pipe(sourcemaps.init({
      loadMaps: true
    }))
    .pipe(uglify({
      mangle: false
    }))
    .on('error', gutil.log)
    .pipe(sourcemaps.write(paths.DEST.maps))
    .pipe(gulp.dest(paths.DEST.js));

  globby([paths.SRC.js]).then((entries) => {
    let bundler = browserify({
      entries,
      debug: true,
      transform: [babelify]
    }).ignore('jquery'); // Drupal adds this in itself.

    bundler.bundle().pipe(bundledStream);
  }).catch((err) => {
    bundledStream.emit('error', err);
  });

  return bundledStream;
};
