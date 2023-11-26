import { Sketch } from 'vue-color';
window.Vue = require('vue');

Vue.component('create-product', require('./components/CreateProduct.vue').default);
Vue.component('product', require('./components/Product.vue').default);
Vue.component('sketch-picker', Sketch);

const app = new Vue({
  el: '#app',
});
