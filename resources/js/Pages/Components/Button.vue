<template>
    <button :disabled="disabled || loading" :class="[{solo: !label, square: square}, `${variant}-${color}`]">
        <slot name="icon"></slot>

        <i :class="`fa-${fontType} fa-${loading ? 'spinner' : icon} ${loading ? 'fa-spin' : ''}`" :style="`font-size: ${iconSize}`" v-if="icon"></i>
        {{ label }}
    </button>
</template>

<script setup>
defineProps({
    label: String,
    variant: {
        type: String, 
        default: 'shaded',
    },
    fontType: {
        type: String, 
        default: 'solid',
    },
    icon: String,
    iconSize: '18px',
    color: {
        type: String, 
        default: 'red',
    },
    loading: {
        type: Boolean,
        default: false
    },
    square: Boolean,
    disabled: {
        type: Boolean,
        default: false
    },
})
</script>

<style lang="scss" scoped>
$label: v-bind(label);


.solo{
    padding: 0rem 1rem 0rem 1rem;

    i{
        margin-right: .0rem;
    }
}

button{
    @include rectangularBox();
    display: flex;
    align-items: center;
    border: none;

    max-height: 33px;

    &.square{
        padding: 0.75rem .65rem 0.75rem .65rem !important;
    }

    @each $color, $hsl in $palette{
        &.shaded-#{""+$color}{

            background-color: hsl(nth($hsl, 1), nth($hsl, 2), nth($hsl, 3));
            transition: .25s ease;
    
            @if $color != white{
                color: white;
            }

            &:hover{
                @if $color != black{
                    background-color: hsl(nth($hsl, 1), nth($hsl, 2), nth($hsl, 3)-10);
                }
                @else{
                    background-color: hsl(nth($hsl, 1), nth($hsl, 2), nth($hsl, 3)+15);
                }
            }

            &:disabled{
                @if $color != white{
                    background-color: hsl(nth($hsl, 1), nth($hsl, 2)+20, nth($hsl, 3)+20);
                }
                @else{
                    background-color: hsl(nth($hsl, 1), nth($hsl, 2)-20, nth($hsl, 3)-20);
                }
            }
        }

        &.flat-#{""+$color}{
            background-color: transparent;
            transition: .25s ease;

            @if $color != white{
                color: hsl(nth($hsl, 1), nth($hsl, 2)-30, nth($hsl, 3)+20);
            }


            &:hover{
                color: hsl(nth($hsl, 1), nth($hsl, 2)-5, nth($hsl, 3));
            }
        }
    }

    cursor: pointer;

    &:disabled{
        cursor: default;
    }

    
    i{
        margin-right: .75rem;
    }
}
</style>