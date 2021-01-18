<template>
    <div class="card" style="width: 500px;margin: 100px auto;">
        <div class="card-header">
            Login
        </div>
        <div class="card-body">
            <div v-if="loading" >Отправляется</div>
            <form v-else @submit.prevent="onSubmit()">
                <span style="color: red;">{{message}}</span>
                <div class="form-group">
                    <label for="login">Login</label>
                    <input required type="text" class="form-control" v-model="login" aria-describedby="loginHelp" id="login" name="login" placeholder="login">
                    <small id="loginHelp" class="form-text text-muted">{{loginM}}</small>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input required type="password" class="form-control" id="password" v-model="password"  aria-describedby="passwordHelp" name="password" placeholder="password">
                    <small id="passwordHelp" class="form-text text-muted">{{passwordM}}</small>
                </div>

                <button class="btn btn-primary" style="width: 100%;" type="submit" >Sing in</button>
            </form>
        </div>

    </div>
</template>

<script>
    import router from "../router";

    export default {
        mounted() {
            // console.log(localStorage.getItem('bear_key') !='')
        },
        data(){
            return{
                message:'',
                login:'',
                password:'',
                loginM:'',
                passwordM:'',
                loading: false
            }
        },
        methods:{
            onSubmit(){
                this.loading = true;
                console.log(localStorage.getItem('base_url'))
                axios
                    .request({
                        url: '/api/v1/login',
                        method: 'post',
                        baseURL: localStorage.getItem('base_url'),
                        data: {
                            "login": this.login.toString(),
                            "password": this.password.toString(),
                            "device_name": navigator.userAgent
                        }
                    })
                    .then(response => {
                        var info = response.data

                        console.log(info)

                        if(info.error){
                            this.message = info.message
                        }else{
                            this.message =''
                             localStorage.setItem('bear_key',info)
                            router.push({ name: "index"});
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

</style>
