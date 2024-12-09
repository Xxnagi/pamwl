<script setup>
import Drawer from "./layouts/Drawer.vue";
import Header from "./layouts/Header.vue";
import { onMounted } from "vue";
import { useStore } from "vuex";

const store = useStore();

onMounted(async () => {
  await store.dispatch("initializeAppData");
});
</script>

<template>
  <div class="flex font-nunito h-lvh">
    <!-- Drawer (Left Sidebar) -->
    <Drawer class="w-1/4 lg:w-1/5 border-r" />

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
      <!-- Header -->
      <Header class="h-16 border-b px-4" />

      <!-- Dynamic Content -->
      <div class="flex-1 overflow-auto p-4">
        <router-view />
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Additional styling for layout (optional) */
.drawer {
  background-color: #f9fafb; /* Light gray background for Drawer */
}

.header {
  background-color: #ffffff; /* White background for Header */
}

.content {
  background-color: #f3f4f6; /* Slightly darker gray for Content area */
}
</style>
