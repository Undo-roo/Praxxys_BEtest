<template>
    <MainTemplate>
        <div class="auth-box">
            <form @submit.prevent="fields.post('/attempt')">

                <div v-if="message" style="color: green; font-weight: bold; margin-bottom: .5rem;">
                    {{ message }}
                </div>

                <Link href="/register" style="text-decoration: none;">
                    <Button 
                        type="button" color="dark-gray" 
                        style="padding: .25rem 1.5rem .25rem 1.5rem; font-size: 12px; margin-left: auto;"
                        :icon="{name: 'chevron-right', size: '12px'}" label="Register" 
                    />
                </Link>
                <h2>LOGIN</h2>
                
                <p>Username </p>

                <input type="text" v-model="fields.username">
                <h5>{{ fields.errors.username }} </h5>

                <p>Password </p>
                <input type="password" v-model="fields.password">
                <h5>{{ fields.errors.password }} </h5>


                <div class="d-flex">
                    <input type="checkbox" v-model="fields.remember" true-value="1" false-value="0">
                    <p style="margin: 0px; margin-left: .75rem;">Remember me</p>

                    <Button :disabled="disabledSubmit" style="padding: .25rem 1.5rem .25rem 1.5rem; font-size: 15px; margin-left: auto;" label="Submit" />
                </div>
            </form>
        </div>
    </MainTemplate>
</template>

<script setup lang="ts">
import MainTemplate from '@/MainTemplate.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { watch, reactive, ref, computed, onMounted } from 'vue';
import Button from '@/Components/Button.vue';

const message = usePage().props.message

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
@import '../../../css/auth.scss';
</style>