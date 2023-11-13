<template>
    <Template>
        <form @submit.prevent="fields.post('/product/'+props.link)" class="create-box">
            <Card card-label="Product Details" card-max-width="800px">
                <div class="form-box">

                    <h3> Product Name </h3>
                    <input :class="{error: fields.errors.name}" type="text" placeholder="Product Name" v-model="fields.name">
                    <span class="error-text">{{ fields.errors.name }}</span>

                    <h3> Category </h3>

                    <select :class="{error: fields.errors.category}" v-model="fields.category">
                        <option disabled default value=""> Select a Category </option>
                        <option v-for="option in options" :value="option.id">{{ option.title }}</option>
                    </select>

                    <span class="error-text">{{ fields.errors.category }}</span>

                    <h3> Description </h3>
                    <editor
                        api-key="jeu9xm3w2wteubrc0xslnkg7x3o1vh7nbjbm11qywrrvcc8i"
                        :init="init"
                        v-model="fields.description"
                        :class="{error: fields.errors.description}" 
                    />
                    <span class="error-text">{{ fields.errors.description }}</span>

                    <ButtonIcon type="button" @click="verifyDetails()" :loading="fields.processing" :disabled="disabledSubmitDetails || doneFeilds.details" class="verify-btn" :icon="{ name: doneFeilds.details ? 'check-double' : 'check' }" label="Verify" :color="doneFeilds.details ? 'green' : 'dark-gray'" />
                </div>
            </Card>

            <Transition name="left" >
                
                <Card v-if="showFeilds.image" card-label="Product Images" card-max-width="800px" style="margin-top: 2rem;">
                    <div class="form-box">
                        <div class="image-show d-flex">
                            <div v-for="(preview, ind) in previews" class="image-box" :style="`background-image: url('${preview}')`">
                                <ButtonIcon type="button"  @click="deleteFile(ind)" :icon="{name: 'xmark'}" square />
                            </div>
                        </div>
                        <span class="error-text">{{ fields.errors.images }}</span>
                        <input @change="addFile($event)" type="file" accept=".jpg,.png,.jpeg" >
                        <ButtonIcon type="button" @click="verifyImage()" :loading="fields.processing" :disabled="detailsCheck.images || doneFeilds.image || !doneFeilds.details" class="verify-btn" :icon="{ name: doneFeilds.details ? 'check-double' : 'check' }" label="Verify" :color="doneFeilds.image ? 'green' : 'dark-gray'" />
                    </div>
                </Card>
            </Transition>

            <Transition name="left" >
                
                <Card v-if="showFeilds.dateTime" card-label="Product Date and Time" card-max-width="800px" style="margin-top: 2rem;">
                    <div class="form-box">

                        <VueDatePicker v-model="fields.dateTime" uid="demo" />
                        <span class="error-text">{{ fields.errors.dateTime }}</span>
                        <ButtonIcon :loading="fields.processing" :disabled="!doneFeilds.details || !doneFeilds.image || detailsCheck.dateTime" class="verify-btn" :icon="{ name: doneFeilds.details ? 'check-double' : 'check' }" label="Submit" color="blue" />
                    </div>
                </Card>
            </Transition>
        </form>
    </Template>
</template>

<script setup lang="ts">
import Template from '@/Admin/Dashboard/Template.vue';
import Card from '@/Components/Widgets/Card.vue';
import Editor from '@tinymce/tinymce-vue'
import ButtonIcon from '@/Components/Button.vue';
import { InertiaForm, Link, useForm, usePage } from '@inertiajs/vue3';
import { reactive, watch, computed, Ref, ref } from 'vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import moment from 'moment';
import '@vuepic/vue-datepicker/dist/main.css';

const props = defineProps({
    product: Object,
    link: {
        type: String,
        default: 'store'
    },
    location: {
        type: String,
        default: 'Product/Create'
    },
})

const verifyDetailsLink = props.product ? '/product/'+props.product.id+'/verify/details' : '/product/verify/details'
const verifyImageLink = props.product ? '/product/'+props.product.id+'/verify/images' : '/product/verify/images'

const previews: Ref<string[]> = ref([]);
const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

interface CategorySelect {
    id: number,
    title: string,
}

const fields: InertiaForm<{
    name: string,
    category: string,
    description: string,
    dateTime?: string,
    images: File[],
    location: string,
    id?: number
}> = useForm({
    name: props.product ? props.product.name : '',
    category: props.product ? props.product.category_id : '',
    description: props.product ? props.product.description : '',
    dateTime: props.product ? props.product.dateTime : null,
    images: [],
    location: props.location,
    id: props.product ? props.product.id : null,
});
const detailsCheck = reactive({
    name: !props.product,
    category: !props.product,
    description: !props.product,
    dateTime: !props.product,
    images: !props.product,
})

const doneFeilds = reactive({
    details: !!props.product,
    image: !!props.product,
    dateTime: !!props.product,
})


const showFeilds = reactive({
    image: !!props.product,
    dateTime: !!props.product,
    // image: true,
    // dateTime: true,
})

const verifyDetails = () => {

    fields.post(verifyDetailsLink, {
        preserveScroll: true,
        onSuccess: () => {
            doneFeilds.details = true;
            showFeilds.image = true
        },
    })
}

const verifyImage = () => {
    fields.post(verifyImageLink, {
        preserveScroll: true,
        onSuccess: () => {
            doneFeilds.image = true;
            showFeilds.dateTime = true
        },
    })
    showFeilds.dateTime = true
}

const previewImage = (file: File) =>{
    if(file){
        let reader = new FileReader

        reader.onload = e =>{
            // previews[this.field].preview = e.target.
            if(e.target){
                previews.value.push(e.target.result as string)
            }
        }

        reader.readAsDataURL(file)
    }
}

const addFile = (event: Event) => {
    const target = event.target as HTMLInputElement;

    if(target){
        if(target.files){
            const file: File = target.files[0];

            let filePath = file.name

            if(allowedExtensions.exec(filePath)){
                fields.images.push(target.files[0])
                previewImage(target.files[0])
            }
            else{
                alert("Invalid Image");
            }
        }
    }
}

const deleteFile = (ind: number) =>{
    fields.images.splice(ind, 1);
    previews.value.splice(ind, 1);
}

const disabledSubmitDetails = computed(() =>{
    return detailsCheck.name || detailsCheck.category || detailsCheck.description;
})

const required = (text: string = "", field: string) =>{
    if(text == '' || text == null){
        return 'The '+ field+' field is required';
    }

    return '';
}

watch(() => fields.name, () => {
    let msg = required(fields.name, 'Product Name');
    fields.errors.name = msg;

    let result = msg != '';
    detailsCheck.name = result;

    doneFeilds.details = false;
})

watch(() => fields.category, () => {
    let msg = required(fields.category, 'Category');
    fields.errors.category = msg;
    
    let result = msg != '';
    detailsCheck.category = msg != '';

    if(result){
        doneFeilds.details = false;
    }
})

watch(() => fields.description, () => {
    let msg = required(fields.description, 'Desription');
    fields.errors.description = msg;

    let result = msg != '';
    detailsCheck.description = msg != '';

    doneFeilds.details = false;
})

watch(() => fields.dateTime, () => {
    
    let msg = required(fields.dateTime, 'Date and time');
    fields.errors.dateTime = msg;
    detailsCheck.dateTime = msg != '';

    if(msg == ''){
        fields.dateTime = moment(fields.dateTime).format('YYYY-M-D, H:mm:ss')
    }
})

watch(() => fields.images, () => {
    if(fields.images.length <= 0){
        fields.errors.images = "Image is required";
        detailsCheck.images = true;
    }
    else{
        detailsCheck.images = false;
        fields.errors.images = "";
    }

    doneFeilds.image = false;
}, {deep: true})


const options: CategorySelect[] = usePage().props.categories as CategorySelect[]
const init = {
    menubar: false,
    resize: false,
    plugins: 'lists link image emoticons',
    toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image emoticons'
}

</script>

<style lang="scss" scoped>
.create-box{
    .form-box{
        width: 100%;
        display: flex;
        flex-direction: column;

        .image-show{
            margin-bottom: 2rem;
            .image-box{
                margin-right: 1rem;
                width: 100px;
                height: 100px;
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                border-radius: 5px;

                position: relative;

                button{
                    position: absolute;
                    top: -8px;
                    right: -8px;
                    padding: .35rem !important;
                }
            }
            flex-wrap: wrap;
        }
        select{
            padding: .35rem 0rem .35rem 1.25rem;
            border-radius: 3px;
            border: 1px solid rgb(210, 210, 210);
            transition: all .25s ease;
            font-weight: bold;     
            outline: none;
            max-width: 500px;

            &:hover{
                background-color: rgb(243, 243, 243);
            }
        }

        input[type=text]{
            padding: .35rem 0rem .35rem 1.25rem;
            outline: none;
            border-radius: 3px 0px 0px 3px;
            border: 1px solid rgb(164, 164, 164);
            cursor: pointer;
            transition: all .25s ease;
            font-size: 15px;

            &:hover{
                background-color: rgb(243, 243, 243);
            }

        }

        textarea, input[type=text], select{

            &.error{
                border: $red solid 1px;
                background-color: rgb(255, 237, 237);
            }
        }

        .verify-btn{
            margin-top: 1rem;
            align-self: flex-end;
            padding-top: .2rem;
            padding-bottom: .2rem;
        }

        .error-text{
            margin-top: .75rem;
            color: $red;
        }
    }
}
</style>