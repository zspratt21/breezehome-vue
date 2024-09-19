<script setup lang="ts">
import {Link} from "@inertiajs/vue3";

const props = defineProps<{
    href: string;
}>();
</script>

<template>
    <Link :href="props.href"
          class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
    ><slot></slot></Link>
</template>
