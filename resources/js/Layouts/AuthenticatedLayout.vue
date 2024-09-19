<script setup lang="ts">
import Dropdown from '@/Components/Dropdown.vue';
import NavLink from '@/Components/NavLink.vue';
import MainLayout from './MainLayout.vue';
import DropdownLink from "@/Components/DropdownLink.vue";

</script>

<template>
    <MainLayout>
        <template v-if="$slots.header" #header>
            <slot name="header"></slot>
        </template>
        <template #navigationLinks>
            <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                Dashboard
            </NavLink>
        </template>
        <template #dropdownContent>
            <div class="ms-3 relative my-auto">
                <Dropdown>
                    <template #trigger>
                        <span class="inline-flex rounded-md">
                            <button
                                type="button"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                            >
                                <img
                                    v-if="$page.props.auth.user.avatar"
                                    class="h-10 w-10 rounded-full mr-2 border-2 border-gray-700 dark:border-gray-300"
                                    :src="$page.props.auth.user.avatar"
                                    alt="User Avatar photo"
                                />
                                {{ $page.props.auth.user.name }}
                                &nbsp;
                                &#xf078;
                            </button>
                        </span>
                    </template>
                    <template #content>
                        <DropdownLink :href="route('profile.edit')">&#xf007; &nbsp; Profile</DropdownLink>
                        <DropdownLink v-if="$page.props.auth.user.id == 2" :href="route('php-info')" target="_blank">&#xf233; &nbsp; PHP Info</DropdownLink>
                        <DropdownLink :href="route('logout')" method="post" as="button">&#xf2f5; &nbsp; Log Out</DropdownLink>
                    </template>
                </Dropdown>
            </div>
        </template>
        <slot></slot>
    </MainLayout>
</template>
