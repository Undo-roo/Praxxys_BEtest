<template>
    <Template>
        <div class="widgets-box">
            <Card 
                card-label="Sample Card Label" :card-max-width="cardMaxWidth"
                closable minimizable
            >
                <h4>Content of the card</h4>
            </Card>

            <div class="grid-4">
                <InfoBox :icon="{ name: 'house' }" label="Sample1" :text=" '' + Math.floor(Math.random() * 1000) + 1" />
                <InfoBox :icon="{ name: 'house' }" label="Sample2" :text=" '' + Math.floor(Math.random() * 1000) + 1" boxColor="blue" />
                <InfoBox :icon="{ name: 'house' }" label="Sample3" :text=" '' + Math.floor(Math.random() * 1000) + 1" boxColor="green" />
                <InfoBox :icon="{ name: 'house' }" label="Sample4" :text=" '' + Math.floor(Math.random() * 1000) + 1" boxColor="dark-gray" />
            </div>

        </div>
    </Template>
</template>

<script setup lang="ts">
import Template from './Template.vue';
import Card from '@/Components/Widgets/Card.vue';
import InfoBox from '@/Components/Widgets/InfoBox.vue';

const cardMaxWidth = '500px';
</script>

<style lang="scss" scoped>
.grid-4{
    display: grid;
    grid-auto-flow: column;  
    column-gap: 20px;
    margin-top: 2rem;
}
</style>