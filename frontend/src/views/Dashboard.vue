<script>
import { onMounted, computed } from "vue";
import Availability from "../components/Availability.vue";
import TableProducts from "../components/TableProducts.vue";
import { useStore } from "vuex";
import TrendingUpGreen from "../components/icons/TrendingUpGreen.vue";
import SalesChart from "../components/SalesChart.vue";
import StatCard from "../components/StatCard.vue";

export default {
  components: {
    Availability,
    TableProducts,
    SalesChart,
    StatCard,
  },
  setup() {
    const store = useStore();
    const products = computed(() => store.state.products);
    const expenses = computed(() => store.state.expenses);
    const categories = computed(() => store.state.categories);

    onMounted(() => {
      store.dispatch("initializeAppData");
    });
    return {
      products,
      expenses,
      categories,
    };
  },
};
</script>

<template>
  <div class="flex-[1] overflow-auto p-4">
    <div class="flex">
      <div class="border-2 px-5 py-3 rounded-lg">
        <p class="font-bold text-lg">Penghasilan Kotor</p>
        <h1 class="font-extrabold text-2xl mt-5">Rp. 153.788.300.000</h1>
        <div class="flex mt-3">
          <TrendingUpGreen />
          <p><span class="text-green-400">+24%</span> dari bulan lalu</p>
        </div>
      </div>
      <StatCard :expenses="expenses" class="ml-5" />
      <Availability :items="products" class="ml-5" />
    </div>
    <div class="flex py-5">
      <SalesChart />
    </div>

    <TableProducts :products="products" :categories="categories" class="" />
  </div>
</template>
