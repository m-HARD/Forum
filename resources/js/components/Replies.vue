<template>
    <div>
        <div v-if="repliesCount > 0">
            <div v-for="(reply,index) in items" :key="reply.id">
                <reply :data="reply" @delete="remove(index)"></reply>
            </div>

            <paginator :dataSet="dataSet" @changedPage="fetch"></paginator>
        </div>
            <p class="text-center" v-else>Be The First One To Replay At This!</p>

        <br><br>

        <addreply v-cloak v-if="singedIn" @created="add"></addreply>

        <p class="text-center" v-else> <a href="/login">Sing in</a> To Reply</p>
    </div>

</template>

<script>
    import Reply from './Reply'
    import addreply from './AddReply'
    import * as axios from "axios";
    export default {
        props:['repliesCount'],
        components:{ Reply , addreply },
        data(){
            return{
                dataSet: false,
                items : [],
            }
        },
        computed:{
            singedIn(){
                return window.App.singedIn
            }
        },
        created(){
            this.fetch();
        },
        methods: {
            fetch(page){
                axios.default.get(this.url(page))
                    .then(this.refresh)
            },
            url(page){
              if (! page){
                  let query = location.search.match(/page=(\d)/);

                  page = query ? query[1] : 1;
              }
              return location.pathname + '/replies?page=' + page
            },
            refresh({data}){
                this.dataSet = data;
                this.items = data.data;

                window.scrollTo(0,0)
            },
            add(reply){
                this.items.push(reply)
            },
            remove(index){
                this.items.splice(index,1);
                //this.$delete(this.items,index)
                this.$emit('removed');
            }
        }
    }
</script>

<style>

</style>