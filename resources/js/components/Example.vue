<template>
    <div>
        <Menu
            v-bind:isLogin="isLogin"
            v-bind:menu="menu"
        />
        <ExempleForm />
    </div>
</template>

<script>
    import Menu from "./Menu";
    import ExempleForm from "./ExampleForm";
    export default {
        mounted(){
            this.isLogin = (localStorage.getItem('bear_key') !=0)
        },
        data(){
            return {
                isLogin:false,
                menu:[
                    {title:'ApiKey',route:'apikey',isActiv:false},
                    {title:'How to use the geocode api',route:'howusegeocode',isActiv:false},
                    {title:'Example',route:'example',isActiv:true},

                ]
            }
        },
        components:{
            Menu,
            ExempleForm
        }
    }
</script>

<style scoped>

</style>
