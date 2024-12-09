<script setup>
import { ref } from "vue";
import axios from "axios";

// State untuk visibilitas form
const isFormVisible = ref(false);

// State untuk data produk
const newProduct = ref({
  name: "",
  price: "",
  description: "",
  stock: "",
  supplier_id: "",
  category_id: "",
});

// Fungsi untuk membuka/menutup form
const toggleForm = () => {
  isFormVisible.value = !isFormVisible.value;
};

// Fungsi untuk menambahkan produk
const addProduct = async () => {
  try {
    const response = await axios.post(
      "http://127.0.0.1:8000/api/products",
      newProduct.value
    );
    alert("Produk berhasil ditambahkan!");
    toggleForm(); // Tutup form setelah berhasil
    // Reset form
    newProduct.value = {
      name: "",
      price: "",
      description: "",
      stock: "",
      supplier_id: "",
      category_id: "",
    };
  } catch (error) {
    console.error("Error adding product:", error);
    alert("Gagal menambahkan produk!");
  }
};
</script>

<template>
  <div>
    <!-- Tombol untuk membuka form -->
    <button
      class="bg-blue-500 text-white px-4 py-2 rounded-md"
      @click="toggleForm"
    >
      Tambah Barang
    </button>

    <!-- Form untuk menambahkan produk -->
    <div v-if="isFormVisible" class="mt-4 p-4 border rounded-lg bg-gray-100">
      <h2 class="font-bold text-lg mb-4">Tambah Barang Baru</h2>
      <form @submit.prevent="addProduct">
        <div class="mb-2">
          <label class="block font-medium">Nama Barang</label>
          <input
            v-model="newProduct.name"
            type="text"
            class="border rounded-md p-2 w-full"
            required
          />
        </div>
        <div class="mb-2">
          <label class="block font-medium">Harga</label>
          <input
            v-model="newProduct.price"
            type="number"
            class="border rounded-md p-2 w-full"
            required
          />
        </div>
        <div class="mb-2">
          <label class="block font-medium">Deskripsi</label>
          <textarea
            v-model="newProduct.description"
            class="border rounded-md p-2 w-full"
            rows="3"
            required
          ></textarea>
        </div>
        <div class="mb-2">
          <label class="block font-medium">Stok</label>
          <input
            v-model="newProduct.stock"
            type="number"
            class="border rounded-md p-2 w-full"
            required
          />
        </div>
        <div class="mb-2">
          <label class="block font-medium">Supplier ID</label>
          <input
            v-model="newProduct.supplier_id"
            type="number"
            class="border rounded-md p-2 w-full"
            required
          />
        </div>
        <div class="mb-2">
          <label class="block font-medium">Category ID</label>
          <input
            v-model="newProduct.category_id"
            type="number"
            class="border rounded-md p-2 w-full"
            required
          />
        </div>
        <div class="flex gap-2">
          <button
            type="submit"
            class="bg-green-500 text-white px-4 py-2 rounded-md"
          >
            Simpan
          </button>
          <button
            type="button"
            class="bg-red-500 text-white px-4 py-2 rounded-md"
            @click="toggleForm"
          >
            Batal
          </button>
        </div>
      </form>
    </div>
  </div>
</template>
