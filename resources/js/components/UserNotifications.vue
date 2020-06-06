<template>
    <li class="nav-item dropdown" v-if="notifications.length">
        <a id="navbarDropdown" class="nav-link " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="fa fa-bell"></span><span class="notifyCount" v-text="notifyCount"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" >
            <a v-for="notification in notifications" class="dropdown-item"
               :href="notification.data.link" v-text="notification.data.message"
                @click="markAsRead(notification)"
            ></a>
        </div>
    </li>
</template>

<script>
    export default {
        data(){
            return{
                notifications : false,
                notifyCount : 0
            }
        },
        created() {
            this.refrech()
        },
        methods:{
            refrech(){
                axios.default.get("/profile/" + window.App.user.name + "/notifications")
                    .then(response => [this.notifications = response.data , this.notifyCount = response.data.length])
            },
            markAsRead(notification){
                axios.default.delete("/profile/" + window.App.user.name + "/notifications/" + notification.id);
                this.refrech()
            }
        }
    }
</script>

<style >
    .notifyCount{
        font-size: 9px;
        position: absolute;
    }
</style>