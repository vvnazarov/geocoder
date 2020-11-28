<template>
    <div>
        <Menu
            v-bind:isLogin="isLogin"
            v-bind:menu="menu"
        />
        index
    </div>
</template>

<script>
    import Menu from "./Menu";
    export default {
        mounted(){
            this.isLogin = (localStorage.getItem('bear_key') !=0)
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
            Menu
        }
    }
</script>

<style scoped>

</style>
