<template>
    <Head title="Gallery"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <button form="selectImage" type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                    Share selected
                </button>
                <form class="flex" @submit.prevent="formSort.get('/gallery')">
                    <select name="orderBy" id="orderBy" v-model="formSort.orderBy">
                        <option value="ASC">Тhe oldest</option>
                        <option value="DESC">Тhe latest</option>
                    </select>
                    <button type="submit"
                            class=" bg-blue-500 hover:bg-blue-700 text-white font-bold ml-1 py-2 px-4 border border-blue-700 rounded">
                        Select sort
                    </button>
                </form>
            </div>

        </template>
        <div class="container mx-auto">
            <div v-if="$page.props.flash.message" id="messageAlert"
                 class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mt-3 rounded relative"
                 role="alert">
                <strong class="font-bold">{{ $page.props.flash.message }}</strong>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg @click="delete $page.props.flash.message" class="fill-current h-6 w-6 text-green-500" role="button"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path
                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
            </div>
            <div v-for="(errorMsg, errorIndex) in errors" id="errorAlert"
                 class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mt-3 rounded relative" role="alert">
                <strong class="font-bold">{{ errorMsg }}</strong>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg @click="delete this.errors[errorIndex]" class="fill-current h-6 w-6 text-red-500" role="button"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path
                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
            </div>
        </div>

        <form @submit.prevent="form.post('/sharingImage')" id="selectImage">
            <div class="flex container mx-auto">
                <div class="flex flex-wrap justify-around">
                    <div v-for="image in images.data" class="flex shadow p-2 my-10 w-auto">
                        <div class="flex justify-around flex-col xl:w-0.5/12">
                            <input type="checkbox" :value="image.id" v-model="form.checkbox">
                        </div>
                        <a class="flex xl:w-11.5/12 h-64 rounded overflow-hidden m-1" :href="'/image/'+ image.id">
                            <img alt="ecommerce" class="object-cover object-center w-full h-full block"
                                 :src="image.image">
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </BreezeAuthenticatedLayout>
    <Pagination class="flex justify-center m-3" :links="images.links"/>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import {Head, useForm} from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination';
import SimpleToggle from "@/Components/SimpleToggle";

export default {

    components: {
        BreezeAuthenticatedLayout,
        Head,
        Pagination,
        SimpleToggle

    },
    props: {
        images: Object,
        errors: Object
    },
    name: "Gallery",
    setup() {
        let params = new URLSearchParams(document.location.search.substring(1));
        let orderBy = params.get("orderBy");

        if (orderBy == null) {
            orderBy = 'ASC'
        }

        const form = useForm({
            checkbox: [],
        })

        const formSort = useForm({
            orderBy: orderBy
        })

        return {form, formSort}
    },

}
</script>
