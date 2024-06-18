<script setup>
import { ref } from "vue";

defineProps({
    modelValue: String,
    disabled: {
        type: Boolean,
        default: false,
    },
    options: Array,
});

defineEmits(["update:modelValue"]);

const input = ref(null);
</script>

<template>
    <select
        ref="input"
        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
        :class="{
            'bg-opacity-70 bg-gray-200 dark:bg-gray-600': disabled,
        }"
        :value="modelValue"
        :disabled="disabled"
        @input="$emit('update:modelValue', $event.target.value)"
    >
        <option v-for="option in options" :value="option.value">
            {{ option.label }}
        </option>
    </select>
</template>
