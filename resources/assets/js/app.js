require('./bootstrap');

Vue.component('StripeCheckout', require('./components/StripeCheckout.vue'));

const app = new Vue({
    el: '#app'
});
