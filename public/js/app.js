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
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/***/ (function(module, exports) {


/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

// window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
//
// const app = new Vue({
//     el: '#app'
// });

console.log('app.js loaded');

// front end validating search form

// $('#search').on('submit', function (e) {
//    e.preventDefault();
//    var $search = $('#')
// });


if (document.querySelector('#js-search')) {
    document.querySelector('#js-search').addEventListener('submit', function (e) {
        e.preventDefault();
        var $search = document.querySelector('#js-search-input');
        var $errorBlock = document.querySelector('#js-error-block');
        var $errorMessage = document.querySelector('#js-error-text');
        if ($search.value.length < 3 || $search.value.length >= 100) {
            $errorMessage.textContent = 'search input valuse should be between 3 and 100';
            $errorBlock.classList.add('visible');
        } else {
            $errorMessage.textContent = '';
            $errorBlock.classList.remove('visible');
            document.querySelector('#js-search').submit();
        }
    }, false);
}
if (document.querySelector('#js-commentary-form')) {
    document.querySelector('#js-commentary-form').addEventListener('submit', function (e) {
        e.preventDefault();
        var $name = document.querySelector('#js-commentary-name');
        var $text = document.querySelector('#js-commentary-text');
        var $errorBlock = document.querySelector('#js-commentary-error-block');
        var $errorMessage = document.querySelector('#js-commentary-error-text');
        if ($name.value.length < 3 || $name.value.length >= 100) {
            $errorMessage.textContent = 'name length should be between 3 and 100';
            $errorBlock.classList.add('visible');
        } else if ($text.value.length < 3 || $text.value.length >= 255) {
            $errorMessage.textContent = 'commentary text length should be between 3 and 255';
            $errorBlock.classList.add('visible');
        } else {
            $errorMessage.textContent = '';
            $errorBlock.classList.remove('visible');
            document.querySelector('#js-commentary-form').submit();
        }
    }, false);
}
if (document.querySelector('#js-upload')) {
    document.querySelector('#js-upload').addEventListener('submit', function (e) {
        e.preventDefault();
        var $file = document.querySelector('#js-file-input');
        var $errorBlock = document.querySelector('#js-upload-error-block');
        var $errorMessage = document.querySelector('#js-upload-error-text');
        if ($file.files.length == 0) {
            $errorMessage.textContent = 'file should be uploaded!';
            $errorBlock.classList.add('visible');
            return false;
        }
        var fileSize = $file.files[0].size / 1024 / 1024; // in MB
        if (fileSize >= 8) {
            $errorMessage.textContent = 'file size should not larger then 8 mb';
            $errorBlock.classList.add('visible');
        } else {
            $errorMessage.textContent = '';
            $errorBlock.classList.remove('visible');
            document.querySelector('#js-upload').submit();
        }
    }, false);
}

/***/ }),

/***/ "./resources/sass/app.scss":
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("./resources/js/app.js");
module.exports = __webpack_require__("./resources/sass/app.scss");


/***/ })

/******/ });