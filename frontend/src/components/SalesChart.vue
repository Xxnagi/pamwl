<template>
  <div class="rounded-lg border-2 w-full h-96 p-5">
    <p class="font-bold text-lg mb-4">Laporan Penjualan</p>
    <BarChart
      v-if="chartData.datasets[0].data.length > 0"
      :data="chartData"
      :options="chartOptions"
      class="h-64"
    />
    <p v-else class="text-gray-500">Tidak ada data penjualan</p>
  </div>
</template>

<script>
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from "chart.js";
import { Bar } from "vue-chartjs";

// Register Chart.js components
ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
);

export default {
  name: "TopSalesChart",
  components: {
    BarChart: Bar,
  },
  props: {
    transactions: {
      type: Array,
      default: () => [],
    },
    products: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      chartData: {
        labels: [],
        datasets: [
          {
            label: "Jumlah Terjual",
            data: [],
            backgroundColor: "rgba(54, 162, 235, 0.8)",
            borderRadius: 10,
          },
        ],
      },
      chartOptions: {
        indexAxis: "y",
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: (tooltipItem) => ` ${tooltipItem.formattedValue} pcs`,
            },
          },
        },
        scales: {
          x: {
            beginAtZero: true,
            title: {
              display: false,
              text: "Jumlah Produk Terjual",
            },
          },
          y: {
            ticks: {
              font: { size: 12 },
            },
          },
        },
      },
    };
  },
  watch: {
    transactions: {
      immediate: true,
      handler() {
        this.processTopSales();
      },
    },
  },
  methods: {
    processTopSales() {
      // Filter only sales transactions
      const salesTransactions = this.transactions.filter(
        (trans) => trans.jenis_transaksi === "Penjualan"
      );

      // Aggregate sales by product
      const productSales = salesTransactions.reduce((acc, transaction) => {
        const productId = transaction.product_id;
        acc[productId] = (acc[productId] || 0) + transaction.quantity;
        return acc;
      }, {});

      // Sort and get top 5 products
      const topProducts = Object.entries(productSales)
        .sort((a, b) => b[1] - a[1])
        .slice(0, 5);

      // Prepare chart data
      this.chartData.labels = topProducts.map(([productId]) => {
        const product = this.products.find(
          (p) => p.product_id === parseInt(productId)
        );
        return product ? product.product_name : `Produk ${productId}`;
      });

      this.chartData.datasets[0].data = topProducts.map(
        ([, quantity]) => quantity
      );
    },
  },
};
</script>
