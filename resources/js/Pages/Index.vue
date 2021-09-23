<template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <Link :href="route('index')">
                        <BreezeApplicationLogo class="block h-9 w-auto"/>
                    </Link>
                </div>
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <BreezeNavLink :href="route('index')" :active="route().current('index')">
                        Dashboard
                    </BreezeNavLink>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">

                        <button form="selectImage" type="submit">Submit</button>

                </div>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <BreezeDropdown align="right" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    {{ $page.props.auth.user.name }}

                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <BreezeDropdownLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </BreezeDropdownLink>
                        </template>
                    </BreezeDropdown>
                </div>
            </div>
            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="showingNavigationDropdown = ! showingNavigationDropdown"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path
                            :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"/>
                        <path
                            :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <div>{{errors.checkbox}}</div>
    <form @submit.prevent="submit" id="selectImage" class="bg-gray-200">
        <div class="container px-5 py-4 mx-auto">
            <div class="flex flex-wrap -m-4">
                <div v-for="image in images" class=" px-4 py-4 md:w-6/12 lg:w-4/12">
                    <input type="checkbox" :value="image.id" v-model="form.checkbox">
                    <a class="block relative h-64 rounded overflow-hidden">
                        <img alt="ecommerce" class="object-cover object-center w-full h-full block" :src="image.image">
                    </a>
                    <div class="mt-4">
                        <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">CATEGORY</h3>
                        <h2 class="text-gray-900 title-font text-lg font-medium">The Catalyzer</h2>
                    </div>
                </div>
            </div>
        </div>
<!--                <button type="submit">Submit</button>-->
    </form>

</template>


<script>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue'
import BreezeDropdown from "@/Components/Dropdown";
import BreezeDropdownLink from "@/Components/DropdownLink";
import BreezeNavLink from "@/Components/NavLink";
import BreezeResponsiveNavLink from "@/Components/ResponsiveNavLink";
import {Link} from "@inertiajs/inertia-vue3";
import {reactive} from 'vue'
import {Inertia} from '@inertiajs/inertia'


export default {
    components: {
        BreezeApplicationLogo,
        BreezeDropdown,
        BreezeDropdownLink,
        BreezeNavLink,
        BreezeResponsiveNavLink,
        Link,
    },
    props: ['images','errors'],
    name: "Index",
    setup() {
        const form = reactive({
            checkbox: [],
        })

        function submit() {
            Inertia.post('/sharingImage', form)
        }

        return {form, submit}
    }

}
</script>

<style scoped>

</style>
