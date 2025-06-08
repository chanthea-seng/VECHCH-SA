<template>
  <div class="col-8 pe-4">
    <div class="chart-wrapper">
      <canvas ref="appointmentChart"></canvas>
    </div>
  </div>
  <div class="col-4">
    <div class="chart-wrapper">
      <canvas ref="genderChart"></canvas>
    </div>
  </div>
</template>

<script setup>
import { Chart, registerables } from "chart.js";
import { onMounted, ref } from "vue";
import { dashboardGeneralStore } from "@/stores/dashboardStore";
import { useAuthStore } from "@/stores/userAuthStore";
const useDashBoardStore = dashboardGeneralStore();
const authStore = useAuthStore();
Chart.register(...registerables);
const genderChart = ref(null);
const appointmentChart = ref(null);

const Utils = {
  months({ count }) {
    const monthNames = [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "May",
      "Jun",
      "Jul",
      "Aug",
      "Sep",
      "Oct",
      "Nov",
      "Dec",
    ];
    const today = new Date();
    const result = [];

    for (let i = 0; i < count; i++) {
      let monthIndex = (today.getMonth() - i + 12) % 12;
      result.unshift(monthNames[monthIndex]);
    }

    return result;
  },
};

onMounted(async () => {
  authStore.loadToken();
  if (!authStore.token) {
    return;
  }
  await useDashBoardStore.onLoadChartData();
  new Chart(genderChart.value, {
    type: "doughnut",
    data: {
      labels: ["Male", "Female"],
      datasets: [
        {
          data: [
            useDashBoardStore.chartdata.male_patient,
            useDashBoardStore.chartdata.female_patient,
          ],
          backgroundColor: ["rgba(0, 165, 191)", "rgb(18, 85, 103)"],
          borderColor: "rgba(0, 165, 191)",
          borderWidth: 1,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
    },
  });

  new Chart(appointmentChart.value, {
    type: "line",
    data: {
      labels: useDashBoardStore.chartdata.month_data,
      datasets: [
        {
          label: "Appointments",
          data: useDashBoardStore.chartdata.chart_data,
          fill: false,
          borderColor: "rgb(75, 192, 192)",
          tension: 0.1,
          pointStyle: "rectRounded",
        },
      ],
    },
    options: {
      fill: false,
      interaction: {
        intersect: false,
      },
      radius: 0,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1,
            precision: 0,
          },
          suggestedMin: 0,
          suggestedMax:
            Math.max(...useDashBoardStore.chartdata.chart_data) + 1 || 5, // Dynamic max based on data
        },
      },
    },
  });
});
</script>
