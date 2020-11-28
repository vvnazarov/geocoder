import VueRouter from 'vue-router';
import Vue from 'vue';

Vue.use(VueRouter);

import Login from "./components/Login";
import Index from "./components/Index";
import ApiKeys from "./components/ApiKeys";
import HowUse from "./components/HowUse";

const routes = [
    {
        path:'/',
        name:'index',
        component:ApiKeys
    },
    {
        path:'/login',
        name:'login',
        component: Login
    },
    {
        path:'/apikey',
        name:'apikey',
        component: ApiKeys
    },
    {
        path:'/howusegeocode',
        name:'howusegeocode',
        component: HowUse
    },

];

export default new VueRouter({
    mode:'history',
    routes
});
