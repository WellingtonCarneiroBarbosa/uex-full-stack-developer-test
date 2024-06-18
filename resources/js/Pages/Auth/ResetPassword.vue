<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { ucwords } from "@/Helpers/functions";
import { trans } from "laravel-vue-i18n";

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("password.update"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};

const pageTranslations = (name = "", attributes = {}) => {
    return trans(`pages.auth.reset-password.${name}`, attributes);
};
</script>

<template>
    <Head :title="pageTranslations('title')" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <form @submit.prevent="submit">
            <div class="mt-4">
                <InputLabel
                    for="password"
                    :value="ucwords($t('validation.attributes.password'))"
                />
                <TextInput
                    id="password"
                    v-model="form.password"
                    :disabled="form.processing"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    :value="
                        ucwords($t('validation.attributes.confirm-password'))
                    "
                />
                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    :disabled="form.processing"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ pageTranslations("title") }}
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
