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
          v-model.number="productForm.price"
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
import { ref, onMounted, computed } from "vue";
import store from "@/state/store";
import { addData } from "@/services/api";

export default {
  setup() {
    // Initialize form data
    const productForm = ref({
      product_name: "",
      product_description: "",
      price: null,
      supplier_name: "",
      supplier_contact: "",
      category_id: "",
    });

    // Get categories from store
    const categories = computed(() => store.state.categories);

    // Reset form method
    const resetForm = () => {
      productForm.value = {
        product_name: "",
        product_description: "",
        price: null,
        supplier_name: "",
        supplier_contact: "",
        category_id: "",
      };
    };

    // Submit handler
    const handleSubmit = async () => {
      try {
        // Prepare payload data for API to match controller's expected structure
        const payload = {
          product_name: productForm.value.product_name,
          product_description: productForm.value.product_description,
          price: productForm.value.price,
          stock: 0,
          category_id: productForm.value.category_id,
          supplier_name: productForm.value.supplier_name,
          supplier_contact: productForm.value.supplier_contact,
        };
        console.log(payload);

        // Send request to /products endpoint
        const response = await addData("/products", payload);
        console.log("Product added:", response);

        // Update product and supplier data
        await store.dispatch("fetchProducts");
        await store.dispatch("fetchSuppliers");

        // Reset form
        resetForm();

        // Optionally show success message
        alert("Produk berhasil ditambahkan");
      } catch (error) {
        console.error("Error adding product:", error);
        alert("Gagal menambahkan produk. Silakan coba lagi.");
      }
    };

    return {
      productForm,
      categories,
      resetForm,
      handleSubmit,
    };
  },
};
</script>
