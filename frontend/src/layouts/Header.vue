<script setup>
import { useRoute } from "vue-router";
import { computed } from "vue"; 

const route = useRoute();

// Fungsi untuk menentukan judul berdasarkan URL
const pageTitle = computed(() => {
  const pathToTitleMap = {
    "/": "Dashboard",
    "/stock": "Stock",
    "/purchase": "Purchase",
    "/sales": "Sales",
    "/report": "Report",
  };
  return pathToTitleMap[route.path] || "Page Not Found"; // Default jika path tidak dikenal
});
</script>

<template>
  <div class="flex items-center border-b-2 justify-between px-10 py-3">
    <h1 class="font-bold text-xl">{{ pageTitle }}</h1>
    <div>
      <p class="font-medium">Larry Lobster</p>
      <p class="font-medium">Admin</p>
    </div>
  </div>
</template>
