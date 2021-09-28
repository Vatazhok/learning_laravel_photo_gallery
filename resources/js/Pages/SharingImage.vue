<template>
    <Head title="Gallery"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <button form="selectImage" type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 m-2 border border-blue-700 rounded">
                Delete selected
            </button>
        </template>

        <form @submit.prevent="submit" id="selectImage" class="bg-gray-200">
            <div class="container px-5 py-4 mx-auto">
                <div class="flex flex-wrap -m-4">
                    <div v-for="image in images" class=" px-4 py-4 md:w-6/12 lg:w-4/12">
                        <input type="checkbox" :value="image.id" v-model="form.checkbox">
                        <a class="block relative h-64 rounded overflow-hidden">
                            <img alt="ecommerce" class="object-cover object-center w-full h-full block"
                                 :src="image.image">
                        </a>
<!--                        <div>{{$page.props.images.id}}</div>-->
                        <div class="card-body">
                            <a :href="route('showImageWithWatermark',image.id)" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">add watermark</a>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">CATEGORY</h3>
                            <h2 class="text-gray-900 title-font text-lg font-medium">The Catalyzer</h2>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import {Head} from "@inertiajs/inertia-vue3";
import {reactive} from "vue";
import {Inertia} from "@inertiajs/inertia";

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,

    },
    name: "SharingImage",
    props:['images', 'errors'],
    setup() {
        const form = reactive({
            checkbox: [],
        })
        /*todo: not work norm*/
        function submit() {
            Inertia.delete('/image/145', form)
        }

        return {form, submit}
    },
}

</script>
