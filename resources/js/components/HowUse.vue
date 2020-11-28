<template>
<div>
    <Menu
        v-bind:isLogin="isLogin"
        v-bind:menu="menu"
    />
    <div style="width: 60%;margin: auto;margin-top:15px;">

        <div data-v-b3d83c7c=""><div data-v-b3d83c7c="" id="1d1c84f9-d75f-4ba6-ad55-59d654ffaadf" class="docs-item"><div data-v-b3d83c7c="" class="docs-desc"><div data-v-b3d83c7c="" class="docs-desc-title__url"><h4 style="color: white;background-color: #343a40!important; padding: 10px;"> URL - api/v1/geocoder/search</h4></div><div data-v-b3d83c7c="" class="docs-desc-body"><div data-v-b3d83c7c="" id="auth-info-1d1c84f9-d75f-4ba6-ad55-59d654ffaadf" class="docs-request-auth-info"><h4 data-v-b3d83c7c="" class="pm-h4 auth-label"> Authorization - <span data-v-b3d83c7c="" class="auth-type">Bearer Token</span></h4><div data-v-b3d83c7c="" class="auth-inherited"></div></div><div data-v-b3d83c7c="" class="docs-request-params"><h4 data-v-b3d83c7c="" class="pm-h4">Params</h4><table data-v-b3d83c7c="" class="table table-striped"><thead><tr><th>Name variable</th><th> Exemple data</th></tr></thead><tbody data-v-b3d83c7c=""><tr data-v-b3d83c7c=""><td data-v-b3d83c7c="" class="weight--medium">apikey</td><td data-v-b3d83c7c="">1|CI5PONQtaYnGNoD1ofbzAZzENyO1il3rEw1eob8cNRHgYJPLcKUm8sMrLIuNj43KUu95rcasZDCZEQeT<div data-v-b3d83c7c="" class="pm-markdown docs-request-table__desc"></div></td></tr><tr data-v-b3d83c7c=""><td data-v-b3d83c7c="" class="weight--medium">city</td><td data-v-b3d83c7c="">Astrakhan<div data-v-b3d83c7c="" class="pm-markdown docs-request-table__desc"></div></td></tr><tr data-v-b3d83c7c=""><td data-v-b3d83c7c="" class="weight--medium">street</td><td data-v-b3d83c7c="">lukonina<div data-v-b3d83c7c="" class="pm-markdown docs-request-table__desc"></div></td></tr><tr data-v-b3d83c7c=""><td data-v-b3d83c7c="" class="weight--medium">building</td><td data-v-b3d83c7c="">dom 11<div data-v-b3d83c7c="" class="pm-markdown docs-request-table__desc"></div></td></tr><tr data-v-b3d83c7c=""><td data-v-b3d83c7c="" class="weight--medium">flat</td><td data-v-b3d83c7c="">kv 95<div data-v-b3d83c7c="" class="pm-markdown docs-request-table__desc"></div></td></tr></tbody></table></div></div></div></div></div>

    </div>
</div>
</template>

<script>
    import Menu from "./Menu";
    import router from "../router";
    export default {
        components:{
            Menu
        },
        mounted(){
            this.isLogin = (localStorage.getItem('bear_key') !=0)
            if(localStorage.getItem('bear_key') == ""){
                router.push({ name: "login"});
            }
        },
        data(){
            return {
                isLogin:false,
                menu:[
                    {title:'ApiKey',route:'apikey',isActiv:false},
                    {title:'How to use the geocode api',route:'howusegeocode',isActiv:true},

                ]
            }
        },
    }
</script>

<style scoped>

</style>
