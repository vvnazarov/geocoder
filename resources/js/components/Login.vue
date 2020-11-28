<template>
    <div>
        <Menu
            v-bind:isLogin="isLogin"
            v-bind:menu="menu"
        />
        <LoginForm />
    </div>
</template>

<script>
    import Menu from './Menu'
    import LoginForm from "./LoginForm";
    import router from "../router";

    export default {
        mounted(){
            this.isLogin = (localStorage.getItem('bear_key') !=0)
            if(localStorage.getItem('bear_key') != ''){
                router.push({ name: "index"});
            }
        },
        data(){
            return {
                isLogin:false,
                menu:[
                    {title:'ApiKey',route:'apikey',isActiv:true},
                    {title:'How to use the geocode api',route:'howusegeocode',isActiv:false},

                ]
            }
        },
        components:{
            Menu,
            LoginForm
        }
    }
</script>

<style scoped>

</style>
