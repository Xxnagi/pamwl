<template>
  <div
    v-if="isOpen"
    class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-50"
  >
    <div class="bg-white p-6 rounded shadow-lg w-96">
      <div class="flex justify-between items-center">
        <h3 class="text-xl font-semibold mb-4">{{ title }}</h3>
        <button @click="close" class="text-gray-500 hover:text-gray-700">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-6 h-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>
      </div>
      <div>
        <slot></slot>
        <!-- Konten modal, seperti form atau lainnya -->
      </div>
      <div class="flex justify-end mt-4">
        <button
          @click="close"
          class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 mr-2"
        >
          Batal
        </button>
        <button
          @click="onSave"
          class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
        >
          Simpan
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    isOpen: {
      type: Boolean,
      required: true,
    },
    title: {
      type: String,
      required: true,
    },
    onSave: {
      type: Function,
      required: true,
    },
  },
  methods: {
    close() {
      this.$emit("update:isOpen", false);
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 1200px;
}
</style>
