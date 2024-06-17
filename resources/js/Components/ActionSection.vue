<script setup>
import SectionTitle from "./SectionTitle.vue";
</script>

<template>
    <div class="">
        <SectionTitle>
            <template #title>
                <slot name="title" />
            </template>
            <template #description>
                <slot name="description" />
            </template>
        </SectionTitle>

        <div class="mt-5">
            <div
                class="px-4 py-5 sm:p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg"
            >
                <slot name="content" />
            </div>
        </div>
    </div>
</template>
