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
        <InputLabel for="cep" :value="$t('validation.attributes.cep')" />
        <TextInput
            :disabled="form.processing"
            id="cep"
            v-model="form.cep"
            type="text"
            class="mt-1 block w-full"
        />
        <InputError :message="form.errors.cep" class="mt-2" />
    </div>

    <div class="col-span-12 md:col-span-6">
        <InputLabel
            for="state"
            :value="ucfirst($t('validation.attributes.state'))"
        />
        <TextInput
            :disabled="form.processing"
            id="state"
            v-model="form.state"
            type="text"
            class="mt-1 block w-full"
        />
        <InputError :message="form.errors.state" class="mt-2" />
    </div>

    <div class="col-span-12 md:col-span-6">
        <InputLabel
            for="city"
            :value="ucfirst($t('validation.attributes.city'))"
        />
        <TextInput
            :disabled="form.processing"
            id="city"
            v-model="form.city"
            type="text"
            class="mt-1 block w-full"
        />
        <InputError :message="form.errors.city" class="mt-2" />
    </div>

    <div class="col-span-12 md:col-span-6">
        <InputLabel
            for="street"
            :value="ucfirst($t('validation.attributes.street'))"
        />
        <TextInput
            :disabled="form.processing"
            id="street"
            v-model="form.street"
            type="text"
            class="mt-1 block w-full"
        />
        <InputError :message="form.errors.street" class="mt-2" />
    </div>

    <div class="col-span-12 md:col-span-6">
        <InputLabel
            for="number"
            :value="ucfirst($t('validation.attributes.number'))"
        />
        <TextInput
            :disabled="form.processing"
            id="number"
            v-model="form.number"
            type="text"
            class="mt-1 block w-full"
        />
        <InputError :message="form.errors.number" class="mt-2" />
    </div>

    <div class="col-span-12 md:col-span-6">
        <InputLabel
            for="complement"
            :value="ucfirst($t('validation.attributes.complement'))"
        />
        <TextInput
            :disabled="form.processing"
            id="complement"
            v-model="form.complement"
            type="text"
            class="mt-1 block w-full"
        />
        <InputError :message="form.errors.complement" class="mt-2" />
    </div>
</template>
