<template>


    <div class="card">
        <div class="card-header">
            reply ...
        </div>
        <div class="card-body">
            <textarea v-model="body" class="form-control" name="body" id="body" rows="4"></textarea><br>
            <button @click="addReply()" class="btn btn-outline-primary btn-block">POST</button>
        </div>
    </div>


</template>

<script>
    import 'jquery.caret';
    import 'at.js';
    export default {
        data(){
            return{
                body : ""
            }
        },
        computed:{
            link(){
                return location.pathname + "/replies"
            }
        },
        mounted(){
            $('#body').atwho({
                at:'@',
                callbacks:{
                    remoteFilter: function(query,callback){
                        $.getJSON("/api/users" , {name : query} , function(usernames){
                           callback(usernames)
                        });
                    }
                }
            });
        },
        methods: {
            addReply(){
                axios.post(this.link , { body: this.body})
                    .catch(error => {
                        flash(error.response.data , 'danger')
                    })
                    .then(({data}) => {
                            this.body = "";

                            flash("Your reply has been added");

                            this.$emit('created',data)
                });
            }
        }
    }
</script>