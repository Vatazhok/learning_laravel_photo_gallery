<template>
    <Head title="Show image and watermark"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <button form="selectImage" type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                Share selected
            </button>
        </template>
        <div v-for="(errorMsg, errorIndex) in errors" id="alert"
             class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">{{ errorMsg }}</strong>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg @click="delete this.errors[errorIndex]" class="fill-current h-6 w-6 text-red-500" role="button"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path
                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
        </div>
        <!--        <template>-->

            <div class="container px-5 py-4 mx-auto">
                <div class="flex flex-wrap -m-4">
                    <div class="px-4 py-4 md:w-6/12 lg:w-4/12">
                        <a class="block relative h-64 rounded overflow-hidden">
                            <img alt="ecommerce" class="object-cover object-center w-full h-full block"
                                 :src="'/'+images.image">
                        </a>
                        <div class="mt-4">
                            <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">CATEGORY</h3>
                            <h2 class="text-gray-900 title-font text-lg font-medium">The Catalyzer</h2>
                            <form @submit.prevent="form.delete('/image/'+images.id)">
                                <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                    Delete
                                </button>
                            </form>
                        </div>
                        <div>
                            <form @submit.prevent="submit">
                                <input type="checkbox" value="images/adguard-watermark.png" v-model="form.checkbox">
                                <img src="/images/adguard-watermark.png"
                                     class="card-img-top" alt="Broken">
                                <input type="checkbox" value="images/draft-watermark.png" v-model="form.checkbox">
                                <img src="/images/draft-watermark.png"
                                     class="card-img-top" alt="Broken">
                                <input type="checkbox" value="images/icon-documents.png" v-model="form.checkbox">
                                <img src="/images/icon-documents.png"
                                     class="card-img-top" alt="Broken">
                            </form>
                        </div>
                        <div v-for="watermark in watermarkImage">
                            <img :src="'/'+watermark.image" alt="">
                        </div>
                    </div>
                </div>
            </div>


        <!--        </template>-->


    </BreezeAuthenticatedLayout>

</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import {Head} from "@inertiajs/inertia-vue3";
import { useForm } from '@inertiajs/inertia-vue3'
import {reactive} from "vue";
import {Inertia} from "@inertiajs/inertia";

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,

    },
    name: "ShowImageWithWatermark",
    props: ['images', 'watermarkImage'],
    setup () {
        const form = useForm({
            checkbox:[],
            password:null,
            email:null

        })

        return { form }
    }
}
</script>

<style scoped>

</style>
