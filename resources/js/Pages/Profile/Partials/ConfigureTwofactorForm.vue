<script setup lang="ts">
import {computed, ref, watch} from 'vue';

import {router, useForm, usePage} from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import NumberInput from '@/Components/NumberInput.vue';
import DangerButton from '@/Components/DangerButton.vue';
import RecoveryCodes from '@/Pages/Auth/RecoveryCodes.vue';

const props = defineProps<{
    qrCode?: string ;
    recoveryCodes?: string[];
}>();

const form = useForm({
    code: '',
});

const mfaEnabled = computed(() => usePage().props.auth.user.two_factor_enabled);
const showForm = ref(false);
const storedQrCode = ref('');
const codeInput = ref<HTMLInputElement | null>(null);
const submitContainer = ref<HTMLDivElement | null>(null);

const submit = () => {
    const url = mfaEnabled.value ? route('2fa.disable') : route('2fa.enable.check');
    form.post(url, {
        preserveScroll: true,
        onSuccess: () => {
            form.code = '';
            showForm.value = false;
            if (storedQrCode.value) {
                storedQrCode.value = '';
            }
        },
        onError: () => {
            codeInput.value?.focus();
        },
    });
};

const enable = () => {
    router.post(route('2fa.enable'), {}, {
        onSuccess: () => {
            window.scrollTo({
                top: submitContainer.value?.offsetTop,
                behavior: 'instant',
            });
        },
    })
};

watch(() => codeInput.value, (newVal) => {
    if (newVal) {
        newVal.focus();
    }
});

watch(() => props.qrCode, (newVal) => {
    if (newVal) {
        showForm.value = true;
        storedQrCode.value = newVal;
    }
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Two Factor Authentication</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                <span v-if="mfaEnabled">You have enabled two factor authentication &#xf058;</span>
                <span v-else>Configure two factor authentication to increase the security of your account.</span>
            </p>
        </header>
        <form @submit.prevent="submit">
            <div>
                <div v-if="!showForm" class="mt-4">
                    <RecoveryCodes v-if="recoveryCodes" :recoveryCodes="recoveryCodes"/>
                    <div class="flex gap-4 items-center">
                        <PrimaryButton v-if="!mfaEnabled" @click.prevent="enable">&#xf205; Enable</PrimaryButton>
                        <PrimaryButton v-else @click.prevent="showForm = true;">&#xf204; Disable</PrimaryButton>
                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                        </Transition>
                    </div>
                </div>
                <div v-else>
                    <div v-if="!mfaEnabled" class="mt-4">
                        <img v-if="storedQrCode" :src="storedQrCode" alt="2FA QR Code" />
                        <div v-else>loading qr code...</div>
                    </div>
                    <div class="mt-4">
                        <InputLabel
                            for="code"
                            :value="!mfaEnabled ? 'Scan the above Qr Code with google authenticator then...' : 'To confirm you want to disable 2FA on your account you need to...'"
                        />
                        <NumberInput
                            id="code"
                            class="mt-1 block w-full"
                            v-model="form.code"
                            placeholder="&#xe2c5; Enter the code from your authenticator app"
                            required
                            autocomplete="off"
                            maxlength="6"
                            minlength="6"
                            ref="codeInput"
                        />
                        <InputError class="mt-2" :message="form.errors.code" />
                    </div>
                    <div ref="submitContainer" class="mt-4">
                        <PrimaryButton v-if="!mfaEnabled" type="submit">&#xe2c5; Activate 2FA</PrimaryButton>
                        <DangerButton v-else type="submit">&#xf071; Confirm</DangerButton>
                    </div>
                </div>
            </div>
        </form>
    </section>
</template>
