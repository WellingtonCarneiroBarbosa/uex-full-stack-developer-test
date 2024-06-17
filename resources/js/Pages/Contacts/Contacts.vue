<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ucfirst } from "@/Helpers/functions";
import { trans } from "laravel-vue-i18n";
import { Dot, Plus } from "lucide-vue-next";
import { computed, ref } from "vue";
import StringMask from "string-mask";
import Modal from "@/Components/Modal.vue";
import Form from "./Partials/Form.vue";
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    contacts: Object,
});

const form = ref({
    form: useForm({
        name: "",
        email: "",
        phone: "",
        document: "",

        address_cep: "",
        address_state: "",
        address_city: "",
        address_neighborhood: "",
        address_street: "",
        address_number: "",
        address_complement: "",
    }),
    mode: "create",
    show: false,
});

const resetFormComponent = () => {
    form.value.show = false;
    form.value.mode = "create";
    form.value.form.reset();
};

const selectedContact = ref(null);

const contactsFormatted = computed(() => {
    return props.contacts.data.map((contact) => {
        let phoneFormatter = new StringMask("(00) 0 0000-0000");
        return {
            ...contact,
            phone_formatted: phoneFormatter.apply(contact.phone),
        };
    });
});

const toggleContact = (contact) => {
    selectedContact.value?.id === contact.id
        ? (selectedContact.value = null)
        : (selectedContact.value = contact);
};

const pageTranslations = (name = "", attributes = {}) => {
    return trans(`pages.contacts.${name}`, attributes);
};
</script>

<template>
    <Modal
        max-width="4xl"
        :show="form.show"
        :closeable="true"
        @close="resetFormComponent()"
    >
        <div class="p-4">
            <Form @cancel="resetFormComponent()" :form="form.form" />
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
                            <div class="flex pt-10 pb-24 overflow-x-auto">
                                <div
                                    class="flex flex-row items-center gap-4"
                                    v-for="contact in contactsFormatted"
                                    :key="contact.id"
                                >
                                    <div>
                                        <input
                                            id="check-contact"
                                            placeholder="check box"
                                            type="checkbox"
                                            class="checkbox rounded-md cursor-pointer h-4 w-4"
                                            @change="toggleContact(contact)"
                                        />
                                    </div>

                                    <label
                                        for="check-contact"
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
                                        <button
                                            aria-label="erase"
                                            class="flex focus:bg-white hover:bg-white dark:focus:bg-slate-600 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 rounded-md"
                                        >
                                            <Dot />
                                            <Dot class="-ml-4" />
                                            <Dot class="-ml-4" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-span-12 lg:col-span-8 border-t pt-2 lg:border-l lg:pl-2 lg:pt-0 lg:border-t-0"
                        >
                            Selected contact:
                            {{ selectedContact?.name ?? "None" }}
                        </div>
                    </div>
                    <!-- content-->
                </div>
            </div>
        </div>
    </AppLayout>
</template>
