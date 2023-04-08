<script setup>
import AuthenticatedLayout from '@/Layouts/Admin/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />


    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashbrd</h2>
        </template>

        <div class="mx-auto max-w-7xl py-4 sm:px-6 sm:py-2 lg:px-8">
            <div class="relative isolate overflow-hidden  px-6 pt-16 sm:px-16 md:pt-24 lg:flex lg:gap-x-20 lg:px-24 lg:pt-0">

                <div class="mx-auto max-w-md text-center lg:mx-0 lg:flex-auto lg:py-32 lg:text-left">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Boost your productivity.<br />Start using our app today.</h2>
                    <p class="mt-6 text-lg leading-8 text-gray-600">Ac euismod vel sit maecenas id pellentesque eu sed consectetur. Malesuada adipiscing sagittis vel nulla.</p>
                    <div class="mt-10 flex items-center justify-center gap-x-6 lg:justify-start">
                        <a href="#" class="rounded-md bg-gray-900 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Get started</a>
                    </div>
                </div>
                <div class="relative mt-2 h-80 lg:mt-8">
                    <img class="absolute left-0 top-0 w-[27rem] max-w-none rounded-md bg-white/5 ring-1 ring-white/10" src="/images/podcasts.svg" alt="App screenshot" width="50" height="50" />
                </div>
            </div>
        </div>



    </AuthenticatedLayout>

</template>


