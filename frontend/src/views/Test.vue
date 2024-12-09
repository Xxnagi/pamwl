<template>
  <div class="p-6 max-w-2xl mx-auto bg-white shadow rounded-lg space-y-6">
    <h2 class="text-2xl font-semibold text-gray-800">Pemesanan Produk</h2>

    <!-- Dropdown Supplier -->
    <div class="flex w-full border rounded-lg bg-gray-50">
      <!-- Pilih Supplier -->
      <div class="border-r">
        <div class="flex flex-col p-5">
          <label for="supplier" class="text-sm font-medium text-gray-700">
            Pilih Supplier:
          </label>
          <select
            v-model="selectedSupplier"
            id="supplier"
            class="w-full h-[42px] px-2 bg-gray-50 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            <option value="" disabled>Pilih Supplier</option>
            <option
              v-for="supplier in suppliers"
              :key="supplier.supplier_id"
              :value="supplier.supplier_id"
            >
              {{ supplier.supplier_name }}
            </option>
          </select>
        </div>
      </div>

      <!-- Supplier Contact -->
      <div v-if="selectedSupplier" class="flex-1 flex-col p-5">
        <label for="supplier_contact" class="text-sm font-medium text-gray-700">
          Kontak Supplier:
        </label>
        <p class="w-full h-[42px] flex items-center px-2 mt-2">
          {{
            suppliers.find(
              (supplier) => supplier.supplier_id === selectedSupplier
            )?.supplier_contact || "Kontak tidak tersedia"
          }}
        </p>
      </div>
    </div>

    <h3 class="text-lg font-medium text-gray-800">Pilih Produk:</h3>
    <div class="space-y-4">
      <div
        v-for="product in filteredProducts"
        :key="product.product_id"
        class="flex items-center justify-between bg-gray-50 p-4 border border-gray-200 rounded-md"
      >
        <div class="flex items-center">
          <input
            type="checkbox"
            :id="product.product_id"
            :value="product.product_id"
            v-model="selectedProducts"
            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
          />
          <label :for="product.product_id" class="ml-3 text-sm text-gray-700">
            {{ product.product_name }} - Rp{{ product.price }}
          </label>
        </div>
        <div
          v-if="selectedProducts.includes(product.product_id)"
          class="ml-4 flex items-center justify-center h-12 space-x-2"
        >
          <!-- Tombol Kurangi -->
          <button
            @click="decrementQuantity(product)"
            class="w-8 h-8 flex items-center justify-center bg-gray-200 text-gray-700 rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            -
          </button>

          <!-- Counter -->
          <div
            class="w-12 h-8 flex items-center justify-center text-center text-sm font-medium border border-gray-300 rounded-md bg-white"
          >
            {{ product.quantity }}
          </div>

          <!-- Tombol Tambah -->
          <button
            @click="incrementQuantity(product)"
            class="w-8 h-8 flex items-center justify-center bg-gray-200 text-gray-700 rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            +
          </button>
        </div>
      </div>
    </div>

    <div class="pt-4 flex gap-4 justify-end">
      <!-- Tombol Batal -->
      <button
        @click="submitOrder"
        :disabled="!selectedProducts.length"
        class="w-40 px-4 py-2 text-[#A6B1BA] border-2 border-[#A6B1BA] rounded-md disabled:cursor-not-allowed disabled:text-gray-400 disabled:border-gray-400"
      >
        Batal
      </button>

      <!-- Tombol Pesan Bahan -->
      <button
        @click="submitOrder"
        :disabled="!selectedProducts.length"
        class="w-40 px-4 py-2 text-white bg-[#2A7FE6] rounded-md disabled:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed"
      >
        Pesan Bahan
      </button>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted, watch } from "vue";
import { useStore } from "vuex";

export default {
  setup() {
    const store = useStore();
    const selectedSupplier = ref(null);
    const selectedProducts = ref([]);

    const products = computed(() => store.state.products);
    const suppliers = computed(() => store.state.suppliers);
    const filteredProducts = ref([]);

    watch(selectedSupplier, (newValue) => {
      filterProductsBySupplier();
    });

    // Fungsi untuk menambah jumlah produk
    const incrementQuantity = (product) => {
      if (!product.quantity) {
        product.quantity = 1;
      } else {
        product.quantity++;
      }
    };

    // Fungsi untuk mengurangi jumlah produk
    const decrementQuantity = (product) => {
      if (product.quantity > 1) {
        product.quantity--;
      }
    };

    const filterProductsBySupplier = () => {
      console.log("Filter Method - Selected Supplier:", selectedSupplier.value);

      if (selectedSupplier.value) {
        filteredProducts.value = products.value.filter(
          (product) => product.supplier_id == selectedSupplier.value
        );
      } else {
        filteredProducts.value = [];
      }
    };

    // Fungsi untuk mengirimkan pemesanan ke server
    const submitOrder = async () => {
      const orderData = {
        purchase: {
          supplier_id: selectedSupplier.value,
        },
        transaction_date: new Date().toISOString().split("T")[0], // Format YYYY-MM-DD
        products: products.value
          .filter((product) =>
            selectedProducts.value.includes(product.product_id)
          )
          .map((product) => ({
            product_id: product.product_id,
            quantity: product.quantity,
          })),
      };

      try {
        const response = await fetch("http://127.0.0.1:8000/api/purchases", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(orderData),
        });
        const data = await response.json();
        if (data.success) {
          alert("Pemesanan berhasil!");
        } else {
          alert("Terjadi kesalahan: " + data.message);
        }
      } catch (error) {
        console.error("Error submitting order:", error);
      }
    };

    // Mengambil data awal dari store
    onMounted(() => {
      store.dispatch("initializeAppData"); // Inisialisasi data supplier// Mengambil semua produk
    });

    return {
      selectedSupplier,
      selectedProducts,
      suppliers,
      products,
      filteredProducts,
      incrementQuantity,
      decrementQuantity,
      submitOrder,
      filterProductsBySupplier,
    };
  },
};
</script>
