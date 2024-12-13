<template>
  <div class="flex-[1] overflow-auto">
    <div class="flex gap-6 min-w-max p-8">
      <StatCard :data="sales" :type="'sales'" class="flex-1" />
      <StatCard :data="purchases" :type="'purchase'" class="flex-1" />
      <Availability :items="products" class="flex-1" />
    </div>

    <!-- Add p-8 to the Tabs container to match the padding -->
    <Tabs value="0">
      <TabList>
        <Tab value="0">Stock</Tab>
        <Tab value="1">Sales</Tab>
      </TabList>
      <TabPanels class="m-0">
        <TabPanel value="0">
          <TransactionTable :transactions="transactions" :products="products" />
        </TabPanel>

        <TabPanel value="1">
          <TableProducts :products="products" :categories="categories" />
        </TabPanel>
      </TabPanels>
    </Tabs>
  </div>
</template>

<script>
import { onMounted, computed } from "vue";
import { useStore } from "vuex";

import Tabs from "primevue/tabs";
import TabList from "primevue/tablist";
import Tab from "primevue/tab";
import TabPanels from "primevue/tabpanels";
import TabPanel from "primevue/tabpanel";

import Availability from "../components/Availability.vue";
import TableProducts from "../components/TableProducts.vue";
import TransactionTable from "../components/TransactionTable.vue";
import SalesChart from "../components/SalesChart.vue";
import StatCard from "../components/StatCard.vue";

export default {
  components: {
    Availability,
    TableProducts,
    TransactionTable,
    SalesChart,
    StatCard,
    // PrimeVue Components
    Tabs,
    TabPanel,
    Tab,
    TabList,
    TabPanels,
  },
  setup() {
    const store = useStore();
    const products = computed(() => store.state.products);
    const sales = computed(() => store.state.sales);
    const purchases = computed(() => store.state.purchases);
    const categories = computed(() => store.state.categories);
    const transactions = computed(() => store.state.transactions);

    onMounted(() => {
      store.dispatch("initializeAppData");
    });

    return {
      products,
      purchases,
      sales,
      categories,
      transactions,
    };
  },
};
</script>
<style scoped>
:deep(.p-tablist) {
  color: #3b82f6;
  padding-left: 32px;
}

:deep(.p-tabs .p-tablist-active-bar) {
  background-color: #3b82f6;
}

:deep(.p-tab-active) {
  color: #3b82f6;
}
</style>
