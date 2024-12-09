<template>
  <div class="rounded-lg border-2 w-1/2 p-5">
    <p class="font-bold text-lg">Laporan Penjualan</p>
    <BarChart :data="chartData" :options="chartOptions" />
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
  name: "SalesChart",
  components: {
    BarChart: Bar,
  },
  data() {
    return {
      chartData: {
        labels: [
          "Red Velvet",
          "Corn",
          "Blueberry",
          "Original",
          "Banana",
          "Strawberry",
        ],
        datasets: [
          {
            label: "Sales",
            data: [48, 112, 66, 149, 93, 78], // Data values
            backgroundColor: "rgba(54, 162, 235, 0.8)", // Bar color
            borderRadius: 10, // Rounded bar corners
          },
        ],
      },
      chartOptions: {
        indexAxis: "y", // Horizontal bar chart
        responsive: true,
        plugins: {
          legend: { display: false }, // Hide legend
          tooltip: {
            callbacks: {
              label: (tooltipItem) => ` ${tooltipItem.raw}`, // Customize tooltip text
            },
          },
        },
        scales: {
          x: { beginAtZero: true }, // Start x-axis at 0
          y: { ticks: { font: { size: 14 } } }, // Y-axis label styles
        },
      },
    };
  },
};
</script>
