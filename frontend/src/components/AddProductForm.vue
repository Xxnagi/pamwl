<template>
  <div class="p-6 max-w-2xl mx-auto bg-white shadow rounded-lg">
    <form @submit.prevent="handleSubmit" class="space-y-6">
      <div class="flex flex-col">
        <label for="productName" class="text-sm font-medium text-gray-700">
          Nama Produk:
        </label>
        <input
          type="text"
          id="productName"
          v-model="productForm.product_name"
          placeholder="Masukkan nama produk"
          class="mt-2 p-3 border rounded-xl focus:ring focus:ring-blue-300"
          required
        />
      </div>

      <div class="flex flex-col">
        <label
          for="productDescription"
          class="text-sm font-medium text-gray-700"
        >
          Deskripsi Produk:
        </label>
        <textarea
          id="productDescription"
          v-model="productForm.product_description"
          placeholder="Masukkan deskripsi produk"
          class="mt-2 p-3 border rounded-xl focus:ring focus:ring-blue-300"
          required
        ></textarea>
      </div>

      <div class="flex flex-col">
        <label for="price" class="text-sm font-medium text-gray-700">
          Harga:
        </label>
        <input
          type="number"
          id="price"
          v-model="productForm.price"
          placeholder="Masukkan harga produk"
          class="mt-2 p-3 border rounded-xl focus:ring focus:ring-blue-300"
          required
        />
      </div>

      <div class="flex flex-col">
        <label for="vendorName" class="text-sm font-medium text-gray-700">
          Nama Vendor:
        </label>
        <input
          type="text"
          id="vendorName"
          v-model="productForm.supplier_name"
          placeholder="Masukkan nama vendor"
          class="mt-2 p-3 border rounded-xl focus:ring focus:ring-blue-300"
          required
        />
      </div>

      <div class="flex flex-col">
        <label for="vendorContact" class="text-sm font-medium text-gray-700">
          Kontak Vendor:
        </label>
        <input
          type="text"
          id="vendorContact"
          v-model="productForm.supplier_contact"
          placeholder="Masukkan kontak vendor"
          class="mt-2 p-3 border rounded-xl focus:ring focus:ring-blue-300"
          required
        />
      </div>

      <div class="flex flex-col">
        <label for="productCategory" class="text-sm font-medium text-gray-700">
          Kategori Produk:
        </label>
        <select
          id="productCategory"
          v-model="productForm.category_id"
          class="mt-2 p-3 border rounded-xl focus:ring focus:ring-blue-300"
          required
        >
          <option value="" disabled>Pilih kategori</option>
          <option
            v-for="category in categories"
            :key="category.category_id"
            :value="category.category_id"
          >
            {{ category.category_name }}
          </option>
        </select>
      </div>

      <div class="flex justify-end space-x-4">
        <button
          type="button"
          @click="resetForm"
          class="px-4 py-2 border rounded-xl text-gray-700 hover:bg-gray-100"
        >
          Batal
        </button>
        <button
          type="submit"
          class="px-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 focus:ring focus:ring-blue-300"
        >
          Simpan
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import store from "@/state/store";
import { computed } from "vue";
import { addData } from "@/services/api";

export default {
  data() {
    return {
      productForm: {
        product_name: "",
        product_description: "",
        price: null,
        supplier_name: "",
        supplier_contact: "",
        category_id: "",
      },
      categories: computed(() => store.state.categories),
    };
  },
  methods: {
    resetForm() {
      this.productForm = {
        product_name: "",
        product_description: "",
        price: null,
        supplier_name: "",
        supplier_contact: "",
        category_id: "",
      };
    },

    async handleSubmit() {
      try {
        console.log(productForm.value);
        // Siapkan payload data untuk API
        const payload = {
          product: {
            product_name: this.productForm.product_name,
            product_description: this.productForm.product_description,
            price: this.productForm.price,
          },
          supplier: {
            supplier_name: this.productForm.supplier_name,
            supplier_contact: this.productForm.supplier_contact,
          },
          category_id: this.productForm.category_id,
        };

        // Kirim request ke endpoint /products
        const response = await addData("/products", payload);
        console.log("Product added:", response);

        // Perbarui data produk setelah penambahan
        await store.dispatch("fetchProducts");
        await store.dispatch("fetchSuppliers");

        // Reset form
        this.resetForm();
      } catch (error) {
        console.error("Error adding product:", error);
        alert("Gagal menambahkan produk. Silakan coba lagi.");
      }
    },
  },
};
</script>
