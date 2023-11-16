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

        <template #item-dateTime="item">
            {{ convertDateTime(item.dateTime) }}
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
        :items="props.items"
    >
        <template #item-action="{ item }">
            <slot name="action"></slot>
        </template>
    </EasyDataTable>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';
import moment from 'moment';
import { Product, Category } from '@/Utilities/Classes';
import { Pagination } from '@/Utilities/Type/Pagination';

const emits = defineEmits(['Common Emits'])


interface Items extends Product{
    category: Category
}

interface Response extends Pagination{
    data: Items[],
} 

interface DataTable{
    columns?: any[],
    items: Product[],
    options?: any[],
    links: any[],
    loading?: boolean,
    
    serverItemsLengthInit?: number,
    requestData?: {}, 
}

const props = withDefaults( defineProps<DataTable>(), {
    loading: false,
    serverItemsLengthInit: 0,
})

const isLoading = ref(props.loading);
const items = ref(props.items);
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

watch(() => props.items, (value) => { 
    items.value = props.items
    page.value = 1

}, { deep: true });

const convertDateTime = (date: string) =>{ 
    return moment(date).format('MMMM Do YYYY, h:mm a')
}

const updateItems = async (url: string) =>{
    isLoading.value = true

    const { data, status } = await axios.post<Response[]>(url, props.requestData)
    
    items.value = data.data
    serverItemsLength.value = data.total
    links.value = data.links
    page.value = data.current_page


    items.value = data.data
    
    links.value[0].label = 'Prev';
    links.value[links.value.length-1].label = 'Next';
    
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