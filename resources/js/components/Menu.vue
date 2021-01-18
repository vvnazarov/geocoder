<template>
    <div>
        <nav class="navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" style="color: white;" >Geocode</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample02">
                <ul class="navbar-nav mr-auto">
                    <li v-for="item in menu" class="nav-item" v-bind:class = "(item.isActiv)?'active':''">
                        <router-link class="nav-link" :to="{name:item.route}">{{item.title}}</router-link>
                    </li>
                </ul>
                <form class="form-inline my-2 my-md-0">
                    <ul class="navbar-nav mr-auto">
                        <li v-if="!isLogin" class="nav-item active">
                            <router-link class="nav-link" :to="{name:'login'}">Login<span class="sr-only">(current)</span></router-link>
                        </li>
                        <li v-else class="nav-item active">
                            <a class="nav-link pointer" v-on:click="loguot">Logout</a>
                        </li>
                    </ul>
                </form>
            </div>
        </nav>
    </div>
</template>

<script>
    import router from "../router";

    export default {
        data(){
            return {
                isL:this.props.isLogin,
                // menu:[]
            }
        },
        props:{
            isLogin:{
                // type:array,
                required:true
            },
            menu:{
                // type:array,
                required:true
            }
        },
        methods:{
            loguot(){
                if(localStorage.getItem('bear_key') != '')
                    axios
                        .request({
                            url: '/api/v1/logout',
                            method: 'post',
                            baseURL: localStorage.getItem('base_url'),
                            headers: {
                                'Authorization': 'Bearer '+localStorage.getItem('bear_key')
                            }
                        })
                        .then(response => {
                            var info = response.data

                            console.log(info)

                            if(info === true){
                                localStorage.setItem('bear_key','')
                                this.isLogin = false;
                                router.push({ name: "login"});

                            }




                        })
                        .catch(err => {
                            console.log(err);
                        })
            }
        }
    }
</script>

<style scoped>
    .pointer{
        cursor: pointer;
    }
</style>
