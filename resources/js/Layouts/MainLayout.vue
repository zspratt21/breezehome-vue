<script lang="ts" setup>
import { ref } from 'vue';
import {Link} from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import FooterLink from '@/Components/FooterLink.vue';
import DarkModeToggle from "@/Components/DarkModeToggle.vue";

const mobileMenuOpen = ref(false);
const toggleMobileMenu = () => {
    mobileMenuOpen.value = !mobileMenuOpen.value;
};
</script>

<template>
    <div class="min-h-screen flex flex-col bg-gray-100 dark:bg-gray-900">
        <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="shrink-0 space-x-6 flex items-center">
                            <Link href="/">
                                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                            </Link>
                            <DarkModeToggle class="text-white dark:text-gray-800 bg-gray-400 dark:bg-gray-500 p-1 w-8 h-8 rounded-full" />
                        </div>
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <slot name="navigationLinks"></slot>
                        </div>
                    </div>
                    <div class="flex">
                        <slot v-if="$slots.dropdownContent" name="dropdownContent"></slot>

                        <div class="sm:hidden my-auto">
                            <button @click="toggleMobileMenu" class="text-gray-800 dark:text-gray-200 text-2xl">&#xf0c9;</button>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main class="w-full mx-auto flex flex-col flex-1 relative">
            <div v-if="mobileMenuOpen" class="bg-white dark:bg-gray-800 flex flex-col px-2 z-10 absolute w-full h-full">
                <slot name="navigationLinks"></slot>
            </div>
            <header v-if="$slots.header" class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"><slot name="header"></slot></h2>
                </div>
            </header>
            <slot></slot>
        </main>

        <footer class="bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex flex-col">
                <div class="flex justify-between my-auto">
                    <FooterLink href="https://github.com/zspratt21">
                        &#xf1f9; {{ new Date().getFullYear() }} Zspratt21
                    </FooterLink>
                    <FooterLink href="https://github.com/zspratt21/breezehome">Breezehome &#xf015; Starter Template</FooterLink>
                </div>
            </div>
        </footer>
    </div>
</template>
