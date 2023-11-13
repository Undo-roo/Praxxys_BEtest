<template>
    <button 
    :disabled="props.disabled || props.loading" 
    :class="[{solo: !props.label, square: props.square}, `${props.variant}-${props.color}`]">
        <slot name="icon"></slot>

        <i 
        :class="`
            fa-${props.icon?.type ?? 'solid'} fa-${props.loading ? 'spinner' : props.icon?.name} ${props.loading ? 'fa-spin' : ''}`" 
            :style="`font-size: ${props.icon?.size ?? '18px'}`" 
            v-if="icon">
        
        </i>
        {{ label }}
    </button>
</template>

<script setup lang="ts">
import { Icon } from '@/Utilities/Interfaces';

interface Button {
    label?: string,
    variant?: string,
    color?: string,
    
    icon?: Icon,
    loading?: boolean,
    square?: boolean,
    disabled?: boolean,
}

const props = withDefaults( defineProps<Button>(), {
    label: '',
    variant: 'shaded',
    color: 'red',
    
    loading: false,
    square: false,
    disabled: false,
})
</script>

<style lang="scss" scoped>
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