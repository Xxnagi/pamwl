<template>
  <div class="container p-4">
    <div class="flex gap-6 mb-4">
      <!-- Komponen Availability -->
      <Availability :items="products" />

      <StatCard :data="expenses" />
    </div>
    <div class="flex items-center justify-between mb-4">
      <!-- Search Bar -->
      <SearchBar
        v-model="searchQuery"
        placeholder="Cari Produk..."
        class="w-1/2"
      />

      <!-- Tombol untuk Menambah Produk -->
      <button
        @click="showModal = true"
        class="w-fit p-3 bg-[#2A7FE6] text-white rounded hover:bg-green-600"
      >
        Pesan Bahan
      </button>
    </div>

    <TableProducts
      :products="filteredProducts"
      :categories="categories"
      class="w-full"
    />

    <!-- Modal Form Tambah Produk -->
    <div
      v-if="showModal"
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
      <!-- <div class="bg-white p-6 rounded-lg w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4">Tambah Pembelian</h2>
        <form @submit.prevent="submitProduct" class="space-y-4">
      
          <div>
            <label class="block text-sm font-medium text-gray-700"
              >Nama Produk</label
            >
            <input
              v-model="product.name"
              required
              class="w-full p-2 border border-gray-300 rounded mt-1"
              placeholder="Nama Produk"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Harga</label>
            <input
              v-model.number="product.price"
              type="number"
              required
              class="w-full p-2 border border-gray-300 rounded mt-1"
              placeholder="Harga"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Stok</label>
            <input
              v-model.number="product.stock"
              type="number"
              required
              class="w-full p-2 border border-gray-300 rounded mt-1"
              placeholder="Stok"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700"
              >Kategori</label
            >
            <select
              v-model="product.category_id"
              required
              class="w-full p-2 border border-gray-300 rounded mt-1"
            >
              <option value="">Pilih Kategori</option>
              <option
                v-for="category in categories"
                :key="category.id"
                :value="category.id"
              >
                {{ category.category_name }}
              </option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700"
              >Supplier</label
            >
            <select
              v-model="product.supplier_id"
              required
              class="w-full p-2 border border-gray-300 rounded mt-1"
            >
              <option value="">Pilih Supplier</option>
              <option
                v-for="supplier in suppliers"
                :key="supplier.id"
                :value="supplier.id"
              >
                {{ supplier.supplier_name }}
              </option>
            </select>
          </div>

          <button
            type="submit"
            class="w-full p-2 bg-green-500 text-white rounded hover:bg-green-600"
          >
            Tambah Produk
          </button>
        </form>


        <div class="mt-6">
          <h3 class="text-lg font-semibold">Produk yang Dimasukkan</h3>
          <table class="min-w-full mt-2 table-auto">
            <thead>
              <tr>
                <th class="px-4 py-2 border">Nama</th>
                <th class="px-4 py-2 border">Harga</th>
                <th class="px-4 py-2 border">Stok</th>
                <th class="px-4 py-2 border">Kategori</th>
                <th class="px-4 py-2 border">Supplier</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(addedProduct, index) in addedProducts" :key="index">
                <td class="px-4 py-2 border">{{ addedProduct.name }}</td>
                <td class="px-4 py-2 border">{{ addedProduct.price }}</td>
                <td class="px-4 py-2 border">{{ addedProduct.stock }}</td>
                <td class="px-4 py-2 border">
                  {{ getCategoryName(addedProduct.category_id) }}
                </td>
                <td class="px-4 py-2 border">
                  {{ getSupplierName(addedProduct.supplier_id) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div> -->
      <Test />
    </div>
  </div>
</template>

<script>
import { ref, onMounted, computed } from "vue";
import { addData } from "../services/api";
import Availability from "../components/Availability.vue";
import TableProducts from "../components/TableProducts.vue";
import Test from "../views/Test.vue";

import SearchBar from "../components/SearchBar.vue";
import { useStore } from "vuex";
import StatCard from "../components/StatCard.vue";

export default {
  components: {
    Availability,
    StatCard,
    TableProducts,
    SearchBar,
    Test,
  },
  setup() {
    const showModal = ref(false); // Untuk mengontrol tampilan modal
    const product = ref({
      name: "",
      price: null,
      description: "",
      stock: null,
      category_id: "",
      supplier_id: "",
    });
    const store = useStore();

    const categories = computed(() => store.state.categories);
    const suppliers = computed(() => store.state.suppliers);
    const products = computed(() => store.state.products);
    const expenses = computed(() => store.state.expenses);
    const searchQuery = ref(""); // Menyimpan nilai pencarian

    const submitProduct = async () => {
      try {
        const response = await addData("/products", product.value);
        console.log("Product added:", response);
        await store.dispatch("fetchProducts"); // Use store dispatch directly
        showModal.value = false;
        product.value = {
          name: "",
          price: null,
          description: "",
          stock: null,
          category_id: "",
          supplier_id: "",
        };
      } catch (error) {
        console.error("Error adding product:", error);
      }
    };
    const filteredProducts = computed(() => {
      if (!searchQuery.value) {
        return products.value;
      }
      return products.value.filter((product) =>
        product.product_name
          .toLowerCase()
          .includes(searchQuery.value.toLowerCase())
      );
    });

    onMounted(() => {
      store.dispatch("initializeAppData");
    });
    return {
      showModal,
      product,
      categories,
      suppliers,
      products,
      expenses,
      searchQuery,
      filteredProducts,
      submitProduct,
    };
  },
};
</script>
