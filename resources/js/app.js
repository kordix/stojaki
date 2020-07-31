/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.component('read', require('./components/Read.vue').default);
Vue.component('readstojak', require('./components/Readstojak.vue').default);

// Vue.component('edit', require('./components/Edit.vue').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import vuetify from './vuetify'
import router from './router'
const app = new Vue({
    router,
    vuetify,
    el: '#app',
    data: {
        activetab: 'main',
        dummyarray: [],
        //clientschema: [{"nazwa":"name","typ":"string"},{"nazwa":"lastname","typ":"string"},{"nazwa":"category_id","typ":"category",dane:[]}],
        //categoryschema:[{"nazwa":"name","typ":"string"}]  
    },
    mounted(){
        let self = this;
        // axios.get('/category').then((res)=>self.clientschema.find((el)=>el.nazwa == 'category_id' ).dane = res.data);
    }

});
