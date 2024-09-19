<script setup lang="ts">
import NavLink from '@/Components/NavLink.vue';
import MainLayout from './MainLayout.vue';
</script>

<template>
    <MainLayout>
        <template v-if="$slots.header" #header>
            <slot name="header"></slot>
        </template>
        <template #navigationLinks>
            <NavLink :href="route('login')" :active="route().current('login')">
                Login
            </NavLink>
            <NavLink :href="route('register')" :active="route().current('register')">
                Register
            </NavLink>
        </template>
        <slot></slot>
    </MainLayout>
</template>
