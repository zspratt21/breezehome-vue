<script setup lang="ts">
import { ref, onMounted, watchEffect } from 'vue';

const isDarkMode = ref(false);

function toggleClass() {
    if (
        localStorage.getItem('color-theme') === 'dark' ||
        (!('color-theme' in localStorage) &&
            window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
}

const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;
    localStorage.setItem('color-theme', isDarkMode.value ? 'dark' : 'light');
    toggleClass();
};

onMounted(() => {
    const storedTheme = localStorage.getItem('color-theme');
    const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
    isDarkMode.value = storedTheme === 'dark' || (!storedTheme && prefersDarkMode);
    toggleClass();
});

watchEffect(() => {
    toggleClass();
});
</script>

<template>
    <button
        @click="toggleDarkMode"
        type="button"
    >
        <span class="fas">
            <template v-if="isDarkMode">&#xf186;</template>
            <template v-else>&#xf185;</template>
        </span>
    </button>
</template>
