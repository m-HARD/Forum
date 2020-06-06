<template>

    <button :class="classes" @click="toggle" v-text="this.isActive ? 'UnSubscribe' : 'Subscribe'"></button>

</template>


<script>
    export default {
        props:['active'],
        data(){
            return{
                isActive : this.active
            }
        },
        computed:{
            classes(){
                return ['btn' , this.isActive ? 'btn-primary' : 'btn-light']
            }
        },
        methods: {
            toggle(){
                this.isActive ? this.unsubscribe() : this.subscribe()
            },
            subscribe(){
                axios.default.post(location.pathname + "/subscriptions");
                this.isActive = !this.isActive;
                flash("subscribed")
            },
            unsubscribe(){
                axios.default.delete(location.pathname + "/subscriptions");
                this.isActive = !this.isActive;
                flash("unsubscribed")
            }
        }
    }
</script>

<style>

</style>