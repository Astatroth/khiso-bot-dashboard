import Vue from 'vue';
window.Vue = Vue;

import VueI18n from 'vue-i18n';
let messages = {};
await axios.get('/messages.json').then(response => {
    messages = response.data;
}).catch(error => {
    toastr.error(error.config.url + ': ' + error.message);
});

const i18n = new VueI18n({
    locale: document.documentElement.lang,
    messages: messages
});

import Backend from "../bootstrap/backend.js";
Vue.prototype.$backend = new Backend(i18n);

import VueCookies from 'vue-cookies';
Vue.use(VueCookies);

const modules = import.meta.glob("./Modules/*/*.vue", {eager: true});

for (const path in modules) {
    const componentName = path.split('/').at(-1).split('.')[0];
    Vue.component(`${componentName}`, modules[path].default);
}

const appElement = document.getElementById('app');
if (appElement) {
    const app = new Vue({
        el:'#app',
        i18n
    });
}

