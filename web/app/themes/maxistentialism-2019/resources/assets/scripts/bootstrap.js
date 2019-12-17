/**
 * Pull in dependencies and perform setup that happens globally
 */
import Vue from 'vue';
window.Vue = Vue;

import VueTinySlider from 'vue-tiny-slider';
Vue.component('tiny-slider', VueTinySlider);

import vueSmoothScroll from 'vue2-smooth-scroll';
Vue.use(vueSmoothScroll);

import Accordion from './components/Accordion';
Vue.component('accordion', Accordion);

import Icon from 'laravel-mix-vue-svgicon/IconComponent.vue';
Vue.component('icon', Icon);

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common = {
	'Accept': 'application/json',
	'Content-Type': 'application/json',
	'X-Requested-With': 'XMLHttpRequest',
};

