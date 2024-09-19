<script setup lang="ts">
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import WelcomeCard from "@/Components/WelcomeCard.vue";

defineProps<{
    laravelVersion: string;
    phpVersion: string;
}>();

</script>

<template>
    <Head title="Welcome" />
    <AuthenticatedLayout v-if="$page.props.auth.user">
        <WelcomeCard :laravelVersion="laravelVersion" :phpVersion="phpVersion" />
    </AuthenticatedLayout>
    <GuestLayout v-else>
        <WelcomeCard :laravelVersion="laravelVersion" :phpVersion="phpVersion" />
    </GuestLayout>
</template>
