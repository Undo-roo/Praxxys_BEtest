<template>
    <EasyDataTable
        v-if="props.links.length > 0"
        :current-page="page"
        :items="items"
        :headers="props.columns"
        :loading="isLoading"
        :hide-rows-per-page="true"
        empty-message="No data found in the database."
    >
        <template #item-action="item">
            <slot name="action" :item="item"></slot>
        </template>

        <template #pagination>
            <p style="margin: 0px; margin-right: 1rem;"> {{ rowsPerPage*(page-1) + 1 }}-{{ rowsPerPage*page }} of {{ serverItemsLength }}</p>
            <button :disabled="!link.url" :class="[{active: link.active} , 'pagination-btn']" v-for="(link) in links" @click="updateItems(link.url)">
                {{ link.label }}
            </button>
        </template>
    </EasyDataTable>

    <EasyDataTable
        v-else
        :headers="props.columns"
        :items="props.datas"
    >
        <template #item-action="{ item }">
            <slot name="action"></slot>
        </template>
    </EasyDataTable>
</template>

<script setup>
import { ref, watch } from 'vue'
import EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';
import moment from 'moment'

const emits = defineEmits(['Common Emits'])

const props = defineProps({
    columns: {
        type: Array,
        default(){
            return [];
        }
    },
    datas: {
        type: Array,
        default(){
            return [];
        }
    },
    options: {
        type: Object,
        default(){
            return {};
        }
    },
    links: {
        type: Array,
        default: [],
    },
    loading: {
        type: Boolean,
        default: false,
    },

    serverItemsLengthInit: {
        type: Number,
        default: 0,
    },
    requestData:{
        type: Object,
        default(){
            return {};
        }
    },
})


const isLoading = ref(props.loading);
const items = ref(props.datas);
const serverItemsLength = ref(props.serverItemsLengthInit);
const rowsPerPage = ref(20);
const page = ref(1);
const links = ref(props.links);

watch(() => props.links, (value) => { 
    links.value = props.links 

}, { deep: true });

watch( () => props.serverItemsLengthInit, () => { 
    serverItemsLength.value = props.serverItemsLengthInit
});

watch(() => props.datas, (value) => { 
    items.value = props.datas
    page.value = 1

}, { deep: true });

const convertDateTime = (date) =>{ 
    return moment(date).format('MMMM Do YYYY, h:mm a')
}

const updateItems = (url) =>{
    isLoading.value = true

    axios.post(url, props.requestData)
    .then( (res) => {
        let response = res.data

        items.value = response.data
        serverItemsLength.value = response.total
        links.value = response.links
        page.value = response.current_page


        items.value = response.data.map((item) => {
            item.dateTime = convertDateTime(item.dateTime)
            return item
        })
        
        links.value[0].label = 'Prev';
        links.value[links.value.length-1].label = 'Next';
    })
    .catch( (error) =>{
        isLoading.value = false;
        console.log(error)
    })
    isLoading.value = false;
}
</script>

<style lang="scss">
.pagination-btn{
    border: 0px;
    border-radius: 3px;
    background-color: white;
    padding: .15rem .5rem .15rem .5rem;
    margin-right: .35rem;

    cursor: pointer;

    &.active{
        background-color: $red;
        color: white;
    }

    &:hover{
        background-color: rgb(168, 12, 12);
        color: white;
    }

    &:disabled{
        background-color: $light-gray;
        color: white;
        cursor: default !important;
    }
}
.pagination__items-index{
    display: none !important;
}
</style>