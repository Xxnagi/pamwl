<template>
  <div class="border-2 px-5 py-3 rounded-lg">
    <p class="font-bold text-2xl mb-7">{{ items.length }} Bahan Baku</p>

    <!-- Statistik Bahan Baku -->
    <div class="w-full h-3 flex mt-6">
      <!-- Bar Tersedia -->
      <div
        class="bg-green-500 rounded-xl"
        :style="{ width: availableWidth + '%' }"
      ></div>

      <!-- Bar Hampir Habis -->
      <div
        class="bg-yellow-400 rounded-xl"
        :style="{ width: almostOutWidth + '%' }"
      ></div>

      <!-- Bar Habis -->
      <div
        class="bg-red-400 rounded-xl"
        :style="{ width: outOfStockWidth + '%' }"
      ></div>
    </div>

    <div class="flex justify-between mt-6">
      <p class="text-sm">Tersedia: {{ available }}</p>
      <p class="text-sm">Hampir habis: {{ almostOut }}</p>
      <p class="text-sm">Habis: {{ outOfStock }}</p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    items: {
      type: Array,
      required: true,
    },
  },
  computed: {
    available() {
      return this.items.filter((item) => item.stock > 20).length;
    },
    almostOut() {
      return this.items.filter((item) => item.stock > 0 && item.stock <= 20)
        .length;
    },
    outOfStock() {
      return this.items.filter((item) => item.stock === 0).length;
    },
    availableWidth() {
      return (this.available / this.items.length) * 100;
    },
    almostOutWidth() {
      return (this.almostOut / this.items.length) * 100;
    },
    outOfStockWidth() {
      return (this.outOfStock / this.items.length) * 100;
    },
  },
};
</script>

<style scoped>
/* Styling untuk bar */
.w-72 {
  width: 18rem;
}
</style>
