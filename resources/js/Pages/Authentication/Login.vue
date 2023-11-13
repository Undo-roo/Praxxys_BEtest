<template>
    <Template>
        <form @submit.prevent="fields.post('/attempt')" class="login-box">
            <h2>LOGIN</h2>
            
            <p>Username </p>

            <h5>{{ fields.errors.username }} </h5>
            <input type="text" v-model="fields.username">

            <p>Password </p>
            <h5>{{ fields.errors.password }} </h5>
            <input type="password" v-model="fields.password">


            <div class="d-flex">
                <input type="checkbox" v-model="fields.remember" true-value="1" false-value="0">
                <p style="margin: 0px; margin-left: .75rem;">Remember me</p>

                <Button :disabled="disabledSubmit" style="padding: .25rem 1.5rem .25rem 1.5rem; font-size: 15px; margin-left: auto;" label="Submit">

                </Button>
            </div>
        </form>
    </Template>
</template>

<script setup lang="ts">
import Template from './Template.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { watch, reactive, ref, computed, onMounted } from 'vue';
import Button from '@/Components/Button.vue';

const fields = useForm({
    username: '',
    password: '',
    remember: 0,
});

const errors = reactive({
    username: '',
    password: '',
});

const errorCheck = reactive({
    username: true,
    password: true,
})

const disabledSubmit = computed(() =>{
    return errorCheck.username || errorCheck.password;
})

const required = (text: string, field: string) =>{
    if(text == ''){
        return 'The '+ field+' field is required';
    }

    return '';
}

watch(() => fields.username, () => {
    let msg = required(fields.username, 'Username');
    fields.errors.username = msg;
    errorCheck.username = msg != '';
})

watch(() => fields.password, () => {
    let msg = required(fields.password, 'Password');
    fields.errors.password = msg;
    errorCheck.password = msg != '';
})


</script>

<style lang="scss" scoped>
.login-box{
    margin-top: auto;
    margin-bottom: auto;
    max-width: 400px;
    width: 100%;
    
    input[type=text], input[type=password]{
        background-color: transparent;
        border: 0px;
        border-bottom: 2px solid #FF92A7;
        padding: .25rem 1.25rem .25rem  1.25rem ;
        font-size: 20px;
        outline: none;
        width: 100%;
        margin-bottom: 3rem;
        
        &:hover, &:focus{
            border-bottom: 2px solid #D01B24;
        }
    }

    padding: 1rem;

    h2{
        color: #9A0000;
        margin-bottom: 4rem;
    }
    h5{
        color: #9A0000;
    }
    p{
        margin-bottom: .5rem;
    }
}
</style>