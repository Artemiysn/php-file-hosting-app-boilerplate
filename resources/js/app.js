
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
        let $search = document.querySelector('#js-search-input');
        let $errorBlock = document.querySelector('#js-error-block');
        let $errorMessage = document.querySelector('#js-error-text');
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
        let $name = document.querySelector('#js-commentary-name');
        let $text = document.querySelector('#js-commentary-text');
        let $errorBlock = document.querySelector('#js-commentary-error-block');
        let $errorMessage = document.querySelector('#js-commentary-error-text');
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
        let $file = document.querySelector('#js-file-input');
        let $errorBlock = document.querySelector('#js-upload-error-block');
        let $errorMessage = document.querySelector('#js-upload-error-text');
        if ($file.files.length == 0) {
            $errorMessage.textContent = 'file should be uploaded!';
            $errorBlock.classList.add('visible');
            return false;
        }
        let fileSize = $file.files[0].size / 1024 / 1024; // in MB
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

