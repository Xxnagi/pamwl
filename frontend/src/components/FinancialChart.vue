<template>
  <div class="rounded-lg border-2 w-full h-96 p-5">
    <div class="flex flex-col justify-between">
      <h2 class="text-xl font-semibold">Hasil Bersih</h2>
      <div class="font-semibold text-lg">
        <span
          :class="netIncomeClass"
          class="text-black font-extrabold text-2xl"
        >
          Rp {{ formatCurrency(totalNetIncome) }}
        </span>
      </div>
    </div>

    <Chart type="bar" :data="chartData" :options="chartOptions" />
  </div>
</template>

<script>
import Chart from "primevue/chart";
export default {
  name: "MonthlyFinancialChart",
  components: {
    Chart,
  },
  props: {
    transactions: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      totalNetIncome: 0,
      chartData: {
        labels: [],
        datasets: [
          {
            label: "Penghasilan",
            backgroundColor: "#42A5F5",
            data: [],
          },
          {
            label: "Pengeluaran",
            backgroundColor: "#FFA726",
            data: [],
          },
        ],
      },
      chartOptions: {
        responsive: true,
        plugins: {
          tooltip: {
            callbacks: {
              label: (context) => {
                return `Rp ${this.formatCurrency(context.parsed.y)}`;
              },
            },
          },
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: (value) => `Rp ${this.formatCurrency(value)}`,
            },
          },
        },
      },
    };
  },
  computed: {
    netIncomeClass() {
      return this.totalNetIncome >= 0 ? "text-green-600" : "text-red-600";
    },
  },
  methods: {
    formatCurrency(value) {
      return new Intl.NumberFormat("id-ID").format(value);
    },
    getMonthName(monthIndex) {
      const monthNames = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
      ];
      return monthNames[monthIndex];
    },
    calculateMonthlyFinancials() {
      // Get the last 5 months
      const monthLabels = [];
      const incomeData = [];
      const expenseData = [];
      let totalNetIncome = 0;

      for (let i = 4; i >= 0; i--) {
        // Create a date for the target month
        const targetDate = new Date();
        targetDate.setMonth(targetDate.getMonth() - i);

        // Get month and year
        const monthIndex = targetDate.getMonth();
        const year = targetDate.getFullYear();

        // Create start and end of month dates
        const monthStart = new Date(year, monthIndex, 1);
        const monthEnd = new Date(year, monthIndex + 1, 0);

        // Format month label
        monthLabels.push(this.getMonthName(monthIndex));

        // Filter transactions for this month
        const monthTransactions = this.transactions.filter((trans) => {
          const transDate = new Date(trans.transaction_date);
          return transDate >= monthStart && transDate <= monthEnd;
        });

        // Calculate income and expenses
        const monthIncome = monthTransactions
          .filter((trans) => trans.jenis_transaksi === "Penjualan")
          .reduce((sum, trans) => sum + trans.total, 0);

        const monthExpenses = monthTransactions
          .filter((trans) => trans.jenis_transaksi === "Pembelian")
          .reduce((sum, trans) => sum + trans.total, 0);

        incomeData.push(monthIncome);
        expenseData.push(monthExpenses);

        // Calculate net income
        totalNetIncome += monthIncome - monthExpenses;
      }

      // Update chart data
      this.chartData.labels = monthLabels;
      this.chartData.datasets[0].data = incomeData;
      this.chartData.datasets[1].data = expenseData;

      // Update total net income
      this.totalNetIncome = totalNetIncome;
    },
  },
  watch: {
    transactions: {
      immediate: true,
      handler() {
        this.calculateMonthlyFinancials();
      },
    },
  },
};
</script>
