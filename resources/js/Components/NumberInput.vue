<script setup lang="ts">
import { onMounted, ref } from 'vue';
import TextInput from "@/Components/TextInput.vue";

const model = defineModel<string>({ required: true });

const textInput = ref<InstanceType<typeof TextInput> | null>(null);

onMounted(() => {
    if (textInput.value?.$el.hasAttribute('autofocus')) {
        textInput.value?.focus();
    }
});

defineExpose({ focus: () => textInput.value?.focus() });

const handleKeyDown = (e: KeyboardEvent) => {
    if (!/[0-9]/.test(e.key) && e.key !== 'Backspace' && e.key !== 'Enter' && e.key !== 'Tab') {
        e.preventDefault();
    }
};
</script>

<template>
    <TextInput
        v-model="model"
        ref="textInput"
        @keydown="handleKeyDown"
        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
    />
</template>
