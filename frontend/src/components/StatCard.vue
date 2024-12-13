<template>
  <div class="border-2 px-5 py-3 rounded-lg h-36">
    <h3 class="text-lg font-bold">{{ title }}</h3>
    <p class="text-2xl font-extrabold text-gray-800 mt-4">
      {{ displayedTotal }}
    </p>
  </div>
</template>

<script>
export default {
  props: {
    data: {
      type: Array,
      required: true,
    },
    type: {
      type: String,
      required: true,
    },
  },
  computed: {
    title() {
      switch (this.type) {
        case "sales":
          return "Total Penjualan";
        case "purchase":
          return "Total Pengeluaran";
        case "sold_product":
          return "Total Penjualan Produk";
        case "average_sales":
          return "Rata-rata Penjualan Bulanan";
        default:
          return "";
      }
    },
    total() {
      switch (this.type) {
        case "sales":
          return this.data.reduce(
            (acc, item) => acc + (item.total_penjualan || 0),
            0
          );
        case "purchase":
          return this.data.reduce(
            (acc, item) => acc + (item.total_pembelian || 0),
            0
          );
        case "sold_product":
          return this.data
            .filter((item) => item.jenis_transaksi === "Penjualan")
            .reduce((acc, item) => acc + (parseInt(item.quantity, 10) || 0), 0);
        default:
          return 0;
      }
    },
    averageSales() {
      if (!this.data.length) return 0;

      // Kelompokkan total penjualan berdasarkan bulan
      const salesByMonth = this.data.reduce((acc, item) => {
        const monthYear = new Date(item.tanggal_penjualan).toLocaleDateString(
          "id-ID",
          { year: "numeric", month: "2-digit" }
        );
        acc[monthYear] = (acc[monthYear] || 0) + (item.total_penjualan || 0);
        return acc;
      }, {});

      // Hitung total rata-rata
      const monthlyTotals = Object.values(salesByMonth);
      const totalSales = monthlyTotals.reduce((acc, val) => acc + val, 0);
      return totalSales / monthlyTotals.length;
    },

    displayedTotal() {
      if (this.type === "average_sales") {
        return new Intl.NumberFormat("id-ID", {
          style: "currency",
          currency: "IDR",
        }).format(this.averageSales);
      }

      if (this.type === "sold_product") {
        return this.total; // Tidak perlu format mata uang untuk jumlah barang
      }

      return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
      }).format(this.total);
    },
  },
};
</script>
