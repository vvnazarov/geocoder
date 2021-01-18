<template>

    <tr >
        <td scope="row">123{{key.id}}</td>
        <td>123{{key.apikey}}</td>
        <td>123{{key.created_at}}</td>
        <td>
            <div v-on:click="dalete " >

            </div>
        </td>
    </tr>

</template>

<script>
    export default {
        data(){
            return{
                key:{}
        }},
        props:{
            key:{
                type:Object,
                required:true
            }
        },
        methods:{
            dalete: function(){

            }
        }
    }
</script>

<style scoped>

</style>
