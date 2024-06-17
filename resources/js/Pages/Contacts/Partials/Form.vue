<script setup>
import FormSection from "@/Components/FormSection.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import { trans } from "laravel-vue-i18n";
import { ucwords, ucfirst } from "@/Helpers/functions";
import SectionBorder from "@/Components/SectionBorder.vue";
import Address from "@/Components/Form/Address.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    form: Object,
    mode: {
        type: String,
        default: "create",
    },
});

const emit = defineEmits(["cancel", "submitted"]);

const commonTranslations = (name = "", attributes = {}) => {
    return trans(`pages.contacts.form.common.${name}`, attributes);
};

const pageTranslations = (name = "", attributes = {}) => {
    return trans(`pages.contacts.form.${props.mode}.${name}`, attributes);
};

const submit = () => {};
</script>

<template>
    <FormSection>
        <template #title>
            {{ pageTranslations("title", { name: form.name }) }}
        </template>

        <template #description>
            {{ pageTranslations("description") }}
        </template>

        <template #form>
            <div class="col-span-12">
                <h1 class="font-bold text-lg">
                    {{ commonTranslations("contact-information") }}
                </h1>
            </div>

            <div class="col-span-12 md:col-span-6">
                <InputLabel
                    for="name"
                    :value="ucwords($t('validation.attributes.name'))"
                />
                <TextInput
                    :disabled="form.processing"
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    autofocus
                />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <div class="col-span-12 md:col-span-6">
                <InputLabel
                    for="cpf"
                    :value="$t('validation.attributes.cpf')"
                />
                <TextInput
                    :disabled="form.processing"
                    id="cpf"
                    v-model="form.cpf"
                    type="text"
                    class="mt-1 block w-full"
                />
                <InputError :message="form.errors.cpf" class="mt-2" />
            </div>

            <div class="col-span-12 md:col-span-6">
                <InputLabel
                    for="email"
                    :value="ucfirst($t('validation.attributes.email'))"
                />
                <TextInput
                    :disabled="form.processing"
                    id="email"
                    v-model="form.email"
                    type="text"
                    class="mt-1 block w-full"
                />
                <InputError :message="form.errors.email" class="mt-2" />
            </div>

            <div class="col-span-12 md:col-span-6">
                <InputLabel
                    for="phone"
                    :value="ucwords($t('validation.attributes.phone'))"
                />
                <TextInput
                    :disabled="form.processing"
                    id="phone"
                    v-model="form.phone"
                    type="text"
                    class="mt-1 block w-full"
                />
                <InputError :message="form.errors.phone" class="mt-2" />
            </div>

            <div class="col-span-12">
                <SectionBorder class="-mt-10 -mb-5" />

                <h1 class="font-bold text-lg">
                    {{ commonTranslations("address") }}
                </h1>
            </div>

            <Address :form="form" />
        </template>

        <template #actions>
            <SecondaryButton @click="emit('cancel')" class="mr-2">{{
                $t("words.cancel")
            }}</SecondaryButton>
            <PrimaryButton @click="submit">{{
                $t("words.save")
            }}</PrimaryButton>
        </template>
    </FormSection>
</template>
