<template>
    <div>
      <div v-if="loading" class="flex justify-center items-center h-64">
        <p>Loading chart data...</p>
      </div>
      <div v-else-if="!data || data.length === 0" class="flex justify-center items-center h-64">
        <p>No data available</p>
      </div>
      <canvas v-else ref="chartCanvas" class="h-64"></canvas>
    </div>
  </template>
  
<script setup>
  import { ref, onMounted, watch } from 'vue';
  import Chart from 'chart.js/auto';
  
  const props = defineProps({
    data: {
      type: Array,
      default: () => []
    },
    loading: {
      type: Boolean,
      default: false
    }
  });
  
  const chartCanvas = ref(null);
  let chart = null;
  
  const createChart = () => {
    if (!props.data || props.data.length === 0 || !chartCanvas.value) return;
    
    const ctx = chartCanvas.value.getContext('2d');
    
    const labels = props.data.map(item => item.date);
    const orderData = props.data.map(item => item.order_count);
    const revenueData = props.data.map(item => item.revenue);
    
    if (chart) {
      chart.destroy();
    }
    
    chart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Orders',
            data: orderData,
            backgroundColor: 'rgba(59, 130, 246, 0.2)',
            borderColor: 'rgba(59, 130, 246, 1)',
            borderWidth: 1,
            yAxisID: 'y'
          },
          {
            label: 'Revenue',
            data: revenueData,
            backgroundColor: 'rgba(16, 185, 129, 0.2)',
            borderColor: 'rgba(16, 185, 129, 1)',
            borderWidth: 1,
            yAxisID: 'y1'
          }
        ]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            position: 'left',
            title: {
              display: true,
              text: 'Order Count'
            }
          },
          y1: {
            position: 'right',
            grid: {
              drawOnChartArea: false,
            },
            title: {
              display: true,
              text: 'Revenue ($)'
            }
          }
        }
      }
    });
  };
  
  watch(() => props.data, createChart, { deep: true });
  watch(() => props.loading, (isLoading) => {
    if (!isLoading) {
      createChart();
    }
  });
  
  onMounted(() => {
    if (!props.loading) {
      createChart();
    }
  });
</script>