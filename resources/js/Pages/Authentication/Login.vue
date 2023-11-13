<template>
    <MainTemplate>
        <div class="login-box">
            <form @submit.prevent="fields.post('/attempt')">
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

                    <Button :disabled="disabledSubmit" style="padding: .25rem 1.5rem .25rem 1.5rem; font-size: 15px; margin-left: auto;" label="Submit">

                    </Button>
                </div>
            </form>
        </div>
    </MainTemplate>
</template>

<script setup lang="ts">
import MainTemplate from '@/MainTemplate.vue';
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
    display: flex;
    width: 100%;
    height: 100%;
    align-items: center;

    form{
        margin-left: 2.5rem;
        flex: 1;
        max-width: 700px;
        box-shadow: 0px 0px .5rem rgba($color: #000000, $alpha: .30);
        border-radius: 5px;
        padding: 1.5rem;
        margin-right: auto;
        margin-left: auto;
    }
    
    input[type=text], input[type=password]{
        background-color: transparent;
        border-radius: 3px;
        border: 0px;
        box-shadow: 0px 0px .25rem rgba($color: #000000, $alpha: .35);
        // border-bottom: 2px solid #FF92A7;
        padding: .5rem 1.25rem .5rem  1.25rem ;
        font-size: 17px;
        outline: none;
        width: 100%;
        color: #373737;
        
        &:hover, &:focus{
            border: 0px;
            box-shadow: inset 0px 0px .25rem rgba($color: #000000, $alpha: .30);
        }
    }


    h2{
        color: #09365f;
        margin-bottom: 4rem;
    }
    h5{
        margin-bottom: 3rem;
        color: #9A0000;
    }
    p{
        margin-bottom: .5rem;
    }
}
</style>