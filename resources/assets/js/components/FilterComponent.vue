
<template>
    <div class="container">
        
        <div class="card-header">
            <select  id="" v-model="sort" @change="sortValue">
                <option value="1" >Active</option>
                <option value="0" >In-Active</option>
            </select>
        </div>

        <div class="card-body">
            <ul v-for="product in products" :key='product.id'>
                <li>{{ product.id }}</li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props:['post'],
        data(){
            return {
                totallike:'',
                posts:'',
                sort:'',
            }
        },
        methods:{
           loadPost(){
               this.post=this.post
           },
           sortValue(){
               axios.post('/filter',{ sort:this.sort })
               .then(response => ( this.post=response.data.post ))
           }
        },
        mounted() {
            console.log('console filter componet')
        }
    }
</script> 