<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps<{
    initialPhoto: string | null;
    previewAlt?: string;
    previewClassName?: string;
    id?: string;
    class?: string;
    current_file: File | null;
    removed: number;
    recentlySuccessful: boolean;
}>();
const emit = defineEmits(['update:current_file', 'update:removed']);

const localRef = ref<HTMLInputElement | null>(null);
const imagePreviewSrc = ref<string>('');

watch(() => props.recentlySuccessful, (newVal) => {
    if (newVal) {
        resetFields();
    }
});

const resetFields = () => {
    emit('update:current_file', null);
    emit('update:removed', 0);
};

const handleInputChange = (e: Event) => {
    const target = e.target as HTMLInputElement;
    const selectedFile = target.files?.[0];
    if (selectedFile) {
        if (selectedFile.type.startsWith('image/')) {
            emit('update:current_file', selectedFile);
        } else {
            window.alert('Invalid file type. Please upload an image file.');
        }
    }
    target.value = '';
};

const handleRemoveClick = () => {
    if (props.current_file) {
        emit('update:current_file', null);
    } else {
        emit('update:removed', props.removed === 1 ? 0 : 1);
    }
};

watch([() => props.current_file, () => props.initialPhoto], () => {
    if (props.current_file) {
        imagePreviewSrc.value = URL.createObjectURL(props.current_file);
        if (props.removed === 1) {
            emit('update:removed', 0);
        }
    } else if (props.initialPhoto) {
        imagePreviewSrc.value = props.initialPhoto;
    } else {
        imagePreviewSrc.value = '';
    }
});

onMounted(() => {
    if (props.current_file) {
        imagePreviewSrc.value = URL.createObjectURL(props.current_file);
    } else if (props.initialPhoto) {
        imagePreviewSrc.value = props.initialPhoto;
    }
});
</script>

<template>
    <div :class="props.class">
        <input
            type="file"
            accept="image/*"
            class="hidden"
            :name="props.id"
            @change="handleInputChange"
            ref="localRef"
        />

        <div class="w-full flex space-x-1">
            <PrimaryButton
                class="flex-1"
                @click.prevent="localRef?.click()"
            >&#xf055; Add</PrimaryButton>

            <PrimaryButton
                class="flex-1"
                :disabled="props.initialPhoto === null && !props.current_file"
                @click.prevent="handleRemoveClick"
            >&#xf057; Remove</PrimaryButton>
        </div>

        <div class="mt-2 relative w-fit">
            <div v-if="props.removed" class="bg-gray-900/80 w-full h-full z-10 absolute border-1 border-gray-100">
                <div class="flex flex-col items-center justify-center h-full text-gray-100 text-6xl">
                    &#xf057;
                </div>
            </div>
            <div>
                <div v-if="props.initialPhoto === null && !props.current_file" class="w-full my-auto">
                    <div class="flex flex-col items-center justify-center">
                        <div class="text-2xl">No image</div>
                        <div class="text-sm">Click Add to upload an image</div>
                    </div>
                </div>
                <img v-else :class="props.previewClassName" :src="imagePreviewSrc" :alt="props.previewAlt" />
            </div>
        </div>
    </div>
</template>
