<template>
    <Head title="Show image and watermark"/>


    <Modal class="z-50"
           v-show="isModalVisible"
           @close="closeModal">
        <template v-slot:header>
            Select watermarks.
        </template>
        <template v-slot:body>
            <div class="flex md:w-1.5/12">
                <form class="flex flex-col-reverse" @submit.prevent="submit">
                    <div class="flex justify-around">
                        <input type="radio" class="form-radio h-4 w-4 text-purple-600 xl:h-5 xl:w-5"
                               value="storage/images/adguard-watermark-256.png" v-model="form.radio">
                        <input type="radio" class="form-radio h-4 w-4 text-purple-600 xl:h-5 xl:w-5"
                               value="storage/images/draft-watermark-256.png" v-model="form.radio">
                        <input type="radio" class="form-radio h-4 w-4 text-purple-600 xl:h-5 xl:w-5"
                               value="storage/images/icon-documents-256.png" v-model="form.radio">
                    </div>
                    <div class="flex md:justify-around">
                        <img src="/storage/images/adguard-watermark-256.png" class="" alt="Broken">
                        <img src="/storage/images/draft-watermark-256.png" class=" " alt="Broken">
                        <img src="/storage/images/icon-documents-256.png" class=" " alt="Broken">
                    </div>
                </form>
            </div>
        </template>
        <template v-slot:footer>
            <form @submit.prevent="form.get('/watermark/'+images.id)">
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                    Add watermark
                </button>
            </form>

        </template>
    </Modal>

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="flex space-x-3">
                <button type="button"
                        class="flex bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                        @click="showModal">
                    Add watermark
                </button>
                <form @submit.prevent="form.delete('/image/'+images.id)" class="flex">
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                        Delete all
                    </button>
                </form>
                <form @submit.prevent="formSharing.get('/sharingImageImgur/?src='+images.image)">
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                        Sharing to imgur
                    </button>
                </form>
            </div>
        </template>

        <div class="container mx-auto">
            <div v-if="$page.props.flash.message" id="alert"
                 class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mt-3 rounded relative"
                 role="alert">
                <strong class="font-bold">{{ $page.props.flash.message }}</strong>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg @click="delete $page.props.flash.message" class="fill-current h-6 w-6 text-green-500" role="button"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path
                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
            </div>
            <div v-for="(errorMsg, errorIndex) in errors" id="alert"
                 class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mt-3 rounded relative" role="alert">
                <strong class="font-bold">{{ errorMsg }}</strong>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg @click="delete this.errors[errorIndex]" class="fill-current h-6 w-6 text-red-500" role="button"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path
                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
            </div>
        </div>

        <div class="container flex justify-center px-5 py-4 mx-auto">
            <div class="flex ">
                <a class="flex rounded overflow-hidden">
                    <img alt="ecommerce" class="object-cover object-center w-full h-full block"
                         :src="'/'+images.image">
                </a>
            </div>
        </div>
        <div class="container px-5 py-4 mx-auto">
            <div class="flex flex-wrap colo -m-4">
                <div v-for="watermark in watermarkImage" class=" px-4 py-4 md:w-6/12 lg:w-4/12">
                    <a class=" block relative rounded overflow-hidden">
                        <img alt="ecommerce" class="object-cover object-center w-full h-full block" id="url"
                             :src="'/'+watermark.image">
                    </a>
                    <div class="flex mt-3 space-x-3">
                        <form @submit.prevent="form.delete('/delete-watermark/'+watermark.id)">
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                Delete
                            </button>
                        </form>
                        <form @submit.prevent="formSharing.get('/sharingImageImgur/?src='+watermark.image)">
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                Sharing to imgur
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import {Head} from "@inertiajs/inertia-vue3";
import {useForm} from '@inertiajs/inertia-vue3';
import Modal from "@/Components/Modal";

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Modal
    },
    data() {
        return {
            isModalVisible: false
        }
    },
    name: "ShowImageWithWatermark",
    props: ['images', 'watermarkImage', 'errors'],
    setup() {
        const form = useForm({
            radio: null,
        })
        const formSharing = useForm()

        return {form, formSharing}
    },
    methods: {
        showModal() {
            this.isModalVisible = true;
        },
        closeModal() {
            this.isModalVisible = false;
        }
    },
}
</script>
