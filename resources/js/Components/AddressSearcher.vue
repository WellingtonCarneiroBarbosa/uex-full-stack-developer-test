<script setup>
import { ref } from "vue";
import Modal from "./Modal.vue";
import FormSection from "./FormSection.vue";
import InputLabel from "./InputLabel.vue";
import TextInput from "./TextInput.vue";
import InputError from "./InputError.vue";
import SecondaryButton from "./SecondaryButton.vue";
import PrimaryButton from "./PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    show: Boolean,
});

const emit = defineEmits(["close", "addressSelected"]);

const form = useForm({
    address: "",
});

const addresses = ref([]);

const selectAddress = (address) => {
    emit("addressSelected", address);

    form.clearErrors();
    form.address = "";
    addresses.value = [];
};

const searchAddresses = () => {
    form.processing = true;

    form.clearErrors();

    window.axios
        .get(
            route("api.get-potential-addresses", {
                address: form.address,
            })
        )
        .then((response) => {
            addresses.value = response.data;
        })
        .catch((error) => {
            if (error?.response?.status === 422) {
                form.errors.address = error.response.data.errors.address[0];
                return;
            }
        })
        .finally(() => {
            form.processing = false;
        });
};
</script>

<template>
    <Modal :show="show" @close="emit('close')">
        <div class="p-4">
            <FormSection @submitted="searchAddresses">
                <template #title>Buscar endereço</template>
                <template #description
                    >Insira o nome de um logradouro para buscar o endereço
                    completo e o CEP</template
                >

                <template #form>
                    <div class="col-span-12">
                        <InputLabel for="address-searcher"
                            >Endereço:</InputLabel
                        >
                        <TextInput
                            id="address-searcher"
                            v-model="form.address"
                            :disabled="form.processing"
                            class="w-full"
                        />
                        <InputError :message="form.errors.address" />
                    </div>
                </template>

                <template #actions>
                    <SecondaryButton
                        :disabled="form.processing"
                        @click="emit('close')"
                        class="mr-2"
                        >Cancelar</SecondaryButton
                    >
                    <PrimaryButton :disabled="form.processing" type="submit"
                        >Buscar</PrimaryButton
                    >
                </template>
            </FormSection>

            <div class="mt-2" v-if="addresses.length > 0">
                <div
                    class="bg-gray-600 p-2 rounded-md mb-4 flex justify-between items-center"
                    v-for="address in addresses"
                >
                    <ul>
                        <li>Rua: {{ address.street }}</li>
                        <li>Bairro: {{ address.neighborhood }}</li>
                        <li>Cidade: {{ address.city }}</li>
                        <li>UF: {{ address.state }}</li>
                        <li>CEP: {{ address.cep }}</li>
                    </ul>

                    <PrimaryButton @click="selectAddress(address)"
                        >Selecionar</PrimaryButton
                    >
                </div>
            </div>
        </div>
    </Modal>
</template>
