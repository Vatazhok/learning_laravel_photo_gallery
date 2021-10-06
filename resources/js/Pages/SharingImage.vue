<template>
    <Head title="Gallery"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <button form="selectImage" type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                Delete selected
            </button>
        </template>

        <form @submit.prevent="form.delete('/destroyAll')" id="selectImage">
            <div class="container mx-auto">
                <div class="flex flex-wrap  ">
                    <div v-for="image in images" class="flex flex-col p-2 shadow md:w-6/12 lg:w-4/12 ">
                        <div class="flex">
                            <div class="flex justify-around flex-col md:w-1/12 xl:w-0.5/12 m-1">
                                <input type="checkbox" :value="image.id" v-model="form.checkbox">
                            </div>
                            <a class="flex xl:w-11/12 h-64 rounded overflow-hidden">
                                <img alt="ecommerce" class="object-cover object-center w-full h-full block"
                                     :src="image.image">
                            </a>
                        </div>
                        <div class="flex justify-center">
                            <a :href="route('showImageWithWatermark',image.id)"
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 m-2 border border-blue-700 rounded"
                               role="button" aria-pressed="true">add watermark</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import {Head, useForm} from "@inertiajs/inertia-vue3";
import {reactive} from "vue";
import {Inertia} from "@inertiajs/inertia";

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,

    },
    name: "SharingImage",
    props: ['images', 'errors'],
    setup() {
        const form = useForm({
            checkbox: [],
        })
        return {form}
    },
}

</script>
