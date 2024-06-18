<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import { vMaska } from "maska";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { ucfirst } from "@/Helpers/functions";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { reactive } from "vue";

const props = defineProps({
    form: Object,
    filterMode: Boolean,
    clearFilters: Object,
});

const cpfMask = reactive({
    mask: "###.###.###-##",
    eager: true,
});

const emit = defineEmits("filtered");

const filter = () => {
    emit("filtered");

    props.form.get(route("dash.contacts.index"), {
        errorBag: "filter",
        preserveScroll: true,
        preserveState: true,
    });
};
</script>

<template>
    <div class="grid grid-cols-12 gap-4 mb-4 border-b lg:border-none pb-3">
        <div class="col-span-12 lg:col-span-6">
            <InputLabel for="filter-name">{{
                ucfirst($t("validation.attributes.name"))
            }}</InputLabel>
            <TextInput
                id="filter-name"
                class="w-full"
                v-model="form.name"
                :disabled="form.processing"
            />
            <InputError :message="form.errors.name" />
        </div>

        <div class="col-span-12 lg:col-span-6">
            <InputLabel for="filter-cpf">{{
                $t("validation.attributes.cpf")
            }}</InputLabel>
            <TextInput
                id="filter-cpf"
                class="w-full"
                v-model="form.cpf"
                :disabled="form.processing"
                v-maska:[cpfMask]
            />
            <InputError :message="form.errors.cpf" />
        </div>

        <div class="col-span-6"></div>

        <div class="col-span-6 flex justify-end items-center gap-x-2">
            <SecondaryButton v-if="filterMode" @click="clearFilters"
                >Limpar filtros</SecondaryButton
            >
            <PrimaryButton
                @click="filter"
                :disabled="form.processing"
                class="float-end"
                >Filtrar</PrimaryButton
            >
        </div>
    </div>
</template>
