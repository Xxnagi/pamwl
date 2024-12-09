<script setup>
import { RouterLink } from "vue-router"; // Import RouterLink for navigation
import FileText from "../components/icons/FileText.vue";
import Grid from "../components/icons/Grid.vue";
import Package from "../components/icons/Package.vue";
import PieChart from "../components/icons/PieChart.vue";
import TrendingUp from "../components/icons/TrendingUp.vue";
</script>

<template>
  <div class="flex-[0_0_auto] text-xl pl-5 pr-20 pt-16 border-r-2">
    <!-- Dashboard Link -->
    <RouterLink to="/" class="flex items-center">
      <Grid />
      <p class="ml-3">Dashboard</p>
    </RouterLink>

    <!-- Stock Link -->
    <RouterLink to="/stock" class="flex mt-8 items-center">
      <Package />
      <p class="ml-3">Stock</p>
    </RouterLink>

    <RouterLink to="/sales" class="flex mt-8 items-center">
      <TrendingUp />
      <p class="ml-3">Sales</p>
    </RouterLink>

    <!-- <RouterLink to="/purchase" class="flex mt-8 items-center">
      <FileText />
      <p class="ml-3">Purchase</p>
    </RouterLink>


    <RouterLink to="/report" class="flex mt-8 items-center">
      <PieChart />
      <p class="ml-3">Report</p>
    </RouterLink> -->
  </div>
</template>
