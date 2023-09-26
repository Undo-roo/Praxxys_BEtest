<template>
    <Template>
        <div class="product-box">
            
            <Card 
                card-label="Product List"
                minimizable
            >
            <br>
                <div class="d-flex" style="margin-bottom: 1rem;">
                    <p>Select Category</p>
                    <select v-model="requestData.filterBy">
                        <option default value=""> All </option>
                        <option v-for="option in options" :value="option.id">{{ option.title }}</option>
                    </select>

                    <input type="text" placeholder="Search by Name and Description" v-model="requestData.keyword">
                    <button class="filter-btn" @click="filterData()"> Filter </button>
                </div>
                <CustomDataTable 
                    :columns="columns" :datas="products" :loading="isLoading"
                    :links="links" :server-items-length-init="serverItemsLength"
                    :request-data="requestData"
                >
                    <template #action="{ item }">
                        <button @click="deleteData(item.name, item.id)" class="trash-btn"><i class="fa-solid fa-trash"></i></button>
                        <Link class="edit-btn" :href="`/product/edit/${item.id}`"><i class="fa-solid fa-pen-to-square"></i></Link>
                    </template>
                </CustomDataTable>

                <template #footer>
                    <Link class="create-btn" href="/product/create"> <ButtonIcon label="Create" icon="plus" iconSize="15px" color="dark-gray" /> </Link>
                </template>
            </Card>
        </div>

    </Template>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue';
import Template from '../Dashboard/Template.vue';
import CustomDataTable from '../Components/CustomDataTable.vue';
import Card from '../Components/Widgets/Card.vue';
import moment from 'moment'
import { usePage, Link } from '@inertiajs/vue3';
import ButtonIcon from '@/Components/Button.vue';

const columns = [
  { text: "Name", value: "name" },
  { text: "Category", value: "category.title" },
  { text: "Description", value: "description", width: 500 },
  { text: "Date Time", value: "dateTime" },
  { text: "Operation", value: "action"},
];

const products = ref([]);

const links = ref([]);
const isLoading = ref(false);
const serverItemsLength = ref(0)
const options = usePage().props.categories

const requestData = reactive({
    keyword: '',
    filterBy: ''
});


const convertDateTime = (date) =>{ 
    return moment(date).format('MMMM Do YYYY, h:mm a')
}

const filterData = async () =>{
    isLoading.value = true

    await axios.post('/api/product/data', requestData)
    .then( (res) => {
        let response = res.data

        products.value = response.data.map((item) => {
            item.dateTime = convertDateTime(item.dateTime)
            return item
        })

        links.value = response.links

        links.value[0].label = 'Prev';
        links.value[links.value.length-1].label = 'Next';

        serverItemsLength.value = response.total
    })
    .catch( (error) =>{
        console.log(error)
        isLoading.value = false
    })

    isLoading.value = false
}

const deleteData = async (name, id) =>{
    isLoading.value = true

    if(confirm("Are you sure you want to delete " + name)){
        await axios.post('/api/product/remove', {id: id})
        .then( (res) => {
            products.value = products.value.filter((item) => item.id !== id)
        })
        .catch( (error) =>{
            console.log(error)
            isLoading.value = false
        })
    }

    isLoading.value = false
}

onMounted(async () =>{
    isLoading.value = true

    await axios.post('/api/product/data', requestData)
    .then( (res) => {
        let response = res.data

        products.value = response.data.map((item) => {
            item.dateTime = convertDateTime(item.dateTime)
            return item
        })

        links.value = response.links

        links.value[0].label = 'Prev';
        links.value[links.value.length-1].label = 'Next';

        serverItemsLength.value = response.total
    })
    .catch( (error) =>{
        console.log(error)
        isLoading.value = false
    })

    isLoading.value = false
})
</script>

<style lang="scss" scoped>

.product-box{
    .filter-btn{
        padding: .25rem 1.25rem .25rem 1.25rem;
        outline: none;
        border-radius: 0px 3px 3px 0px;
        border: 1px solid rgb(210, 210, 210);
        cursor: pointer;
        transition: all .25s ease;
        font-weight: bold;     

        &:hover{
            background-color: rgb(210, 210, 210);
        }
    }

    select{
        padding: .25rem 1.25rem .25rem 1.25rem;
        border-radius: 3px;
        border: 1px solid rgb(210, 210, 210);
        transition: all .25s ease;
        font-weight: bold;     
        outline: none;

        &:hover{
            background-color: rgb(243, 243, 243);
        }
    }

    p{
        margin: 0px;
        margin-left: auto;
        margin-right: .75rem;
        font-size: 15px;
    }

    input[type=text]{
        padding: .25rem 1.25rem .25rem 1.25rem;
        outline: none;
        border-radius: 3px 0px 0px 3px;
        border: 1px solid rgb(210, 210, 210);
        border-right: 0px;
        cursor: pointer;
        transition: all .25s ease;
        margin-left: 1.5rem;   

        &:hover{
            background-color: rgb(243, 243, 243);
        }

        max-width: 500px;
        flex: 1;
    }

    .trash-btn, .edit-btn{
        color: $red;
        border: 0px;
        outline: none;
        cursor: pointer;
        background-color: transparent;
        padding: .15rem .5rem .15rem .5rem;
        font-size: 14px;

        &:hover{
            color: rgb(168, 12, 12);
        }
    }

    .create-btn{
        float: right;
        text-decoration: none;

        button{
            padding-top: .2rem;
            padding-bottom: .2rem;
            
        }
    }

    .edit-btn{
        color: rgb(192, 148, 7);

        &:hover{
            color: rgb(147, 114, 5);
        }
    }
}

</style>