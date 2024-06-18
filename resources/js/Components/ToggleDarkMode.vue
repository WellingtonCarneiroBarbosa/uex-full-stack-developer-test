<template>
    <div @click="toggleDarkMode" class="toggle-dark-mode">
        <Sun v-if="isDarkMode" class="h-7 w-7 text-black dark:text-white" />

        <Moon v-else class="h-7 w-7 text-black dark:text-white" />
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { Sun, Moon } from "lucide-vue-next";

const isDarkMode = ref(false);

const toggleDarkMode = () => {
    const html = document.documentElement;
    if (html.classList.contains("dark")) {
        html.classList.remove("dark");
        isDarkMode.value = false;
    } else {
        html.classList.add("dark");
        isDarkMode.value = true;
    }

    localStorage.setItem("darkMode", isDarkMode.value);
};

onMounted(() => {
    isDarkMode.value =
        JSON.parse(localStorage.getItem("darkMode")) ??
        document.documentElement.classList.contains("dark");

    if (
        isDarkMode.value &&
        !document.documentElement.classList.contains("dark")
    ) {
        toggleDarkMode();
    }

    localStorage.setItem("darkMode", isDarkMode.value);
});
</script>

<style>
.toggle-dark-mode {
    cursor: pointer;
    display: inline-block;
}
</style>
