require('./bootstrap');

window.Vue = require('vue');

Vue.component('checkout-form', require('./components/CheckoutForm.vue'));

const app = new Vue({
    el: '#app'
});
