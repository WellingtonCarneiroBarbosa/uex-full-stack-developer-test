<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import { Dot } from "lucide-vue-next";

const props = defineProps({
    contact: Object,
});

const emit = defineEmits(["edit", "delete", "checked"]);
</script>

<template>
    <div class="flex flex-row items-center gap-4">
        <div>
            <input
                :id="`check-contact-${contact.id}`"
                placeholder="check box"
                type="checkbox"
                class="checkbox rounded-md cursor-pointer h-4 w-4"
                @change="emit('checked')"
            />
        </div>

        <label :for="`check-contact-${contact.id}`" class="cursor-pointer">
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
                        <li class="text-lg text-gray-800 dark:text-gray-100">
                            {{ contact.name }}
                        </li>
                        <li class="text-sm dark:text-gray-400 mt-1">
                            <a
                                :href="`https://wa.me/55${contact.phone}`"
                                class="hover:underline"
                            >
                                {{ contact.phone_formatted }}
                            </a>
                        </li>
                        <li class="text-sm dark:text-gray-400 mt-1">
                            <a
                                :href="`mailto:${contact.email}`"
                                class="hover:underline"
                            >
                                {{ contact.email }}
                            </a>
                        </li>

                        <li class="text-sm dark:text-gray-400 mt-1">
                            {{ contact.full_address }}
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
                            class="w-full rounded-md hover:bg-gray-200 dark:hover:bg-slate-600 text-start p-1"
                            @click="emit('edit')"
                        >
                            {{ $t("words.details") }}
                            / {{ $t("words.edit") }}
                        </button>

                        <button
                            class="w-full rounded-md hover:bg-gray-200 dark:hover:bg-slate-600 text-start p-1"
                            @click="emit('delete')"
                        >
                            {{ $t("words.delete") }}
                        </button>
                    </div>
                </template>
            </Dropdown>
        </div>
    </div>
</template>
