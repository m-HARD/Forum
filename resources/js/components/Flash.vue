<template>
    <div class="alert fade show alert-flash" :class="'alert-' + level" role="alert" v-show="show">
        {{ body }}
    </div>
</template>

<script>
    export default {
        props:['message'],
        data(){
            return{
                body: '',
                level: 'success',
                show: false
            }
        },
        created() {
            if (this.message){
                this.flash(this.message)
            }

            window.events.$on('flash' , data => this.flash(data))
        },
        methods: {
            flash(data){
                this.body = data.message;
                this.level = data.level;
                this.show = true;


                this.hide()
            },
            hide(){
                setTimeout(() => {
                    $(this.$el).fadeOut(3000,()=>{
                        this.show = false
                    })
                },4000)
            }
        }
    }
</script>

<style>
    .alert-flash{
        position: fixed;
        right: 36px;
        bottom: 15px;
    }
</style>