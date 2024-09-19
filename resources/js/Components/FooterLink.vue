<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    href: string;
}>();

</script>

<template>
    <Link
        :href="href"
        class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200"
    >
        <slot></slot>
    </Link>
</template>
