<template>
    
    <div :class="[{close: close}, 'closable']" >
        <div class="card-box" :style="`max-width: ${props.label ? props.maxWidth : '100%'}`">
            <div>
                <div class="card-header">
                    <p class="card-label" v-if="props.label">{{ props.label }}</p>
                    <slot name="header"></slot>
                    <div class="header-btn">
                        <button @click="minimize = !minimize" v-if="minimizable"><i :class="`fa-solid fa-${minimize ? 'plus' : 'minus'}`"></i></button>
                        <button @click="close = !close" v-if="closable"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
                <div :class="[{close: minimize}, 'closable']">
                    <div :class="['card-menu']">
                        <div class="card-body">
                            <slot></slot>
                        </div>
                        <div class="card-footer">
                            <slot name="footer"></slot>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

interface Card {
    label ?: string,
    maxWidth ?: string,

    closable?: boolean,
    minimizable?: boolean,
    fullscreenable?: boolean,
    refreshable?: boolean,
}

const props = withDefaults( defineProps<Card>(), {
    closable: false,
    minimizable: false,
    fullscreenable: false,
    refreshable: false,
})

let close = ref(false);
let minimize = ref(false);
let fullscreen = ref(false);
let loading = ref(false);

</script>

<style lang="scss" scoped>

.card-box{
    padding: .5rem 1rem .5rem 1rem;
    background-color: white;
    @include boxShadowSmall();
    width: 100%;
    border-radius: 3px;
    // overflow: hidden;
    position: relative;
    transition: all .5s ease;

    .card-header{
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        .card-label{
            color: $dark-gray;
            margin: 0px;
            margin-right: 1rem;
        }
        .header-btn{
            margin-left: auto;

            button{
                margin-left: .5rem;
                cursor: pointer;
                border: 0px;
                outline: none;
                color: $light-gray;
                background-color: transparent;

                &:hover{
                    color: $black;
                }
            }
        }
    }
    .card-menu{
        transition: height .35s ease-out;  
        // overflow: hidden;
        width: 100%;

        .card-footer{
            padding: .25rem 1.5rem .35rem 1.5rem;
            margin-top: .75rem;
        }
    }

}

.closable{
    display: grid;
    grid-template-rows: 1fr;
    transition: grid-template-rows .5s ease;

    &.close{
        grid-template-rows: 0fr !important;

        .card-box{
            padding: 0px !important;
            overflow: hidden;
        }

        .card-menu{
            overflow: hidden;
        }
    }
}
</style>