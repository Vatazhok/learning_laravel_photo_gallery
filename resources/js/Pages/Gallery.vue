<template>
    <Head title="Gallery"/>

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
        <div  v-if="$page.props.flash.message" id="alert"
             class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">{{  $page.props.flash.message }}</strong>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg @click="delete $page.props.flash.message" class="fill-current h-6 w-6 text-red-500" role="button"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path
                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
        </div>

        <form @submit.prevent="submit" id="selectImage" class="bg-gray-200">
            <div class="container px-5 py-4 mx-auto">
                <div class="flex flex-wrap colo -m-4">
                    <div v-for="image in images.data" class=" px-4 py-4 md:w-6/12 lg:w-4/12">
                        <input type="checkbox" :value="image.id" v-model="form.checkbox">
                        <a class=" block relative h-64 rounded overflow-hidden">
                            <img alt="ecommerce" class="object-cover object-center w-full h-full block"
                                 :src="image.image">
                        </a>

                    </div>
                </div>
            </div>
        </form>

    </BreezeAuthenticatedLayout>
    <Pagination class="flex justify-center mt-3" :links="images.links"/>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import {Head} from '@inertiajs/inertia-vue3';
import {reactive} from "vue";
import {Inertia} from "@inertiajs/inertia";
import Pagination from '@/Components/Pagination'


export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Pagination,
    },
    props: ['images', 'errors'],
    name: "Index",
    setup() {
        const form = reactive({
            checkbox: [],
        })

        function submit() {
            Inertia.post('/sharingImage', form)
        }

        return {form, submit}
    },

}

</script>
