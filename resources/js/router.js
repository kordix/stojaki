import Vue from 'vue'
import VueRouter from 'vue-router'

import page from './components/Main'


//import plan from '../components/prodBlade/Plan'

Vue.use(VueRouter)
export default new VueRouter({
    mode:'history',
    //base:'',
    routes:[
        {
            path: '/',
            component: page
        }
    ]
})