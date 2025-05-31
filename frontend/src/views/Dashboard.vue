<template>
  <div class="py-6 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
      <div class="mb-8 flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900 flex items-center">
          <svg class="w-8 h-8 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
          </svg>
          Pizza Sales Dashboard
        </h1>
        <span class="text-sm text-gray-500">{{ new Date().toLocaleDateString() }}</span>
      </div>
      
      <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-3">
        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 transform transition-all duration-200 hover:shadow-xl hover:-translate-y-1">
          <div class="p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0 p-3 bg-blue-50 rounded-full">
                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Total Revenue
                  </dt>
                  <dd class="mt-1 text-2xl font-semibold text-gray-900">
                    <div v-if="loading" class="animate-pulse h-7 w-24 bg-gray-200 rounded"></div>
                    <div v-else class="flex items-center">
                      ${{ formatNumber(dashboardData?.total_revenue?.total_revenue) }}
                      <span class="ml-2 text-sm font-medium text-green-600">+5.3%</span>
                    </div>
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 transform transition-all duration-200 hover:shadow-xl hover:-translate-y-1">
          <div class="p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0 p-3 bg-purple-50 rounded-full">
                <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Total Orders
                  </dt>
                  <dd class="mt-1 text-2xl font-semibold text-gray-900">
                    <div v-if="loading" class="animate-pulse h-7 w-16 bg-gray-200 rounded"></div>
                    <div v-else class="flex items-center">
                      {{ formatNumber(dashboardData?.total_revenue?.total_orders) }}
                      <span class="ml-2 text-sm font-medium text-green-600">+3.2%</span>
                    </div>
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 transform transition-all duration-200 hover:shadow-xl hover:-translate-y-1">
          <div class="p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0 p-3 bg-orange-50 rounded-full">
                <svg class="h-8 w-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">
                    Pizzas Sold
                  </dt>
                  <dd class="mt-1 text-2xl font-semibold text-gray-900">
                    <div v-if="loading" class="animate-pulse h-7 w-20 bg-gray-200 rounded"></div>
                    <div v-else class="flex items-center">
                      {{ formatNumber(dashboardData?.total_revenue?.total_pizzas) }}
                      <span class="ml-2 text-sm font-medium text-green-600">+7.1%</span>
                    </div>
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
          <div class="px-6 py-5">
            <h3 class="text-lg leading-6 font-semibold text-gray-900 flex items-center">
              <svg class="w-5 h-5 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
              </svg>
              Popular Pizzas
            </h3>
            <div class="mt-5">
              <div v-if="loading" class="space-y-4">
                <div v-for="i in 5" :key="i" class="animate-pulse flex items-center justify-between">
                  <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                  <div class="h-4 bg-gray-200 rounded w-16"></div>
                </div>
              </div>
              <div v-else class="flow-root">
                <ul role="list" class="divide-y divide-gray-200">
                  <li v-for="(pizza, index) in dashboardData?.popular_pizzas" :key="index" 
                      class="py-3 flex items-center justify-between hover:bg-gray-50 px-2 rounded-lg transition-colors">
                    <div class="flex items-center">
                      <span class="w-6 h-6 flex items-center justify-center rounded-full bg-orange-100 text-orange-600 text-xs font-medium">
                        {{ index + 1 }}
                      </span>
                      <p class="ml-3 text-sm font-medium text-gray-900">
                        {{ pizza.name }} <span class="text-gray-500 font-normal">({{ pizza.size }})</span>
                      </p>
                    </div>
                    <div class="text-sm font-semibold text-gray-900 bg-gray-100 py-1 px-3 rounded-full">
                      {{ formatNumber(pizza.total_quantity) }} sold
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Sales Chart -->
        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
          <div class="px-6 py-5">
            <h3 class="text-lg leading-6 font-semibold text-gray-900 flex items-center">
              <svg class="w-5 h-5 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
              </svg>
              Sales by Date
            </h3>
            <div class="mt-5">
              <SalesChart :data="dashboardData?.last_month_sales" :loading="loading" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
<script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import SalesChart from '@/components/SalesChart.vue';
  
  const loading = ref(true);
  const dashboardData = ref(null);
  
  const formatNumber = (num) => {
    return num ? num.toLocaleString() : 0;
  };
  
  const fetchDashboardData = async () => {
    try {
      const response = await axios.get('/api/dashboard');
      dashboardData.value = response.data;
    } catch (error) {
      console.error('Failed to fetch dashboard data:', error);
    } finally {
      loading.value = false;
    }
  };
  
  onMounted(fetchDashboardData);
</script>