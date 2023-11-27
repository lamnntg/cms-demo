import { Sketch } from 'vue-color';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

window.Vue = require('vue');

const options = {
    // You can set your default options here
};

Vue.use(Toast, options);
Vue.component('create-product', require('./components/CreateProduct.vue').default);
Vue.component('product', require('./components/Product.vue').default);
Vue.component('sketch-picker', Sketch);

const app = new Vue({
  el: '#app',
});
