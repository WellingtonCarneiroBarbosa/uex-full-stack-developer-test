<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import ActionMessage from "@/Components/ActionMessage.vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { ucwords } from "@/Helpers/functions";
import { trans } from "laravel-vue-i18n";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const pageTranslations = (name = "", attributes = {}) => {
    return trans(`pages.profile.update-password.${name}`, attributes);
};

const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

const updatePassword = () => {
    form.put(route("user-password.update"), {
        errorBag: "updatePassword",
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset("password", "password_confirmation");
                passwordInput.value.focus();
            }

            if (form.errors.current_password) {
                form.reset("current_password");
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <FormSection @submitted="updatePassword">
        <template #title> {{ pageTranslations("title") }} </template>

        <template #description>
            {{ pageTranslations("description") }}
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel
                    for="current_password"
                    :value="
                        ucwords($t('validation.attributes.current-password'))
                    "
                />
                <TextInput
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="current-password"
                />
                <InputError
                    :message="form.errors.current_password"
                    class="mt-2"
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel
                    for="password"
                    :value="ucwords($t('validation.attributes.new-password'))"
                />
                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />
                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel
                    for="password_confirmation"
                    :value="
                        ucwords($t('validation.attributes.confirm-password'))
                    "
                />
                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />
                <InputError
                    :message="form.errors.password_confirmation"
                    class="mt-2"
                />
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                {{ $t('words.saved') }}
            </ActionMessage>

            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                {{ form.processing ? $t('words.saving') : $t('words.save') }}
            </PrimaryButton>
        </template>
    </FormSection>
</template>
