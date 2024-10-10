<script setup lang="ts">
import { ref } from 'vue';

const props = defineProps<{
    recoveryCodes: string[];
}>();
const codes = ref<string[] | null>(props.recoveryCodes);
const emit = defineEmits(['codesCopied']);

const copyCodes = (recoveryCodes: string[]) => {
    navigator.clipboard.writeText(recoveryCodes.join('\n')).then(() => {
        alert('The recovery codes have been copied to your clipboard.');
        codes.value = null;
        emit('codesCopied');
    });
};
</script>

<template>
    <div v-if="codes" class="mt-4">
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            These single use codes may be used in the event you lose access to your device.
        </p>
        <div class="flex bg-gray-100 dark:bg-gray-700 p-2 sm:rounded-lg text-gray-600 dark:text-gray-400">
            <ul class="flex-1">
                <li v-for="code in codes" :key="code">{{ code }}</li>
            </ul>
            <a class="fas h-fit align-top cursor-pointer" @click="copyCodes(props.recoveryCodes)">
                &#xf0c5;
            </a>
        </div>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Once all codes have been used, we will generate more for you upon your next login.
        </p>
    </div>
</template>
