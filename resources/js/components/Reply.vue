<template>

        <div :id="'reply-'+this.data.id" class="card" style="margin-bottom: 10px">
            <div class="card-header">
                <a :href="'/profile/' + this.data.owner.name" v-text="this.data.owner.name"></a> said
                <span class="float-right" style="font-size: 11px;padding-top: 4px;">
                        <span v-text="favorites_count"></span>
                        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                        <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> &ensp;
                        0
                        <i class="fa fa-share" aria-hidden="true"></i>
                        <div style="display: inline-flex;" v-if="!editing">
                            <Rrdrop :data="this.data" @destroy="destroy" @editClick="editing = true"></Rrdrop>
                        </div>
                    </span>
            </div>
            <div class="card-body" style="padding-bottom: 2px;">
                <div v-if="editing">
                    <textarea  class="form-control" v-model="body"></textarea>
                    <button class="btn btn-primary btn-sm" style="margin-top: 5px" @click="update()">Update</button>
                    <button class="btn btn-light btn-sm" style="margin-top: 5px" @click="editing = false">Cancel</button>
                </div>
                <div v-else v-html="body"></div>

                <hr style="margin-bottom: 0">
                <div style="font-size: 10px;">

                    <span v-text="ago"></span> ...
                    <div  style="margin: 2px 22px;display: inline-block;" v-if="! isFavorited">
                        <button  class="btn btn-outline-primary myfavbut" @click="toggle()">
                            <i class="fa fa-thumbs-o-up"></i> Like
                        </button>
                    </div>
                    <div  style="margin: 2px 22px;display: inline-block;" v-if="isFavorited">
                        <button  class="btn btn-outline-primary myfavbut" @click="toggle()">
                            <i class="fa fa-thumbs-o-down"></i> dis Like
                        </button>
                    </div>
                    <div  style="margin: 2px 22px;display: inline-block;">
                        <button  class="btn btn-outline-primary myfavbut" @click="work_in()">
                            <i class="fa fa-share"></i> Share
                        </button>
                    </div>

                </div>

            </div>
        </div>
</template>


<script>
    import Rrdrop from '../layouts/Reply_right_dropdown.vue'
    import moment from 'moment'
    export default {
        props:["data"],
        components:{Rrdrop},
        data(){
            return{
                editing : false,
                body : this.data.body,
                favorites_count : this.data.favorites_count,
                isFavorited : this.data.isFavorited
            }
        },
        computed:{
          ago(){
            return  moment.utc(this.data.created_at).fromNow();
          },
          link(){
              return "/replies/" + this.data.id + "/favorites"
          }
        },
        methods: {
            update(){
                axios.default.patch('/reply/' + this.data.id , {
                   "body" : this.body
                }).catch(error => {
                    flash(error.response.data , 'danger');
                    this.body = this.data.body
                });
                this.editing = false;
                flash("Updated")
            },
            destroy(){
                axios.default.delete('/reply/' + this.data.id);

                $(this.$el).fadeOut(800 , ()=>{
                    this.$emit('delete',this.data.id);
                    flash('Your Reply Has Been Deleted');
                });
            },
            toggle(){
                 this.isFavorited ? this.delete() : this.create()
            },
            create(){
                axios.default.post(this.link);

                this.favorites_count += 1;
                this.isFavorited = true;
                flash("Favorite Added")
            },
            delete(){
                axios.default.delete(this.link);

                this.favorites_count -= 1;
                this.isFavorited = false;
                flash("Favorite Deleted")
            },
            work_in(){
                flash("We are still working on this")
            }
        }
    }
</script>

<style>
    .myfavbut{
        border: none;
        padding: 0px;
        font-size: 10px;
    }
</style>