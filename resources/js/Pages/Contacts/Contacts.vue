<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { trans } from "laravel-vue-i18n";

import { computed, onMounted, ref, reactive, onUpdated } from "vue";
import StringMask from "string-mask";
import Modal from "@/Components/Modal.vue";
import Form from "./Partials/Form.vue";
import { useForm, router } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import ContactItem from "./Partials/ContactItem.vue";

import Filter from "./Partials/Filter.vue";

const props = defineProps({
    contacts: Object,
});

const filterMode = ref(false);

const formData = useForm({
    name: "",
    email: "",
    phone: "",
    cpf: "",

    address_cep: "",
    address_uf: "",
    address_city: "",
    address_neighborhood: "",
    address_street: "",
    address_number: "",
    address_complement: "",

    latitude: "",
    longitude: "",
});

const showConfirmDeleteDialog = ref(false);

const selectedContact = ref(null);

const markers = ref([]);

const form = ref({
    mode: "create",
    show: false,
});

const resetFormComponent = () => {
    form.value.show = false;
    form.value.mode = "create";
    formData.reset();
    selectedContact.value = null;
};

const selectedContacts = ref([]);

const contactsFormatted = computed(() => {
    return props.contacts.data.map((contact) => {
        let phoneFormatter = new StringMask("(00) 0 0000-0000");
        return {
            ...contact,
            phone_formatted: phoneFormatter.apply(contact.phone),
        };
    });
});

const editContact = (contact) => {
    formData.name = contact.name;
    formData.email = contact.email;
    formData.phone = contact.phone;
    formData.cpf = contact.cpf;
    formData.address_cep = contact.address_cep;
    formData.address_uf = contact.address_uf;
    formData.address_city = contact.address_city;
    formData.address_neighborhood = contact.address_neighborhood;
    formData.address_city = contact.address_city;
    formData.address_street = contact.address_street;
    formData.address_number = contact.address_number;
    formData.address_complement = contact.address_complement;
    formData.latitude = contact.latitude;
    formData.longitude = contact.longitude;
    formData.address_complement = contact.address_complement;

    selectedContact.value = contact;
    form.value.mode = "edit";
    form.value.show = true;
};

const deleteContact = (contact) => {
    selectedContact.value = contact;
    showConfirmDeleteDialog.value = true;
};

const deleteContactDismissed = () => {
    selectedContact.value = null;
    showConfirmDeleteDialog.value = false;
};

const confirmContactDeleting = () => {
    let button = document.getElementById("confirm-contact-delete-button");

    button.attributes.disabled = true;
    button.innerText = "Deletando...";

    router.delete(
        route("dash.contacts.delete", { contact: selectedContact.value.id }),
        {
            onSuccess: (response) => {
                showConfirmDeleteDialog.value = false;
                selectedContact.value = null;
            },
        }
    );
};

const pushContacts = (contact) => {
    const index = selectedContacts.value.findIndex((c) => c.id === contact.id);

    if (index !== -1) {
        selectedContacts.value.splice(index, 1);

        removeMarker(contact.id, contact.latitude, contact.longitude);
    } else {
        selectedContacts.value.push(contact);

        addMarkerOnMap(
            contact.id,
            contact.name,
            contact.latitude,
            contact.longitude
        );
    }
};

const pageTranslations = (name = "", attributes = {}) => {
    return trans(`pages.contacts.${name}`, attributes);
};

const addMarkerOnMap = async (id, title, lat, lng) => {
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

    const marker = new AdvancedMarkerElement({
        map: window.map,
        position: { lat: lat, lng: lng },
        title: title,
    });

    markers.value.push({
        id: id,
        marker: marker,
    });

    window.map.setCenter({ lat: lat, lng: lng });

    window.map.setZoom(14);
};

const removeMarker = (id, lat, lng) => {
    let marker = markers.value.find((marker) => marker.id === id);

    if (marker) {
        marker.marker.setMap(null);
        markers.value = markers.value.filter((marker) => marker.id !== id);

        window.map.setCenter({ lat: lat, lng: lng });

        window.map.setZoom(14);
    }
};

const filterForm = useForm({
    name: "",
    cpf: "",
});

const clearFilters = () => {
    filterForm.cpf = "";
    filterForm.name = "";

    router.get(
        route("dash.contacts.index"),
        {},
        {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                filterMode.value = false;
            },
        }
    );
};

let customMap;

async function initMap() {
    const position = { lat: -25.5, lng: -49.163 };

    //@ts-ignore
    const { Map } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

    customMap = new Map(document.getElementById("map"), {
        zoom: 6,
        center: position,
        mapId: "DEMO_MAP_ID",
    });

    window.map = customMap;
}

onMounted(() => {
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.has("cpf") || urlParams.has("name")) {
        filterMode.value = true;
    }

    initMap();
});

onUpdated(() => {
    initMap();
});
</script>

<template>
    <Modal
        max-width="4xl"
        :show="form.show"
        :closeable="true"
        @close="resetFormComponent()"
    >
        <div class="p-4">
            <Form
                @cancel="resetFormComponent()"
                :contact-id="selectedContact?.id"
                :mode="form.mode"
                :form="formData"
            />
        </div>
    </Modal>

    <ConfirmationModal
        :show="showConfirmDeleteDialog"
        @close="deleteContactDismissed"
    >
        <template #title>Você tem certeza?</template>
        <template #content
            >O contato {{ selectedContact.name }} será permanentemente
            excluído!</template
        >

        <template #footer>
            <PrimaryButton
                id="confirm-contact-delete-button"
                @click="confirmContactDeleting"
                >Deletar</PrimaryButton
            >
        </template>
    </ConfirmationModal>

    <AppLayout :title="pageTranslations('title')">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                {{ pageTranslations("title") }}
            </h2>

            <p class="text-gray-800 dark:text-gray-200">
                {{ pageTranslations("description") }}
            </p>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-end mb-4">
                    <PrimaryButton @click="form.show = !form.show">{{
                        $t("words.add")
                    }}</PrimaryButton>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 p-4 overflow-hidden shadow-xl sm:rounded-lg"
                >
                    <div
                        class="grid grid-cols-12"
                        v-if="contactsFormatted.length >= 1"
                    >
                        <div
                            class="col-span-12 lg:col-span-5 pb-2 lg:pr-4 lg:pb-0"
                        >
                            <Filter
                                :form="filterForm"
                                :clear-filters="clearFilters"
                                @filtered="filterMode = true"
                            />
                            <div
                                class="flex pb-4 overflow-x-auto"
                                v-for="contact in contactsFormatted"
                                :key="contact.id"
                            >
                                <ContactItem
                                    :contact="contact"
                                    @edit="editContact(contact)"
                                    @delete="deleteContact(contact)"
                                    @checked="pushContacts(contact)"
                                />
                            </div>
                        </div>
                        <div
                            class="col-span-12 lg:col-span-7 border-t pt-2 lg:border-l lg:pl-2 lg:pt-0 lg:border-t-0"
                        >
                            <div id="map"></div>
                        </div>
                    </div>

                    <p v-if="contactsFormatted.length <= 0">
                        {{
                            filterMode
                                ? "Nenhum contato encontrado."
                                : "Você ainda não possui contatos. Adicione um para começar."
                        }}

                        <span
                            class="cursor-pointer underline"
                            v-if="filterMode"
                            @click="clearFilters"
                            >Limpar filtros</span
                        >
                    </p>

                    <!-- content-->
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style>
#map {
    min-height: 400px;
    height: 100%;
    width: 100%;
}
</style>
