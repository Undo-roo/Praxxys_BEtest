<template>
    <div class="quantity-box">
        <button @click="add(-1)" class="left"><i class="fa-solid fa-minus"></i></button>
        <input class="input" type="text" :value="value" @change="changeQty">
        <button @click="add(1)" class="right"><i class="fa-solid fa-plus"></i></button>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, WritableComputedRef } from 'vue'

const props = defineProps(['modelValue'])
const emit = defineEmits(['update:modelValue', 'changeVal'])

let pattern =/[A-Z|a-z]+/g;


const value:WritableComputedRef<number> = computed({
  get() {
    let qty = parseInt(props.modelValue);

    emit('changeVal');
    return qty;
  },
  set(value) {
    emit('update:modelValue', parseInt(value+""));
  }
})

function add(one: number){
    let newVal = value.value + one;

    if(value.value + one > 0 ){
        value.value = newVal;
    }
}
function changeQty(event: Event){
    const target = event.target as HTMLInputElement;
     
    let qty = parseInt(target.value);
    
    if( isNaN(qty) || pattern.test(target.value)){
        value.value = 1;
    }
    else if(qty < 1){
        value.value = 1;
    }
    else{
        value.value = qty;
    }
}
</script>

<style lang="scss" scoped>
$borderColor: #888888;
.quantity-box{
    display: flex;
    
    button, .input{
        padding: .35rem .5rem .35rem .5rem;
    }

    button{
        background-color: white;
        outline: none;
        border: 1px solid $borderColor;
        cursor: pointer;
        transition: .25s;
        color: rgb(75, 75, 75);

        &:hover{
            color: black;
        }

        i{
            font-size: 10px;
        }
    }

    .right{
        border-left: none;
    }
    .left{
        border-right: none;
    }

    .input{
        text-align: center;
        max-width: 50px;
        font-size: 12px;
        outline: none;
        border: 1px solid $borderColor;
        border-left: 0px;
        border-right: 0px;
    }
}
</style>