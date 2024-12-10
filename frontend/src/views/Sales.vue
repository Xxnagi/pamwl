<template>
  <TransactionTable :items="sales" :dataType="'sales'" />
</template>

<script>
import { useStore } from "vuex";
import { ref, onMounted, computed } from "vue";
import TransactionTable from "../components/TransactionTable.vue";

export default {
  components: {
    TransactionTable,
  },
  setup() {
    const store = useStore();
    const sales = computed(() => store.state.sales);
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
      sales,
      formatCurrency,
    };
  },
};
</script>
