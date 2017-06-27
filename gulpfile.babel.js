import gulp from 'gulp';
import gutil from 'gulp-util';
import webpack from 'webpack';
import named from 'vinyl-named';
import gulpWebpack from 'webpack-stream';
import gulpRequireTasks from 'gulp-require-tasks';

const CWD = process.cwd();
const JS_SRC = 'js/src/**/*.js';
const JS_DEST = 'js/compiled';

// Add theme tasks too.
gulpRequireTasks({
  path: `${CWD}/themes/presto_theme/gulp-tasks`
});

let generateJsWebpackTask = (watch = true) => {
  return gulp.src(JS_SRC)
    .pipe(named())
    .pipe(gulpWebpack({
      watch,
      devtool: 'sourcemap',
      module: {
        rules: [
          {
            enforce: 'pre',
            test: /\.js/,
            exclude: /(node_modules|bower_components)/,
            loader: 'eslint-loader'
          },
          {
            test: /\.js$/,
            exclude: /(node_modules|bower_components)/,
            use: {
              loader: 'babel-loader',
              options: {
                presets: ['env']
              }
            }
          }
        ]
      }
    }, webpack))
    .on('error', function (err) {
      gutil.log('WEBPACK ERROR', err.message);
      this.emit('end');
    })
    .pipe(gulp.dest(JS_DEST));
};

gulp.task('js:watch', () => {
  return generateJsWebpackTask();
});

gulp.task('js:build', () => {
  return generateJsWebpackTask(true);
});

gulp.task('default', ['js:watch']);
