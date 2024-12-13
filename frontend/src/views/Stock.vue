<template>
  <div class="container py-8">
    <div class="flex gap-6 max-w-3xl px-8 mb-4">
      <Availability :items="products" class="flex-1" />
      <StatCard :data="purchases" :type="'purchase'" class="flex-1" />
    </div>

    <div class="border mb-4"></div>

    <div class="flex items-center justify-between w-full px-8 mb-4">
      <SearchBar
        v-model="searchQuery"
        placeholder="Cari Produk..."
        class="w-1/2"
      />

      <div class="flex items-center gap-4">
        <Button
          @click="$refs.sortPopover.toggle($event)"
          icon="pi pi-sort-alt"
          severity="contrast"
          variant="outlined"
          label="Sort"
        />
        <Popover ref="sortPopover">
          <div class="p-4 w-96">
            <div class="flex justify-between items-center mb-4">
              <h4 class="font-semibold">Sort</h4>
              <Button
                severity="contrast"
                @click="$refs.sortPopover.hide()"
                icon="pi pi-times"
                variant="text"
                rounded
              />
            </div>
            <div class="space-y-2">
              <div
                v-for="option in sortOptions"
                :key="option.value"
                class="flex items-center"
              >
                <RadioButton
                  v-model="tempSortOption"
                  :value="option.value"
                  :inputId="option.value"
                />
                <label :for="option.value" class="ml-2 cursor-pointer">
                  {{ option.label }}
                </label>
              </div>
            </div>
            <div class="flex justify-between mt-4">
              <Button
                label="Reset"
                severity="secondary"
                @click="resetSorting"
              />
              <Button label="Terapkan" @click="applySorting" />
            </div>
          </div>
        </Popover>
        <Button
          @click="$refs.filterPopover.toggle($event)"
          icon="pi pi-sliders-h"
          severity="contrast"
          variant="outlined"
          label="Filter"
        />

        <Popover ref="filterPopover">
          <div class="w-96 p-4">
            <div class="w-full flex justify-between items-center mb-4">
              <h4 class="font-semibold">Filter</h4>
              <Button
                severity="contrast"
                @click="$refs.filterPopover.hide()"
                icon="pi pi-times"
                variant="text"
                rounded
              />
            </div>
            <div class="space-y-3">
              <div>
                <div class="flex justify-between items-center">
                  <label>Kategori</label>
                  <Button
                    label="Hapus"
                    @click="resetCategoryFilter"
                    variant="link"
                    severity="primary"
                  />
                </div>
                <MultiSelect
                  v-model="selectedCategories"
                  :options="categories"
                  optionLabel="category_name"
                  optionValue="category_id"
                  placeholder="Pilih Kategori"
                  class="w-full"
                />
              </div>
              <div>
                <label class="block mb-2">Status</label>
                <div class="flex gap-2">
                  <Select
                    v-model="statusFilter"
                    :options="statusFilterOptions"
                    optionLabel="label"
                    optionValue="value"
                    placeholder="Pilih Status"
                    class="w-full"
                  />
                </div>
              </div>
              <div class="flex justify-between pt-2">
                <Button
                  label="Reset"
                  severity="contrast"
                  variant="outlined"
                  class="w-1/3"
                  @click="resetFilter"
                />
                <Button label="Terapkan" class="w-1/3" @click="applyFilters" />
              </div>
            </div>
          </div>
        </Popover>

        <button
          @click="showAddModal = true"
          class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors"
        >
          Tambah Product
        </button>

        <button
          @click="showOrderModal = true"
          class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors"
        >
          Pesan Bahan
        </button>
      </div>
    </div>
    <div class="p-8">
      <TableProducts :products="processedProducts" :categories="categories" />
    </div>

    <!-- Modal remains the same as in your original code -->
    <div
      v-if="showOrderModal"
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
      <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl">
        <div class="p-6 gap-6 flex items-center border-b">
          <button
            @click="showOrderModal = false"
            class="text-gray-500 hover:text-gray-700"
          >
            ✕
          </button>
          <h3 class="text-lg font-semibold">Tambah Bahan Baku</h3>
        </div>
        <div>
          <OrderProductForm @close="showModal = false" />
        </div>
      </div>
    </div>

    <div
      v-if="showAddModal"
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
      <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl">
        <div class="p-6 gap-6 flex items-center border-b">
          <button
            @click="showAddModal = false"
            class="text-gray-500 hover:text-gray-700"
          >
            ✕
          </button>
          <h3 class="text-lg font-semibold">Tambah Bahan Baku</h3>
        </div>
        <div>
          <AddProductForm @close="showAdddModal = false" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import store from "@/state/store";
import { computed } from "vue";
import Popover from "primevue/popover";
import Button from "primevue/button";
import MultiSelect from "primevue/multiselect";
import Select from "primevue/select";
import RadioButton from "primevue/radiobutton";
import "primeicons/primeicons.css";

import Availability from "../components/Availability.vue";
import TableProducts from "../components/TableProducts.vue";
import OrderProductForm from "@/components/OrderProductForm.vue";
import SearchBar from "../components/SearchBar.vue";
import StatCard from "../components/StatCard.vue";
import AddProductForm from "@/components/AddProductForm.vue";

export default {
  components: {
    Availability,
    StatCard,
    TableProducts,
    SearchBar,
    OrderProductForm,
    Popover,
    Button,
    Select,
    MultiSelect,
    RadioButton,
    AddProductForm,
    OrderProductForm,
  },
  data() {
    return {
      // Store state computeds
      suppliers: computed(() => store.state.suppliers),
      products: computed(() => store.state.products),
      categories: computed(() => store.state.categories),
      purchases: computed(() => store.state.purchases),

      // Search and filtering
      searchQuery: "",
      selectedCategories: [],
      statusFilter: null,
      showOrderModal: false,
      showAddModal: false,

      // Sort options
      sortOptions: [
        { label: "Nama (A-Z)", value: "name_asc" },
        { label: "Nama (Z-A)", value: "name_desc" },
        { label: "Kategori (A-Z)", value: "category_asc" },
        { label: "Kategori (Z-A)", value: "category_desc" },
        { label: "Stok Terendah", value: "stock_asc" },
        { label: "Stok Tertinggi", value: "stock_desc" },
      ],
      currentSortOption: "name_asc",
      tempSortOption: "name_asc",

      // Status filter options
      statusFilterOptions: [
        { label: "Masih", value: "masih" },
        { label: "Hampir", value: "hampir" },
        { label: "Habis", value: "habis" },
      ],

      // Filter state
      filterState: {
        categories: [],
        status: null,
      },
    };
  },
  computed: {
    processedProducts() {
      let result = [...this.products];

      // Search Filter
      if (this.searchQuery) {
        result = result.filter((product) =>
          product.product_name
            .toLowerCase()
            .includes(this.searchQuery.toLowerCase())
        );
      }

      // Category Filter
      if (this.filterState.categories.length > 0) {
        result = result.filter((product) =>
          this.filterState.categories.includes(product.category_id)
        );
      }

      // Stock Filter
      if (this.filterState.status) {
        result = result.filter((product) => {
          switch (this.filterState.status) {
            case "hampir":
              return product.stock < 10 && product.stock > 0;
            case "masih":
              return product.stock >= 20;
            case "habis":
              return product.stock <= 0;
            default:
              return true;
          }
        });
      }

      // Sorting
      result.sort((a, b) => {
        const getCategoryName = (product) => {
          const category = this.categories.find(
            (cat) => cat.id === product.category_id
          );
          return category ? category.name : "";
        };

        switch (this.currentSortOption) {
          case "name_asc":
            return a.product_name.localeCompare(b.product_name);
          case "name_desc":
            return b.product_name.localeCompare(a.product_name);
          case "category_asc":
            return getCategoryName(a).localeCompare(getCategoryName(b));
          case "category_desc":
            return getCategoryName(b).localeCompare(getCategoryName(a));
          case "stock_asc":
            return a.stock - b.stock;
          case "stock_desc":
            return b.stock - a.stock;
          default:
            return 0;
        }
      });

      return result;
    },
  },
  methods: {
    applySorting() {
      this.currentSortOption = this.tempSortOption;
      this.$refs.sortPopover.hide();
    },

    resetSorting() {
      this.tempSortOption = "name_asc";
      this.currentSortOption = "name_asc";
    },

    applyFilters() {
      this.filterState.categories = [...this.selectedCategories];
      this.filterState.status = this.statusFilter;
      this.$refs.filterPopover.hide();
    },

    resetFilter() {
      this.selectedCategories = [];
      this.filterState.categories = [];
      this.statusFilter = null;
      this.filterState.status = null;
    },

    resetCategoryFilter() {
      this.selectedCategories = [];
      this.filterState.categories = [];
    },

    resetStatusFilter() {
      this.statusFilter = null;
      this.filterState.status = null;
    },
  },
  mounted() {
    store.dispatch("initializeAppData");
  },
};
</script>

<style scoped>
.radiobutton.focus.ring.color {
  color: #3b82f6;
}
</style>
