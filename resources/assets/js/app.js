
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.Vue = require('vue');
var VueResource = require('vue-resource');
Vue.use(VueResource);
window.videojs = require('video.js');
require('videojs-hotkeys');
require('videojs-share');
require('videojs-resolution-switcher');
require('videojs-playlist');

window.Vue.http.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;


/**
 * X-CSRF-TOKEN
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example', require('./components/Example.vue'));
//
// const app = new Vue({
//     el: '#app'
// });3