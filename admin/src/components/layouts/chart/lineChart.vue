<template>
  <LineChart
    ref="chartRef"
    :chart-data="lineChartData"
    :options="lineChartOptions"
  />
</template>

<script setup>
import { LineChart } from "vue-chart-3";
import { Chart, registerables } from "chart.js";
import { appointmentStore } from "@/stores/appointmentStore";
import { computed, onMounted, ref } from "vue";
import { useAuthStore } from "@/stores/userAuthStore";
import router from "@/router";

const useAppointmentStore = appointmentStore();
const authStore = useAuthStore();
const labels = ref([]);
const datas = ref([]);
const chartRef = ref(null); // Reference to the chart component

// Register all necessary Chart.js components
Chart.register(...registerables);

// Fetch data on mount and update chart
onMounted(async () => {
  authStore.loadToken();
  if (!authStore.token) {
    return;
  }
  await useAppointmentStore.getAdminData();
  labels.value = useAppointmentStore.adminData.month_data;
  datas.value = useAppointmentStore.adminData.chart_data;

  // Manually update the chart after data is fetched
  if (chartRef.value && chartRef.value.chartInstance) {
    chartRef.value.chartInstance.update();
  }
});

// Computed property for line chart data
const lineChartData = computed(() => ({
  labels: labels.value,
  datasets: [
    {
      label: "Appointment Each Month",
      data: datas.value,
      borderColor: "#3667A4",
      backgroundColor: "rgba(54, 103, 164, 0.3)",
      tension: 0.4,
      pointBackgroundColor: "#64C1C5",
      pointBorderColor: "#102744",
      borderWidth: 2,
    },
  ],
}));

// Line chart options
const lineChartOptions = {
  responsive: true,
  plugins: {
    legend: {
      display: true,
      position: "top",
      labels: {
        boxWidth: 20,
        padding: 15,
        usePointStyle: true,
        pointStyle: "circle",
      },
    },
    tooltip: {
      backgroundColor: "#102744",
      titleColor: "#fff",
      bodyColor: "#f4d03f",
      padding: 10,
    },
  },
  scales: {
    x: {
      title: {
        display: true,
        text: "Months",
        color: "#3667A4",
        font: {
          size: 14,
        },
      },
    },
    y: {
      title: {
        display: true,
        text: "Booking",
        color: "#3667A4",
        font: {
          size: 14,
        },
      },
      ticks: {
        stepSize: 10,
        color: "#102744",
      },
    },
  },
};
</script>
