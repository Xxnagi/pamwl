<template>
  <div class="border-2 px-5 py-3 rounded-lg">
    <h3 class="text-lg font-bold">Total Pengeluaran</h3>
    <p class="text-2xl font-extrabold text-gray-800 mt-4">
      {{ formattedExpenses }}
    </p>
    <h5 class="text-lg font-semibold mt-4"></h5>
  </div>
</template>

<script>
export default {
  props: {
    expenses: {
      type: Number,
      required: true,
    },
  },
  computed: {
    formattedExpenses() {
      return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
      }).format(this.expenses.total_pembelian);
    },
  },
};
</script>
