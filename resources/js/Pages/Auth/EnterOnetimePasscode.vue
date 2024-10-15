<script setup lang="ts">
import { onMounted, watch } from 'vue';
import {useForm} from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import FullPageForm from '@/Components/FullPageForm.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import NumberInput from '@/Components/NumberInput.vue';
import InputError from '@/Components/InputError.vue';
import HeaderHeading from "@/Components/HeaderHeading.vue";

const form = useForm({
    code: '',
    isRecovery: null as true | null,
});

const submit = () => {
    form.post(route('2fa.check'), {
        onError: (errors) => {
            console.log(errors);
        }
    });
};

onMounted(() => {
    form.code = '';
});

watch(() => form.isRecovery, () => {
    form.code = '';
});
</script>

<template>
    <GuestLayout>
        <template #header>
            <HeaderHeading header="2FA" title="Enter OTP"/>
        </template>

        <FullPageForm>
            <form @submit.prevent="submit">
                <template v-if="form.isRecovery">
                    <TextInput
                        placeholder="&#xf084; Enter a recovery code"
                        id="code"
                        name="code"
                        maxLength="16"
                        minLength="16"
                        class="mt-1 block w-full"
                        v-model="form.code"
                        required
                        autoComplete="off"
                    />
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        <a
                            class="underline cursor-pointer"
                            @click="form.isRecovery = null"
                        >
                            Go back.
                        </a>
                    </p>
                </template>
                <template v-else>
                    <NumberInput
                        placeholder="&#xe2c5; Enter the code from your authenticator app"
                        id="code"
                        maxLength="6"
                        minLength="6"
                        name="code"
                        class="mt-1 block w-full"
                        v-model="form.code"
                        required
                        autoComplete="off"
                        autofocus
                    />
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Can't access authenticator app?&nbsp;
                        <a
                            class="underline cursor-pointer"
                            @click="form.isRecovery = true"
                        >
                            Enter a recovery code instead.
                        </a>
                    </p>
                </template>
                <InputError :message="form.errors.code" class="mt-2" />
                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton type="submit" class="ms-4" :disabled="form.processing">
                        &#xf2f6; Continue
                    </PrimaryButton>
                </div>
            </form>
        </FullPageForm>
    </GuestLayout>
</template>
