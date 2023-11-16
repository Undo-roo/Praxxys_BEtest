<template>
    <div class="d-flex">
        <input :type="hidden ? 'password' : 'text'" v-model="value">
        <i @click="hidden = !hidden" :class="`fa-solid fa-${hidden ? 'eye-slash' : 'eye'}`"></i>
    </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'

const props = defineProps(['modelValue'])
const emit = defineEmits(['update:modelValue'])

const value = computed({
  get() {
    return props.modelValue
  },
  set(value) {
    emit('update:modelValue', value)
  }
})

const hidden = ref(true);
</script>

<style scoped>
input[type=text], input[type=password]{
    margin-right: 1rem !important;
}

i{
    cursor: pointer;
}
</style>