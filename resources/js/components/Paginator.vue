<template>
    <nav aria-label="Page navigation example" v-if="shouldPaginate" class="d-flex justify-content-center">
        <ul class="pagination">
            <li class="page-item" v-if="prevUrl">
                <a class="page-link sm" href="prev" aria-label="Previous" rel="prev" @click.prevent="page--">
                    <span aria-hidden="true">&laquo; Previous</span>
                </a>
            </li>

            <div  v-for="singlePage in totalPage">
                <li class="page-item">
                    <a class="page-link sm" :class="{active : isActive(singlePage)}" href="#" @click.prevent="page = singlePage" v-text="singlePage"></a>
                </li>
            </div>

            <li class="page-item" v-if="nextUrl">
                <a class="page-link sm" href="next" aria-label="Next" rel="next" @click.prevent="page++">
                    <span aria-hidden="true">Next &raquo;</span>
                </a>
            </li>
        </ul>
    </nav>

</template>

<script>
    export default {
        props:['dataSet'],
        data(){
            return{
                page: 1,
                prevUrl: false,
                nextUrl: false,
                totalPage:0
            }
        },
        computed:{
            shouldPaginate(){
                return !!this.prevUrl || !!this.nextUrl
            }
        },
        watch:{
            dataSet(){
                this.page = this.dataSet.current_page;
                this.prevUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;
                this.totalPage = this.dataSet.last_page
            },
            page(){
                this.broadcast().updateUrl();
            }
        },
        methods: {
            broadcast(){
                return this.$emit('changedPage', this.page)
            },
            updateUrl(){
                history.pushState('','','?page=' + this.page)
            },
            isActive(singlePage){
                return this.page === singlePage
            }
        }
    }
</script>

<style>
    .active{
        z-index: 2 !important;
        box-shadow : 0 0 7px 0.2rem rgba(0, 140, 255, 0.42) !important;
    }
    .sm{
        padding: 3px 10px;
        background-color: #f7f7f7;
    }
</style>