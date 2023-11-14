<template>
    <div class="quantity-box">
        <button @click="add(1)" class="left"><i class="fa-solid fa-chevron-up"></i></button>
        <input class="input" type="text" v-model="value">
        <button @click="add(-1)" class="right"><i class="fa-solid fa-chevron-down"></i></button>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, WritableComputedRef } from 'vue'

const props = defineProps(['modelValue'])
const emit = defineEmits(['update:modelValue'])

const value:WritableComputedRef<number> = computed({
  get() {
    return parseInt(props.modelValue)
  },
  set(value) {
    emit('update:modelValue', value)
  }
})

function add(one: number){
    let newVal = value.value + one;

    if(value.value + one > 0 ){
        value.value = newVal;
    }
}
</script>

<style lang="scss" scoped>
.quantity-box{
    display: flex;
    
    button, .input{
        padding: .25rem .5rem .25rem .5rem;
    }

    button{
        background-color: white;
        outline: none;
        border: 1px solid;
        cursor: pointer;
    }

    .right{
        border-radius: 0px 3px 3px 0px;
        border-left: none;
    }
    .left{
        border-radius: 3px 0px 0px 3px;
        border-right: none;
    }

    .input{
        text-align: center;
        max-width: 60px;
        border: 1px solid;
        font-size: 12px;
        // border-left: 0px;
        // border-right: 0px;
    }
}
</style>