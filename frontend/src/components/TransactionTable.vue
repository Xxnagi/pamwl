<template>
  <table class="table-auto border w-full rounded-3xl overflow-">
    <thead>
      <tr class="text-left">
        <th class="px-4 py-4" colspan="5">Laporan Penjualan</th>
      </tr>
    </thead>
    <thead>
      <tr class="bg-gray-100 text-left">
        <th class="px-4 py-4">Nama Produk</th>
        <th class="px-4 py-4">Sisa Stok</th>
        <th class="px-4 py-4">Harga Produk</th>
        <th class="px-4 py-4">Total Terjual</th>
        <th class="px-4 py-4">Pendapatan</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="item in salesData" :key="item.product_id" class="border">
        <td class="px-4 py-4">{{ item.nama_produk }}</td>
        <td class="px-4 py-4">{{ item.sisa_stok }}</td>
        <td class="px-4 py-4">{{ formatCurrency(item.harga_produk) }}</td>
        <td class="px-4 py-4">{{ item.total_terjual }}</td>
        <td class="px-4 py-4">{{ formatCurrency(item.pendapatan) }}</td>
      </tr>
    </tbody>
  </table>
</template>

<script>
import { computed } from "vue";

export default {
  props: {
    transactions: {
      type: Array,
      required: true,
    },
    products: {
      type: Array,
      required: true,
    },
  },
  computed: {
    salesData() {
      // Filter transaksi dengan jenis_transaksi = "Penjualan"
      const salesTransactions = this.transactions?.filter(
        (trx) => trx.jenis_transaksi === "Penjualan"
      );

      // Gabungkan data transaksi dengan produk
      const result = salesTransactions?.reduce((acc, trx) => {
        const product = this.products.find(
          (prod) => prod.product_id === trx.product_id
        );
        if (product) {
          const existing = acc.find(
            (item) => item.product_id === product.product_id
          );

          if (existing) {
            existing.total_terjual += trx.quantity;
            existing.pendapatan = existing.total_terjual * product.price;
          } else {
            acc.push({
              product_id: product.product_id,
              nama_produk: product.product_name,
              sisa_stok: product.stock,
              harga_produk: product.price,
              total_terjual: trx.quantity,
              pendapatan: trx.quantity * product.price,
            });
          }
        }
        return acc;
      }, []);

      return result;
    },
  },
  methods: {
    formatCurrency(value) {
      return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
      }).format(value);
    },
  },
};
</script>

<style scoped>
/* Tambahkan gaya jika diperlukan */
</style>
