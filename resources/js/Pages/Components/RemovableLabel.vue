<template>
    <div :class="[{remove: remove}, 'removable-label']">
        <slot></slot>
        <slot name="image"></slot>
        <slot name="icon"></slot>

        <i :class="`fa-${props.icon.type ?? 'solid'} fa-${props.icon.name}`"></i>
        <img :src="img" alt="" v-if="img">

        <span class="label">{{ label }}</span>
    </div>
</template>

<script setup lang="ts">
import { Icon } from '@/Utilities/Interfaces'

interface RemovableLabel{
    label?: string,
    img?: string,
    icon: Icon
    remove?: boolean,
}

const props = withDefaults( defineProps<RemovableLabel>(), {
    label: '',
    img: '',
    remove: false,
})
</script>

    lable: stron
    <style lang="scss" scoped>
.removable-label{
    
}
</style>