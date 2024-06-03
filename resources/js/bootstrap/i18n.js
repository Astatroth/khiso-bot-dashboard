import VueI18n from 'vue-i18n';
let messages = {};
await axios.get('/messages.json').then(response => {
    messages = response.data;
}).catch(error => {
    toastr.error(error.config.url + ': ' + error.message);
});

export const i18n = new VueI18n({
    locale: document.documentElement.lang,
    messages: messages
});
