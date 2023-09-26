<template>
    <div :class="['info-box']">
        <div :class="`shaded-${boxColor}`">
            <i :class="`fa-${iconType} fa-${icon}`" v-if="icon"></i>
        </div>
        <div class="info-content">
            <p>{{ label }}</p>
            <p class="main-text">{{ text }}</p>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    cardLabel: String,
    cardMaxWidth: String,

    iconType: {
        type: String, 
        default: 'solid',
    },
    icon: {
        type: String,
        required: true,
    },
    iconSize: '',

    boxColor: {
        type: String,
        default: 'red'
    },

    label: String,
    text: String,

})
</script>

<style lang="scss" scoped>
.info-box{
    padding: .5rem;
    background-color: white;
    @include boxShadowSmall();
    width: 100%;
    border-radius: 3px;
    display: flex;
        
    @each $color, $hsl in $palette{
        .shaded-#{""+$color}{
            margin-right: .75rem;
            width: 70px;
            height: 64px;
            border-radius: 3px;
            background-color: hsl(nth($hsl, 1), nth($hsl, 2), nth($hsl, 3));
            transition: .25s ease;
            font-size: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
    
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

        .flat-#{""+$color}{
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

    .info-content{
        display: flex;
        flex-direction: column;

        p{
            margin-top: auto;
            margin-bottom: auto;
        }

        .main-text{
            font-weight: bold;
        }
    }
}
</style>