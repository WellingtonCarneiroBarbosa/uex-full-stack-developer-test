<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import { ucfirst } from "@/Helpers/functions";

const props = defineProps({
    form: Object,
});
</script>

<template>
    <div class="col-span-12 md:col-span-6">
        <InputLabel
            for="cep"
            :value="$t('validation.attributes.address_cep')"
        />
        <TextInput
            :disabled="form.processing"
            id="cep"
            v-model="form.address_cep"
            type="text"
            class="mt-1 block w-full"
        />
        <InputError :message="form.errors.address_cep" class="mt-2" />
    </div>

    <div class="col-span-12 md:col-span-6">
        <InputLabel
            for="state"
            :value="ucfirst($t('validation.attributes.address_uf'))"
        />
        <TextInput
            :disabled="form.processing"
            id="state"
            v-model="form.address_uf"
            type="text"
            class="mt-1 block w-full"
        />
        <InputError :message="form.errors.address_uf" class="mt-2" />
    </div>

    <div class="col-span-12 md:col-span-6">
        <InputLabel
            for="city"
            :value="ucfirst($t('validation.attributes.address_city'))"
        />
        <TextInput
            :disabled="form.processing"
            id="city"
            v-model="form.address_city"
            type="text"
            class="mt-1 block w-full"
        />
        <InputError :message="form.errors.address_city" class="mt-2" />
    </div>

    <div class="col-span-12 md:col-span-6">
        <InputLabel
            for="street"
            :value="ucfirst($t('validation.attributes.address_street'))"
        />
        <TextInput
            :disabled="form.processing"
            id="street"
            v-model="form.address_street"
            type="text"
            class="mt-1 block w-full"
        />
        <InputError :message="form.errors.address_street" class="mt-2" />
    </div>

    <div class="col-span-12 md:col-span-6">
        <InputLabel
            for="number"
            :value="ucfirst($t('validation.attributes.address_number'))"
        />
        <TextInput
            :disabled="form.processing"
            id="number"
            v-model="form.address_number"
            type="text"
            class="mt-1 block w-full"
        />
        <InputError :message="form.errors.address_number" class="mt-2" />
    </div>

    <div class="col-span-12 md:col-span-6">
        <InputLabel
            for="complement"
            :value="ucfirst($t('validation.attributes.address_complement'))"
        />
        <TextInput
            :disabled="form.processing"
            id="complement"
            v-model="form.address_complement"
            type="text"
            class="mt-1 block w-full"
        />
        <InputError :message="form.errors.address_complement" class="mt-2" />
    </div>
</template>
