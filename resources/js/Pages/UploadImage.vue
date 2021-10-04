<template>
    <Head title="Gallery"/>

    <BreezeAuthenticatedLayout>
        <div class="container mx-auto">
            <div  v-if="$page.props.flash.message" id="alert"
                  class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mt-3 rounded relative" role="alert">
                <strong class="font-bold">{{  $page.props.flash.message }}</strong>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg @click="delete $page.props.flash.message" class="fill-current h-6 w-6 text-red-500" role="button"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path
                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
            </div>
            <div v-for="(errorMsg, errorIndex) in errors" id="alert"
                 class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mt-3 rounded relative" role="alert">
                <strong class="font-bold">{{ errorMsg }}</strong>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg @click="delete this.errors[errorIndex]" class="fill-current h-6 w-6 text-green-500" role="button"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path
                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
            </div>
        </div>
        <template class="flex p-10">
            <form class="flex mx-auto"  @submit.prevent="submit">
                <div class="flex flex-col h-15">
                    <input class="flex my-auto" type="file" @input="form.image = $event.target.files" multiple/>
                    <progress class="flex w-15" v-if="form.progress" :value="form.progress.percentage" max="100">
                        {{ form.progress.percentage }}%
                    </progress>
                </div>

                <button
                    class="flex  border border-green-500 bg-green-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline"
                    type="submit">Submit
                </button>

            </form>
        </template>

        <!--        </div>-->

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
    name: "UploadImage",
    props: ['images', 'errors'],
    setup() {
        const form = useForm({
            image: null
        })

        function submit() {
            form.post('/uploadImage')
        }

        return {form, submit}
    },
}

</script>
