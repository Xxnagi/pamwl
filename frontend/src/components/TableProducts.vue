<template>
  <div class="overflow-x-auto bg-white shadow-md rounded-lg">
    <table class="min-w-full table-auto border">
      <thead>
        <tr class="text-left">
          <th class="px-4 py-4" colspan="4">Laporan Bahan Baku</th>
        </tr>
      </thead>
      <thead>
        <tr class="bg-gray-100 text-left">
          <th class="px-4 py-4">Nama Produk</th>
          <th class="px-4 py-4">Stok</th>
          <th class="px-4 py-4">Kategori</th>
          <th class="px-4 py-4">Status</th>
          <!-- Added Status column -->
        </tr>
      </thead>
      <tbody>
        <!-- Tampilkan produk yang disaring -->
        <tr v-for="product in products" :key="product.id" class="border">
          <td class="px-4 py-4">{{ product.product_name }}</td>
          <td class="px-4 py-4">{{ product.stock }}</td>
          <td class="px-4 py-4">{{ getCategoryName(product.category_id) }}</td>
          <td class="px-4 py-4">
            <span
              class="px-2 py-1 rounded-full text-xs font-semibold inline-block"
              :class="{
                'bg-red-100 text-red-800': product.stock === 0,
                'bg-yellow-100 text-yellow-800':
                  product.stock < 20 && product.stock > 0,
                'bg-green-100 text-green-800': product.stock >= 20,
              }"
            >
              {{ getStatus(product.stock) }}
            </span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: "TableProduk",
  props: {
    products: {
      type: Array,
      required: true,
    },
    categories: {
      type: Array,
      required: true, // Pastikan kategori juga diterima sebagai prop
    },
  },
  methods: {
    // Method to return the correct status based on stock
    getStatus(stock) {
      if (stock === 0) return "Habis";
      if (stock < 20) return "Hampir Habis";
      return "Masih Tersedia";
    },

    getCategoryName(categoryId) {
      // Add null/undefined check
      if (!this.categories || this.categories.length === 0) {
        return "Kategori Tidak Tersedia";
      }

      const category = this.categories.find(
        (cat) => cat.category_id === categoryId
      );
      return category ? category.category_name : "Kategori Tidak Diketahui";
    },
  },
};
</script>

<style scoped>
/* Tambahkan style tambahan jika diperlukan */
</style>
