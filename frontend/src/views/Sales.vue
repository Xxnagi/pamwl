<template>
  <div class="container p-8">
    <div class="mb-4 flex gap-6 min-w-max">
      <StatCard :data="sales" :type="'sales'" class="flex-1" />
      <StatCard :data="transactions" :type="'sold_product'" class="flex-1" />
      <StatCard :data="sales" :type="'average_sales'" class="flex-1" />
    </div>
    <div class="flex gap-6 mb-8">
      <SalesChart
        :transactions="transactions"
        :products="products"
        class="w-1/2"
      />
      <FinancialChart :transactions="transactions" class="w-1/2" />
    </div>

    <div class="flex items-center justify-between mb-4 w-full">
      <!-- Search Bar -->
      <SearchBar
        v-model="searchQuery"
        placeholder="Cari Produk..."
        class="w-1/2"
      />
      <button
        @click="showModal = true"
        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
      >
        Tambah Transaksi
      </button>
    </div>

    <!-- Filtered Transaction Table -->
    <TransactionTable
      :products="filteredProducts"
      :transactions="transactions"
    />
  </div>

  <div
    v-if="showModal"
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
  >
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl">
      <div class="p-6 gap-6 flex gap-6items-center border-b">
        <button
          @click="showModal = false"
          class="text-gray-500 hover:text-gray-700 rounded-full"
        >
          ✕
        </button>
        <h3 class="text-lg font-semibold">Tambah Bahan Baku</h3>
      </div>
      <div>
        <TransactionForm
          :apiEndpoint="'/sales'"
          :showSupplier="false"
          @close="showModal"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { useStore } from "vuex";
import { ref, onMounted, computed } from "vue";
import TransactionTable from "../components/TransactionTable.vue";
import TransactionForm from "../components/TransactionForm.vue";
import StatCard from "@/components/StatCard.vue";
import SearchBar from "@/components/SearchBar.vue";
import SalesChart from "@/components/SalesChart.vue";
import FinancialChart from "@/components/FinancialChart.vue";

export default {
  components: {
    TransactionTable,
    StatCard,
    TransactionForm,
    SearchBar,
    SalesChart,
    FinancialChart,
  },
  setup() {
    const showModal = ref(false);
    const searchQuery = ref(""); // Menyimpan nilai pencarian produk
    const store = useStore();
    const sales = computed(() => store.state.sales);
    const transactions = computed(() => store.state.transactions);
    const products = computed(() => store.state.products);

    // Filtering produk berdasarkan searchQuery
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

    const formatCurrency = (value) => {
      return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
      }).format(value);
    };

    onMounted(() => {
      store.dispatch("initializeAppData");
    });

    return {
      showModal,
      sales,
      transactions,
      products,
      filteredProducts,
      searchQuery,
      formatCurrency,
    };
  },
};
</script>
