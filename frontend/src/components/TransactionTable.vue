<template>
  <div class="overflow-x-auto bg-white shadow-md rounded-lg">
    <table class="min-w-full table-auto border">
      <thead>
        <tr class="text-left">
          <th class="px-4 py-4" colspan="4">
            {{
              dataType === "sales" ? "Laporan Penjualan" : "Laporan Pembelian"
            }}
          </th>
        </tr>
      </thead>
      <thead>
        <tr class="bg-gray-100 text-left">
          <th class="px-4 py-4">ID</th>
          <th class="px-4 py-4">
            {{
              dataType === "sales" ? "Tanggal Penjualan" : "Tanggal Pembelian"
            }}
          </th>
          <th class="px-4 py-4">
            {{ dataType === "sales" ? "Customer ID" : "Supplier ID" }}
          </th>
          <th class="px-4 py-4">Total</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in items" :key="item.id" class="border">
          <td class="px-4 py-4">
            {{ dataType === "sales" ? item.sales_id : item.purchase_id }}
          </td>
          <td class="px-4 py-4">
            {{
              dataType === "sales"
                ? item.tanggal_penjualan
                : item.tanggal_pembelian
            }}
          </td>
          <td class="px-4 py-4">
            {{ dataType === "sales" ? item.customer_id : item.supplier_id }}
          </td>
          <td class="px-4 py-4">
            {{
              dataType === "sales"
                ? formatCurrency(item.total_penjualan)
                : formatCurrency(item.total_pembelian)
            }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    dataType: {
      type: String,
      required: true, // "sales" atau "purchase"
    },
    items: {
      type: Array,
      required: true, // Array data untuk ditampilkan
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
