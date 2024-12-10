<template>
  <div
    class="p-6 border space-y-4 rounded-xl max-w-2xl"
    @click.self="closeSuggestions"
  >
    <div class="flex flex-col space-y-4">
      <div class="flex border rounded-xl space-x-4">
        <div class="w-1/2 border-r p-4">
          <h3 class="text-gray-600">Vendor</h3>
          <select v-model="selectedSupplier">
            <option value="">Pilih Supplier</option>
            <option
              v-for="supplier in suppliers"
              :key="supplier.supplier_id"
              :value="supplier.supplier_id"
            >
              {{ supplier.supplier_name }}
            </option>
          </select>
        </div>

        <div v-if="selectedSupplier" class="p-4">
          <label class="text-sm text-gray-600">Kontak Supplier</label>
          <p>
            {{
              suppliers.find((s) => s.supplier_id === selectedSupplier)
                ?.supplier_contact || "Kontak tidak tersedia"
            }}
          </p>
        </div>
      </div>
    </div>

    <div class="border rounded-xl p-4">
      <div class="relative w-full">
        <input
          placeholder="Cari Produk"
          v-model="searchTerm"
          @input="searchProducts"
          @focus="searchProducts"
          class="border rounded-3xl py-3 px-4 w-full text-sm"
        />

        <div
          v-if="showSuggestions && searchSuggestions.length"
          class="absolute z-10 w-full border rounded mt-1 max-h-60 overflow-y-auto bg-white shadow"
        >
          <div
            v-for="product in searchSuggestions"
            :key="product.product_id"
            @click="addProductToTable(product)"
            class="p-2 hover:bg-gray-100 cursor-pointer"
          >
            {{ product.product_name }} - Rp{{ product.price.toLocaleString() }}
          </div>
        </div>
      </div>
      <table class="min-w-full text-sm mt-4 table-auto border rounded-2xl">
        <thead>
          <tr class="text-left bg-gray-100">
            <th class="px-4 py-3">Produk</th>
            <th class="px-4 py-3 text-center">Qty</th>
            <th class="px-4 py-3 text-right">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="product in selectedProducts"
            :key="product.product_id"
            class="border"
          >
            <td class="px-4 py-3">{{ product.product_name }}</td>
            <td class="px-4 py-3 text-center">
              <div class="flex items-center justify-center">
                <button
                  @click="
                    updateQuantity(product.product_id, product.quantity - 1)
                  "
                  class="p-1 border rounded"
                >
                  -
                </button>
                <span class="mx-2">{{ product.quantity }}</span>
                <button
                  @click="
                    updateQuantity(product.product_id, product.quantity + 1)
                  "
                  class="p-1 border rounded"
                >
                  +
                </button>
              </div>
            </td>
            <td class="px-4 py-3 text-right">
              Rp{{ (product.price * product.quantity).toLocaleString() }}
            </td>
          </tr>
          <tr class="font-bold bg-gray-50 border">
            <td colspan="2" class="px-4 py-3">Total</td>
            <td class="px-4 py-3 text-right">Rp{{ total.toLocaleString() }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div>
      <label for="notes" class="block text-sm text-gray-600">Notes</label>
      <textarea
        id="notes"
        v-model="notes"
        placeholder="Tambahkan catatan untuk pesanan"
        class="w-full mt-4 border rounded-xl p-3 text-sm"
        rows="4"
      ></textarea>
    </div>

    <div class="flex justify-end space-x-4">
      <button class="border rounded px-4 py-2">Batal</button>
      <button
        :disabled="selectedProducts.length === 0"
        class="bg-blue-500 text-white rounded px-4 py-2 disabled:opacity-50"
      >
        Pesan Bahan
      </button>
    </div>
  </div>
</template>

<script>
import store from "@/state/store";
import { computed } from "vue";

export default {
  data() {
    return {
      suppliers: computed(() => store.state.suppliers),
      products: computed(() => store.state.products),
      selectedSupplier: null,
      searchTerm: "",
      selectedProducts: [],
      searchSuggestions: [],
      showSuggestions: false,
    };
  },
  watch: {
    selectedSupplier() {
      this.searchTerm = "";
      this.searchSuggestions = [];
    },
  },
  computed: {
    total() {
      return this.selectedProducts.reduce(
        (sum, product) => sum + product.price * product.quantity,
        0
      );
    },
  },
  methods: {
    closeSuggestions() {
      this.showSuggestions = false;
    },
    searchProducts() {
      if (!this.searchTerm) {
        this.showSuggestions = false;
        return;
      }

      this.searchSuggestions = this.products.filter(
        (product) =>
          (this.selectedSupplier
            ? product.supplier_id === this.selectedSupplier
            : true) &&
          product.product_name
            .toLowerCase()
            .includes(this.searchTerm.toLowerCase())
      );

      this.showSuggestions = this.searchSuggestions.length > 0;
    },
    addProductToTable(product) {
      const existingProduct = this.selectedProducts.find(
        (p) => p.id === product.product_id
      );
      if (existingProduct) {
        existingProduct.quantity++;
      } else {
        this.selectedProducts.push({ ...product, quantity: 1 });
      }

      this.searchTerm = "";
      this.showSuggestions = false;
    },
    updateQuantity(productId, newQuantity) {
      const product = this.selectedProducts.find(
        (p) => p.product_id === productId
      );
      if (product) {
        product.quantity = Math.max(0, newQuantity);
        if (product.quantity === 0) {
          this.selectedProducts = this.selectedProducts.filter(
            (p) => p.product_id !== productId
          );
        }
      }
    },
  },
};
</script>
