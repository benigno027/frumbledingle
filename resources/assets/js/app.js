
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.component('locations-index', require('./components/Locations/Index.vue'));
Vue.component('items-index', require('./components/Items/Index.vue'));
Vue.component('categories-index', require('./components/Categories/Index.vue'));
Vue.component('reports-index', require('./components/CategoryLocationReport/Index.vue'));



new Vue({el: '#app-container'});
