require('./bootstrap');

window.Vue = require('vue');

//Utilities
Vue.component('pagination', require('./components/utilities/Pagination.vue').default);
Vue.component('record-count', require('./components/utilities/RecordCount.vue').default);

//------- RR AUTO-GENERATED CONTENT -------//








const app = new Vue({
    el: '#rr_interface',
    render: h => h(toolbox)
});
