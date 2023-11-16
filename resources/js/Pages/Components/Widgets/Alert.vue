<template>
    <div :class="`alert-box ${type}`">
        <h4> Message Title </h4>
        <p>
            Message Box is here 
        </p>
    </div>
</template>

<script setup lang="ts">
interface Alert{
    type?: string,
}

const props = withDefaults(defineProps<Alert>(), {
    type: 'normal',
})

</script>

<style lang="scss" scoped>
.alert-box{
    padding: 20px 0px 20px 20px;
    border-radius: 4px;
    box-shadow: 1px 1px .25rem rgba($color: #000000, $alpha: .25);
    margin-bottom: 15px;
    
    @each $name, $hsl in $alert{
        
        &.#{""+$name}{
            background-color: hsl(nth($hsl, 1), 84%, 89%);
        } 
    }

}
</style>