/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(1);


/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * @file
 * Defines the behavior of the media entity browser view.
 *
 * Based on code by Burda in BurdaMagazinOrg/thunder, copyright (c) 2017.
 * Distributed under the GNU GPL v2 or higher. For full terms see the LICENSE
 * file.
 */

/* global Drupal drupalSettings */

(function ($) {

  /**
   * Attaches the behavior of the media entity browser view.
   */
  Drupal.behaviors.mediaEntityBrowserView = {
    attach: function attach(context /* , settings */) {
      $('.views-row', context).each(function () {
        var $row = $(this);
        var $input = $row.find('.views-field-entity-browser-select input');

        // When Auto Select functionality is enabled, then select entity
        // on click, without marking it as selected.
        if (drupalSettings.entity_browser_widget.auto_select) {
          $row.once('register-row-click').click(function (event) {
            event.preventDefault();

            $row.parents('form').find('.entities-list').trigger('add-entities', [[$input.val()]]);
          });
        } else {
          $row[$input.prop('checked') ? 'addClass' : 'removeClass']('checked');

          $row.once('register-row-click').click(function () {
            $input.prop('checked', !$input.prop('checked'));
            $row[$input.prop('checked') ? 'addClass' : 'removeClass']('checked');
          });
        }
      });
    }
  };
})(jQuery, Drupal);

/***/ })
/******/ ]);
//# sourceMappingURL=media_entity_browser.view.js.map