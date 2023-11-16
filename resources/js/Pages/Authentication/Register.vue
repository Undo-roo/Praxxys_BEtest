<template>
    <MainTemplate>
        <div class="auth-box">
            
            <form @submit.prevent="fields.post('/register')">
                
                <!-- <div v-if="flash">
                    {{ flash }}
                </div> -->

                <Link href="/login" style="text-decoration: none;">
                    <Button 
                        type="button" color="dark-gray" 
                        style="padding: .25rem 1.5rem .25rem 1.5rem; font-size: 12px; margin-left: auto;"
                        :icon="{name: 'chevron-left', size: '12px'}" label="Login" 
                    />
                </Link>

                <h2>REGISTER</h2>
                
                <p>Full name </p>
                <input type="text" v-model="fields.name">
                <h5>{{ fields.errors.name }} </h5>

                <p>Username </p>
                <input type="text" v-model="fields.username">
                <h5>{{ fields.errors.username }} </h5>

                <p>Email </p>
                <input type="text" v-model="fields.email">
                <h5>{{ fields.errors.email }} </h5>

                <p>Password </p>
                <EyeTextInput v-model="fields.password" />
                <!-- <input type="password" v-model="fields.password"> -->
                <h5>{{ fields.errors.password }} </h5>

                <p>Confirm Password </p>
                <EyeTextInput v-model="fields.password_confirmation" />
                <!-- <input type="password" v-model="fields.confirm_password"> -->
                <h5>{{ fields.errors.password_confirmation }} </h5>


                <div class="d-flex">

                    <Button color="blue" :disabled="disabledSubmit" style="padding: .25rem 1.5rem .25rem 1.5rem; font-size: 15px; margin-left: auto;" label="Create">

                    </Button>
                </div>
            </form>
        </div>
    </MainTemplate>
</template>

<script setup lang="ts">
import MainTemplate from '@/MainTemplate.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { watch, reactive, computed } from 'vue';
import Button from '@/Components/Button.vue';
import EyeTextInput from '@/Components/EyeTextInput.vue';


const fields = useForm({
    username: '',
    email: '',
    name: '',
    password_confirmation: '',
    password: '',
});

const errors = reactive({
    username: '',
    password: '',
    email: '',
    name: '',
    password_confirmation: '',
});

const errorCheck = reactive({
    username: true,
    password: true,
    email: true,
    name: true,
    password_confirmation: true,
})

const disabledSubmit = computed(() =>{
    return errorCheck.username || errorCheck.password || errorCheck.password_confirmation || errorCheck.email || errorCheck.name ;
})

const required = (text: string, field: string) =>{
    if(text == ''){
        return 'The '+ field+' field is required';
    }

    return '';
}

const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

watch(() => fields.username, () => {
    let msg = required(fields.username, 'Username');
    fields.errors.username = msg;
    errorCheck.username = msg != '';
})

watch(() => fields.name, () => {
    let msg = required(fields.name, 'Name');
    fields.errors.name = msg;
    errorCheck.name = msg != '';
})

watch(() => fields.password, () => {
    let msg = required(fields.password, 'Password');
    fields.errors.password = msg;
    errorCheck.password = msg != '';
})

watch(() => fields.email, () => {
    // let msg = required(fields.email, 'Email');
    let msg = '';
    if(!pattern.test(fields.email)){
        msg = 'Invalid Email Format';
    }

    fields.errors.email = msg;
    errorCheck.email = msg != '';
})

watch(() => fields.password_confirmation, () => {
    let msg = required(fields.password_confirmation, 'Confirm Password');

    if(fields.password_confirmation != fields.password){
        msg = 'password and password confirmation does not match'
    }

    fields.errors.password_confirmation = msg;
    errorCheck.password_confirmation = msg != '';
})

</script>

<style lang="scss">
@import '../../../css/auth.scss';
</style>