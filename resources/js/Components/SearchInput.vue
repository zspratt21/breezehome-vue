<script setup lang="ts">
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps<{
    placeholder: string;
    searchUrl: string;
    refreshResults: (r: []) => void;
}>();
const query = ref('');

const submit = () => {
    axios.post(props.searchUrl, { query: query.value }).then((response) => {
        props.refreshResults(response.data);
    }).catch((error) => {
        console.error('Search error:', error);
    });
};
</script>

<template>
    <div>
        <form @submit.prevent="submit" class="relative">
            <input
                class="w-full rounded-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"
                type="text"
                v-model="query"
                :placeholder="placeholder"
                maxlength="255"
            />
            <button class="px-4 absolute right-0 h-full" type="submit">&#xf002;</button>
        </form>
    </div>
</template>
