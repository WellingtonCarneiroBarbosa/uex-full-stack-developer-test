<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import SelectInput from "@/Components/SelectInput.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import { ucfirst } from "@/Helpers/functions";
import { nextTick, watch, reactive, computed } from "vue";
import { vMaska } from "maska";

const props = defineProps({
    form: Object,
    mode: String,
});

const cepMask = reactive({
    mask: "##.###-###",
    eager: true,
});

const setAddressByCep = (cep) => {
    cep = cep?.replace(/\D/g, "");

    if (cep.length === 8) {
        props.form.processing = true;

        window.axios
            .get(route("dash.get-cep-address", { cep: cep }))
            .then((response) => {
                let form = props.form;
                let data = response.data;

                form.address_uf = data.state.toLowerCase();
                form.address_city = data.city;
                form.address_neighborhood = data.neighborhood;
                form.address_street = data.street;

                form.processing = false;

                nextTick(() => {
                    document.getElementById("number")?.focus();
                });
            });
    }
};

const handleCepChange = (e) => {
    if (props.mode === "edit") {
        setAddressByCep(e.target.value);
    }
};

const states = computed(() => {
    return [
        {
            label: "Acre",
            value: "ac",
        },
        {
            label: "Alagoas",
            value: "al",
        },
        {
            label: "Amapá",
            value: "ap",
        },
        {
            label: "Amazonas",
            value: "am",
        },
        {
            label: "Bahia",
            value: "ba",
        },
        {
            label: "Ceará",
            value: "ce",
        },
        {
            label: "Distrito Federal",
            value: "df",
        },
        {
            label: "Espírito Santo",
            value: "es",
        },
        {
            label: "Goiás",
            value: "go",
        },
        {
            label: "Maranhão",
            value: "ma",
        },
        {
            label: "Mato Grosso",
            value: "mt",
        },
        {
            label: "Mato Grosso do Sul",
            value: "ms",
        },
        {
            label: "Minas Gerais",
            value: "mg",
        },
        {
            label: "Pará",
            value: "pa",
        },
        {
            label: "Paraíba",
            value: "pb",
        },
        {
            label: "Paraná",
            value: "pr",
        },
        {
            label: "Pernambuco",
            value: "pe",
        },
        {
            label: "Piauí",
            value: "pi",
        },
        {
            label: "Rio de Janeiro",
            value: "rj",
        },
        {
            label: "Rio Grande do Norte",
            value: "rn",
        },
        {
            label: "Rio Grande do Sul",
            value: "rs",
        },
        {
            label: "Rondônia",
            value: "ro",
        },
        {
            label: "Roraima",
            value: "rr",
        },
        {
            label: "Santa Catarina",
            value: "sc",
        },
        {
            label: "São Paulo",
            value: "sp",
        },
        {
            label: "Sergipe",
            value: "se",
        },
        {
            label: "Tocantins",
            value: "to",
        },
    ];
});

watch(
    () => props.form.address_cep,
    (cep) => {
        if (props.mode === "edit") {
            return;
        }

        setAddressByCep(cep);
    },
    {
        immediate: true,
    }
);
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
            @blur="handleCepChange"
            v-maska:[cepMask]
        />
        <InputError :message="form.errors.address_cep" class="mt-2" />
    </div>

    <div class="col-span-12 md:col-span-6">
        <InputLabel
            for="state"
            :value="ucfirst($t('validation.attributes.address_uf'))"
        />
        <SelectInput
            :disabled="form.processing"
            id="state"
            v-model="form.address_uf"
            type="text"
            class="mt-1 block w-full"
            :options="states"
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
