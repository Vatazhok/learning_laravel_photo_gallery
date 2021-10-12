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
                <div class="flex flex-wrap justify-around">
                    <div v-for="image in images" class="flex flex-col shadow p-2 my-10 w-auto">
                        <div class="flex">
                            <div class="flex justify-around jus flex-col xl:w-0.5/12">
                                <input type="checkbox" :value="image.id" v-model="form.checkbox">
                            </div>
                            <a class="flex xl:w-11.5/12 h-64 rounded overflow-hidden m-1">
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
