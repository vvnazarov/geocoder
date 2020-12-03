<template>
<div>
    <div class="card" style="width:700px;margin:40px auto;">
        <div class="card-header">
            Example query
        </div>
        <div class="card-body">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Api key</span>
                </div>
                <input type="text" v-model="apikey"  class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">

            </div>


            <autocomplete

                :search="searchCity"
                placeholder="Search for a city"
                aria-label="Search for a city"
                :get-result-value="getResultValue"
                @submit="handleSubmitCity"
            ></autocomplete>

            <br>


<!--            <div class="input-group mb-3">-->
<!--                <div class="input-group-prepend">-->
<!--                    <span class="input-group-text" id="inputGroup-sizing-default">Сity id</span>-->
<!--                </div>-->
<!--                <input type="text" v-model="cityId"  class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">-->
<!--            </div>-->
<!--            <div class="input-group mb-3">-->
<!--                <div class="input-group-prepend">-->
<!--                    <span class="input-group-text" id="inputGroup-sizing-default">Street</span>-->
<!--                </div>-->
<!--                <input type="text" v-model="street" v-on:change="streetHelper" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">-->
<!--            </div>-->
<!--            <br>-->

            <autocomplete

                :search="searchStreet"
                placeholder="Search for a street"
                aria-label="Search for a street"
                :get-result-value="getResultValue"
                @submit="handleSubmitStreet"
            ></autocomplete>

            <br>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Number house</span>
                </div>
                <input type="text" v-model="house"  class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
            </div>

            <button type="button" v-on:click="submitGeo" class="btn btn-primary">Отправить</button>
        </div>
    </div>
</div>

</template>

<script>
    import Autocomplete from '@trevoreyre/autocomplete-vue'
    import '@trevoreyre/autocomplete-vue/dist/style.css'


    export default {
        components:{
            Autocomplete
        },
        data(){
            return{
                apikey:'10|uDhjaSgjN9Q06Aek03KOGQW9a0NPg2Qm9pEziwTZtvOqWOuXmRhSrc5uixbqeWP0zh7UIugzL0HtsO0o',
                city:'',
                cityId:'-1',
                street:'',
                streetId:'-1',
                house:'',

            }
        },
        methods:{
            searchStreet(input) {
                return new Promise(resolve => {
                    if (input.length < 1) {
                        return resolve([])
                    }
                    if (this.cityId != -1) {
                        axios
                            .request({
                                url: '/api/v1/geocoder/street?apikey=' + this.apikey.toString() + '&city=' + this.cityId.toString() + '&street=' + input.toString() + '&lang=ru',
                                method: 'get',
                                baseURL: localStorage.getItem('base_url'),
                                data: {
                                    "apikey": this.apikey.toString(),
                                    "city": input.toString(),
                                    "lang": 'ru'
                                }
                            })
                            .then(response => {
                                var info = response.data


                                var ar = []

                                info.result.forEach(e => {
                                    var item = new Object();
                                    item.id = e.id
                                    item.name = e.name
                                    ar[ar.length] = item;
                                });

                                this.streetH = ar;
                                return resolve(this.streetH)

                            })
                            .catch(err => {
                                console.log(err);
                            })
                    } else {
                        alert('You didn\'t choose a city')
                    }
                });
            },
            handleSubmitStreet(result) {
                this.street = result.name
                this.streetId = result.id

            },
            handleSubmitCity(result) {

                this.city = result.name
                this.cityId = result.id

            },
            getResultValue(result) {
                return result.name
            },
            searchCity(input) {


                return new Promise(resolve => {
                    if (input.length < 3) {
                        return resolve([])
                    }

                    axios
                        .request({
                            url: '/api/v1/geocoder/locality?apikey='+this.apikey.toString()+'&city='+input.toString()+'&lang=ru',
                            method: 'get',
                            baseURL: localStorage.getItem('base_url'),
                            data: {
                                "apikey": this.apikey.toString(),
                                "city": input.toString(),
                                "lang":'ru'
                            }
                        })
                        .then(response => {
                            var info = response.data

                            //console.log(info)

                            var ar =[]

                            info.result.forEach(e=>{
                                var  item = new Object();
                                item.id = e.id
                                item.name = e.name
                                ar[ar.length] = item;
                            })
                            // console.log(ar)
                            this.cityH = ar;
                            return resolve(this.cityH)

                        })
                        .catch(err => {
                            console.log(err);
                        })
                    resolve(this.cityH)


                })
            },
            submitGeo(){
                var address =this.city+', '+this.street+', '+this.house;
                axios
                    .request({
                        url: '/api/v1/geocoder/search?apikey='+this.apikey.toString()+'&address='+address.toString()+'&lang=ru',
                        method: 'get',
                        baseURL: localStorage.getItem('base_url'),
                        data: {
                            "apikey": this.apikey.toString(),
                            "address": address.toString(),
                            "lang":'ru'
                        }
                    })
                    .then(response => {
                        var info = response.data

                        if(info.match)
                            return alert('Address is good')


                        return alert('Address is wrong')
                    })
                    .catch(err => {
                        console.log(err);
                    })
            },
        }
    }
</script>

<style scoped>

</style>
