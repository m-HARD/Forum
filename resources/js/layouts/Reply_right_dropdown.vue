<template>
    <div v-if="singedIn" style="display: inline-flex;">
        <div class="dropdown" style="float: right;">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" style="margin-left: 18px;margin-top: -4px;padding: 0px;background-color: #f7f7f7;">

            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                <div v-if="canUpdate">
                    <button class="dropdown-item" @click="destroy()"><i class="fa fa-trash" style="color: red"></i> Delete Reply</button>
                    <button class="dropdown-item" @click="editClick()"><i class="fa fa-pencil" style="color: blue"></i> Edit</button>
                </div>

                <div v-if="!canUpdate">
                    <button class="dropdown-item" @click="work_in()"><i class="fa fa-bug" style="color: red"></i> Report This</button>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['data'],
        data(){
            return{

            }
        },
        computed:{
            singedIn(){
                return window.App.singedIn
            },
            canUpdate(){
                return this.authorize(user => this.data.user_id === user.id)
            }
        },
        methods: {
            destroy(){
                this.$emit('destroy')
            },
            editClick(){
                this.$emit('editClick')
            },
            work_in(){
                flash("We are still working on this")
            }
        }
    }
</script>

<style>

</style>