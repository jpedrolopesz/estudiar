<template>
    <li
        :class="[!openSideNav ? 'p-2' : 'flex items-center p-2']"
        class="text-white text-sm font-semibold text-center hover:bg-gray-700 rounded-lg cursor-pointer"
    >
        <div :class="[!openSideNav ? 'w-full flex justify-center' : '']">
            <component :is="icon" />
        </div>
        <div :class="[!openSideNav ? '' : 'mt-1 ml-4']">
            <span v-if="!openSideNav">{{ iconString.substring(0,4) }}</span>
            <span v-else>{{ iconString }}</span>
        </div>
    </li>
</template>

<script setup>
import { defineProps, toRefs } from 'vue';
import { Link } from '@inertiajs/vue3';
import Dashboard from 'vue-material-design-icons/Home.vue';


const props = defineProps({
    openSideNav: Boolean,
    iconString: String,
})

const { openSideNav, iconString } = toRefs(props)

let icon = null

if (iconString.value === 'Dashboard') icon = Dashboard

</script>

<style lang="scss" scoped>

</style>
