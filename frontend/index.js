import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import App from './src/App.vue';

import './vendor/bulma.min.css';
import './src/app.css';

new Vue({
  el: 'body',
  render(h) { return h(App); },
  router: new VueRouter({
    routes: [],
    mode: 'history',
  }),
});
