<script setup lang="ts">
import {Head} from "@inertiajs/vue3";

const props = defineProps<{
    header: string;
    title?: string;
    include_head?: boolean;
}>();
</script>

<template>
    <template v-if="include_head || title">
        <Head :title="title ?? header" />
    </template>
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{header}}</h2>
</template>
