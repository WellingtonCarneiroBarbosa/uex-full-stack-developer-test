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
import { vMaska } from "maska";
import { nextTick, reactive, ref } from "vue";
import { useToast } from "vue-toastification";
import AddressSearcher from "@/Components/AddressSearcher.vue";

const props = defineProps({
    form: Object,
    mode: {
        type: String,
        default: "create",
    },
    contactId: String,
});

const cpfMask = reactive({
    mask: "###.###.###-##",
    eager: true,
});

const showAddressSearcherModal = ref(false);

const phoneNumberMask = reactive({
    mask: (value) =>
        value.length >= 14 || value.length == 11
            ? "(##) # ####-####"
            : "(##) ####-####",
});

const emit = defineEmits(["cancel", "submitted"]);

const commonTranslations = (name = "", attributes = {}) => {
    return trans(`pages.contacts.form.common.${name}`, attributes);
};

const pageTranslations = (name = "", attributes = {}) => {
    return trans(`pages.contacts.form.${props.mode}.${name}`, attributes);
};

const submit = async () => {
    props.form.clearErrors();

    await getCoordinates()
        .then(function (coordinates) {
            props.form.latitude = coordinates.latitude;
            props.form.longitude = coordinates.longitude;
        })
        .catch(() => {});

    if (props.mode === "create") {
        props.form.post(route("dash.contacts.store"), {
            onSuccess: (response) => {
                const toast = useToast();

                toast.success(response.props.flash.message, {
                    timeout: 3000,
                });

                emit("submitted");
            },
        });
    }

    if (props.mode === "edit") {
        props.form.put(
            route("dash.contacts.update", { contact: props.contactId }),
            {
                onSuccess: (response) => {
                    const toast = useToast();

                    toast.success(response.props.flash.message, {
                        timeout: 3000,
                    });

                    emit("submitted");
                },
            }
        );
    }
};

const fillAddress = (address) => {
    props.form.address_cep = address.cep;
    props.form.address_uf = address.state.toLowerCase();
    props.form.address_city = address.city;
    props.form.address_neighborhood = address.neighborhood;
    props.form.address_street = address.street;

    showAddressSearcherModal.value = false;

    nextTick(() => {
        document.getElementById("number")?.focus();
    });
};

const getCoordinates = () => {
    return new Promise((resolve, reject) => {
        let form = props.form;

        if (
            !form.address_uf ||
            !form.address_city ||
            !form.address_neighborhood ||
            !form.address_street ||
            !form.address_number
        ) {
            reject();
            return;
        }

        form.processing = true;

        window.axios
            .get(
                route("dash.get-coordinates", {
                    address: `${form.address_street},${form.address_number},${form.address_neighborhood},${form.address_city},${form.address_uf}`,
                })
            )
            .then((response) => {
                resolve(response.data);
            })
            .catch((error) => {
                reject(error);
            });
    });
};
</script>

<template>
    <AddressSearcher
        :show="showAddressSearcherModal"
        @close="showAddressSearcherModal = false"
        @addressSelected="fillAddress"
    />

    <FormSection @submitted="submit">
        <template #title>
            {{ pageTranslations("title") }}
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
                    v-maska:[cpfMask]
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
                    v-maska:[phoneNumberMask]
                />
                <InputError :message="form.errors.phone" class="mt-2" />
            </div>

            <div class="col-span-12">
                <SectionBorder class="-mt-10 -mb-5" />

                <div class="flex justify-between">
                    <h1 class="font-bold text-lg">
                        {{ commonTranslations("address") }}
                    </h1>

                    <PrimaryButton
                        type="button"
                        @click="showAddressSearcherModal = true"
                        >Buscar endereço</PrimaryButton
                    >
                </div>
            </div>

            <Address :mode="mode" :form="form" />
        </template>

        <template #actions>
            <SecondaryButton
                :disabled="form.processing"
                @click="emit('cancel')"
                class="mr-2"
                >{{ $t("words.cancel") }}</SecondaryButton
            >
            <PrimaryButton :disabled="form.processing" type="submit">{{
                $t("words.save")
            }}</PrimaryButton>
        </template>
    </FormSection>
</template>
