<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SearchInput from "@/Components/SearchInput.vue";
import {User} from "@/types";
import {ref} from "vue";
import RecoveryCodes from "@/Pages/Auth/RecoveryCodes.vue";

const userSearchResults = ref<User[]>([]);

defineProps<{
    recoveryCodes?: string[];
}>();

const refreshResults = (results: User[]) => {
    userSearchResults.value = results;
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p>You're logged in!</p>
                        <div v-if="recoveryCodes">
                            <p>You just used your last recovery code, so we've generated some more for you.</p>
                            <RecoveryCodes :recoveryCodes="recoveryCodes" />
                        </div>
                    </div>
                </div>

                <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <SearchInput
                            placeholder="Search for fellow users..."
                            :searchUrl="route('search.users')"
                            :refreshResults="refreshResults"
                        />
                        <div class="mt-6" v-if="userSearchResults.length > 0">
                            <div  v-for="(user, index) in userSearchResults" :key="index">
                                {{ user.name }} - {{ user.email }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
