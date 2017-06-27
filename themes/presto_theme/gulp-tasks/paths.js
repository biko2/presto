const CWD = process.cwd();

export const OUTPUT_JS_FILE = 'presto.min.js';

export const DEST = {
  js: `${CWD}/js/compiled`,
  css: `${CWD}/css`,
  maps: `${CWD}/maps`,
  images: `${CWD}/images`,
  fonts: `${CWD}/fonts`
};

export const SRC = {
  js: `${CWD}/js/src/**/*.js`,
  scss: `${CWD}/scss/**/*.scss`,
  images: `${CWD}/images`,
  fonts: `${CWD}/fonts`,
  bootstrap: `${CWD}/node_modules/bootstrap-sass/assets/stylesheets`
};
