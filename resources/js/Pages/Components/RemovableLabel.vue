<template>
    <div :class="[{remove: remove}, 'removable-label']">
        <slot></slot>
        <slot name="image"></slot>
        <slot name="icon"></slot>

        <i :class="`fa-${font.type} fa-${font.icon}`"></i>
        <img :src="img" alt="" v-if="img">

        <span class="label">{{ label }}</span>
    </div>
</template>

<script setup>
defineProps({
    label: String,
    img: String,
    font: {
        type: Object,
        default(rawProps){
            return {
                type: 'solid',
                icon: '',
                fontSize: '',
            }
        }
    },
    remove: {
        type: Boolean,
        default: false,
    }
})
</script>

<style lang="scss" scoped>
.removable-label{
    
}
</style>