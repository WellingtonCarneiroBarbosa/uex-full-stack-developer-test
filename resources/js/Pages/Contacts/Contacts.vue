<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ucfirst } from "@/Helpers/functions";
import { trans } from "laravel-vue-i18n";
import { Dot, Plus } from "lucide-vue-next";
import { computed, onMounted, ref } from "vue";
import StringMask from "string-mask";
import Modal from "@/Components/Modal.vue";
import Form from "./Partials/Form.vue";
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Dropdown from "@/Components/Dropdown.vue";

const props = defineProps({
    contacts: Object,
});

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

onMounted(() => {
    let customMap;

    async function initMap() {
        const position = { lat: -25.5, lng: -49.163 };

        //@ts-ignore
        const { Map } = await google.maps.importLibrary("maps");
        const { AdvancedMarkerElement } = await google.maps.importLibrary(
            "marker"
        );

        customMap = new Map(document.getElementById("map"), {
            zoom: 6,
            center: position,
            mapId: "DEMO_MAP_ID",
        });

        window.map = customMap;
    }

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
                    <div class="grid grid-cols-12">
                        <div
                            class="col-span-12 lg:col-span-4 pb-2 lg:pr-2 lg:pb-0"
                        >
                            <div class="flex flex-row w-full">Filters</div>
                            <div
                                class="flex pb-4 overflow-x-auto"
                                v-for="contact in contactsFormatted"
                                :key="contact.id"
                            >
                                <div class="flex flex-row items-center gap-4">
                                    <div>
                                        <input
                                            :id="`check-contact-${contact.id}`"
                                            placeholder="check box"
                                            type="checkbox"
                                            class="checkbox rounded-md cursor-pointer h-4 w-4"
                                            @change="pushContacts(contact)"
                                        />
                                    </div>

                                    <label
                                        :for="`check-contact-${contact.id}`"
                                        class="cursor-pointer"
                                    >
                                        <div class="flex flex-row items-center">
                                            <img
                                                class="h-10 w-10 rounded-full object-cover"
                                                :src="
                                                    contact.picture ??
                                                    `https://ui-avatars.com/api/?name=${contact.name}`
                                                "
                                                alt="wellington barbosa"
                                            />
                                            <div class="ml-4 w-full">
                                                <ul>
                                                    <li
                                                        class="text-lg text-gray-800 dark:text-gray-100"
                                                    >
                                                        {{ contact.name }}
                                                    </li>
                                                    <li
                                                        class="text-sm dark:text-gray-400 mt-1"
                                                    >
                                                        <a
                                                            :href="`https://wa.me/55${contact.phone}`"
                                                            class="hover:underline"
                                                        >
                                                            {{
                                                                contact.phone_formatted
                                                            }}
                                                        </a>
                                                    </li>
                                                    <li
                                                        class="text-sm dark:text-gray-400 mt-1"
                                                    >
                                                        <a
                                                            :href="`mailto:${contact.email}`"
                                                            class="hover:underline"
                                                        >
                                                            {{ contact.email }}
                                                        </a>
                                                    </li>

                                                    <li
                                                        class="text-sm dark:text-gray-400 mt-1"
                                                    >
                                                        {{
                                                            contact.full_address
                                                        }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </label>

                                    <div class="flex">
                                        <Dropdown>
                                            <template #trigger>
                                                <button
                                                    aria-label="erase"
                                                    class="flex focus:bg-white hover:bg-white dark:focus:bg-slate-600 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 rounded-md"
                                                >
                                                    <Dot />
                                                    <Dot class="-ml-4" />
                                                    <Dot class="-ml-4" />
                                                </button>
                                            </template>

                                            <template #content>
                                                <div class="p-1">
                                                    <button
                                                        class="w-full rounded-md hover:bg-slate-600 text-start p-1"
                                                        @click="
                                                            editContact(contact)
                                                        "
                                                    >
                                                        {{
                                                            $t("words.details")
                                                        }}
                                                        / {{ $t("words.edit") }}
                                                    </button>
                                                </div>
                                            </template>
                                        </Dropdown>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-span-12 lg:col-span-8 border-t pt-2 lg:border-l lg:pl-2 lg:pt-0 lg:border-t-0"
                        >
                            <div id="map"></div>
                        </div>
                    </div>
                    <!-- content-->
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style>
#map {
    height: 100%;
    width: 100%;
}
</style>
