<template>
<div>
    <Menu
        v-bind:isLogin="isLogin"
        v-bind:menu="menu"
    />
    <span style="color: red;">{{message}}</span>

    <button type="button" class="btn btn-primary" style="margin-left: 20%;margin-top: 30px;" v-on:click="addkey">Generated new API key</button>
    <table class="table table-sm mytable">
        <thead class="thead-dark">
        <tr>
            <th scope="col " >#</th>
            <th scope="col">API key</th>
            <th scope="col">Time created</th>
            <th scope="col">Controls</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(value, name, index) in key">
            <td scope="row">{{value.id}}</td>
            <td>{{value.apikey}}</td>
            <td>{{value.created_at}}</td>
            <td><div v-on:click="dalete(value.id)">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
            </svg>
            </div></td>
        </tr>

        </tbody>
    </table>

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
            axios
                .request({
                    url: '/api/v1/apikey',
                    method: 'get',
                    baseURL: localStorage.getItem('base_url'),
                    headers: {
                        'Authorization': 'Bearer '+localStorage.getItem('bear_key')
                    }
                })
                .then(response => {
                    var info = response.data

                    //console.log(info)

                    if(info.error){
                        this.message = info.message
                    }else{
                        this.key = info.data

                    }

                    this.loading = false;


                })
                .catch(err => {
                    console.log(err);
                })


        },
        data(){
            return {
                message:'',
                isLogin:false,
                isLoading:false,
                menu:[
                    {title:'ApiKey',route:'apikey',isActiv:true},
                    {title:'How to use the geocode api',route:'howusegeocode',isActiv:false},

                ],
                key:[]
            }
        },methods:{
            dalete($id){
                axios
                    .request({
                        url: '/api/v1/apikey/'+$id,
                        method: 'delete',
                        baseURL: localStorage.getItem('base_url'),
                        headers: {
                            'Authorization': 'Bearer '+localStorage.getItem('bear_key')
                        }
                    })
                    .then(response => {
                        var info = response.data

                        //console.log(info)

                        if(info.error){
                            this.message = info.message
                        }else{
                            this.key = this.key.filter(t => t.id !== $id)

                        }

                        this.loading = false;


                    })
                    .catch(err => {
                        console.log(err);
                    })
            },
            addkey(){
                axios
                    .request({
                        url: '/api/v1/apikey',
                        method: 'post',
                        baseURL: localStorage.getItem('base_url'),
                        headers: {
                            'Authorization': 'Bearer '+localStorage.getItem('bear_key')
                        }
                    })
                    .then(response => {
                        var info = response.data

                        //console.log(info)

                        if(info.error){
                            this.message = info.message
                        }else{
                            this.key.push(info.apikey)

                        }

                        this.loading = false;


                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
        }
    }
</script>

<style scoped>
.mytable{
    margin: 30px auto;
    width: 60%;
    font-size: 0.8em;
}
</style>
