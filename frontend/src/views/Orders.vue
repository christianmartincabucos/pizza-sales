<template>
  <div class="py-6 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 flex items-center">
          <svg class="w-7 h-7 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
          </svg>
          Order Management
        </h1>
        <div class="mt-4 sm:mt-0">
          <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
            </svg>
            Last updated: {{ new Date().toLocaleTimeString() }}
          </span>
        </div>
      </div>
      
      <!-- Filter Section -->
      <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6 transition-all duration-200 hover:shadow-md">
        <div class="px-4 py-5 sm:p-6">
          <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
              <h2 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
                </svg>
                Filter Orders
              </h2>
            </div>
            <div class="mt-4 md:mt-0 md:ml-4">
              <div class="flex flex-col sm:flex-row sm:items-center space-y-3 sm:space-y-0 sm:space-x-3">
                <div class="flex items-center space-x-2">
                  <label for="start-date" class="block text-sm font-medium text-gray-700">From</label>
                  <div class="relative rounded-md shadow-sm">
                    <input 
                      type="date" 
                      id="start-date"
                      v-model="filters.startDate"
                      class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                    />
                  </div>
                </div>
                <div class="flex items-center space-x-2">
                  <label for="end-date" class="block text-sm font-medium text-gray-700">To</label>
                  <div class="relative rounded-md shadow-sm">
                    <input 
                      type="date"
                      id="end-date" 
                      v-model="filters.endDate"
                      class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                    />
                  </div>
                </div>
                <button
                  @click="fetchOrders()"
                  class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200"
                >
                  <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                  </svg>
                  Apply Filter
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 mb-6">
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Total Orders</dt>
                  <dd class="flex items-baseline">
                    <div class="text-2xl font-semibold text-gray-900">{{ pagination.total || 0 }}</div>
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Avg. Order Value</dt>
                  <dd class="flex items-baseline">
                  <div class="text-2xl font-semibold text-gray-900">${{ averageOrderValue }}</div>
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-orange-500 rounded-md p-3">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Orders by Time</dt>
                  <dd class="flex items-baseline">
                    <div class="text-2xl font-semibold text-gray-900">Peak Hours</div>
                  </dd>
                  <dd class="flex flex-col mt-1">
                    <span class="text-sm text-gray-600">Lunch: 12:00 - 14:00</span>
                    <span class="text-sm text-gray-600">Dinner: 18:00 - 20:00</span>
                  </dd>
                </dl>
              </div>
            </div>
            <div class="mt-4 flex items-end justify-between h-8 px-2">
              <div class="h-3 w-6 bg-orange-300 rounded-t"></div>
              <div class="h-4 w-6 bg-orange-400 rounded-t"></div>
              <div class="h-6 w-6 bg-orange-500 rounded-t"></div>
              <div class="h-8 w-6 bg-orange-600 rounded-t"></div>
              <div class="h-5 w-6 bg-orange-500 rounded-t"></div>
              <div class="h-7 w-6 bg-orange-600 rounded-t"></div>
              <div class="h-8 w-6 bg-orange-700 rounded-t"></div>
              <div class="h-4 w-6 bg-orange-500 rounded-t"></div>
              <div class="h-3 w-6 bg-orange-400 rounded-t"></div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
          <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z" clip-rule="evenodd"></path>
            </svg>
            Orders List
          </h3>
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
            Showing {{ orders.length }} of {{ pagination.total || 0 }} orders
          </span>
        </div>
        <div class="border-t border-gray-200">
          <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
              <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Order ID
                      </th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date
                      </th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Time
                      </th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Items
                      </th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-if="loading">
                      <td colspan="5" class="px-6 py-12">
                        <div class="flex flex-col items-center justify-center">
                          <svg class="animate-spin h-8 w-8 text-indigo-500 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                          </svg>
                          <span class="text-sm text-gray-500">Loading orders...</span>
                        </div>
                      </td>
                    </tr>
                    <tr v-else-if="orders.length === 0">
                      <td colspan="5" class="px-6 py-12">
                        <div class="flex flex-col items-center justify-center">
                          <svg class="h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                          </svg>
                          <span class="text-sm text-gray-500">No orders found for the selected period.</span>
                          <button 
                            @click="resetFilters"
                            class="mt-3 inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                          >
                            Clear Filters
                          </button>
                        </div>
                      </td>
                    </tr>
                    <tr v-for="order in orders" :key="order.id" class="hover:bg-gray-50 transition-colors duration-150">
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                          <div class="flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-700">
                            #{{ order.id }}
                          </div>
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ formatDate(order.date) }}</div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ formatTime(order.time) }}</div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                          {{ order.details ? order.details.length : 0 }} items
                        </span>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button 
                          @click="viewOrderDetails(order)"
                          class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                          <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                          </svg>
                          View
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="mt-6 flex justify-between items-center">
        <div class="text-sm text-gray-700 hidden sm:block">
          Total <span class="font-medium">{{ pagination.total || 0 }}</span> orders
        </div>
        <div class="flex-1 flex justify-between sm:justify-end space-x-3">
          <button
            @click="goToPrevPage"
            :disabled="pagination.prev_cursor <= 1"
            :class="[
              pagination.prev_cursor <= 1 ? 'opacity-50 cursor-not-allowed' : '',
              'inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50'
            ]"
          >
            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Previous
          </button>
          <button
            @click="goToNextPage"
            :disabled="!pagination.next_cursor"
            :class="[
              !pagination.next_cursor ? 'opacity-50 cursor-not-allowed' : '',
              'inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50'
            ]"
          >
            Next
            <svg class="h-4 w-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </button>
        </div>
      </div>
      
    </div>
  </div>
  
  <div v-if="selectedOrder" class="fixed top-0 left-0 z-20 flex items-center justify-center w-screen h-screen bg-slate-300/20 backdrop-blur-sm" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 bg-opacity-75 transition-opacity" 
      aria-hidden="true" @click="selectedOrder = null"></div>
      
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
      
      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
        <!-- Header with pizza illustration -->
        <div class="bg-gradient-to-r from-orange-500 to-red-600 px-4 py-3 flex justify-between items-center">
          <h3 class="text-lg leading-6 font-bold text-white flex items-center" id="modal-title">
            <div class="flex-shrink-0 mr-2 h-9 w-9 flex items-center justify-center rounded-full bg-white text-red-600 font-bold">
              #{{ selectedOrder.id }}
            </div>
            <div>
              <span>Order Details</span>
              <span class="block text-xs text-white opacity-90 font-normal">
                {{ formatDate(selectedOrder.date) }} at {{ formatTime(selectedOrder.time) }}
              </span>
            </div>
          </h3>
          <button @click="selectedOrder = null" class="rounded-md text-white hover:text-gray-200 focus:outline-none">
            <span class="sr-only">Close</span>
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <!-- Order Summary -->
          <div class="bg-gray-50 p-4 rounded-lg mb-5 border-l-4 border-orange-500">
            <div class="flex justify-between items-center">
              <div>
                <span class="text-sm text-gray-500">Order Status</span>
                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                  Completed
                </span>
              </div>
              <div>
                <span class="text-sm text-gray-500">Order Type</span>
                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                  Delivery
                </span>
              </div>
            </div>
          </div>
          
          <div class="mb-5">
            <div class="mb-5 max-h-[50vh] overflow-hidden">
              <h4 class="text-sm font-semibold text-gray-900 flex items-center mb-3 sticky top-0 bg-white">
                <svg class="w-4 h-4 mr-1 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 2a6 6 0 100 12 6 6 0 000-12z"></path>
                </svg>
                Pizza Items ({{ selectedOrder.details?.length || 0 }})
              </h4>
              
              <ul class="divide-y divide-gray-200 max-h-[50vh] overflow-y-auto bg-white rounded-lg border border-gray-200 pr-1 scroll-smooth">
                <li v-for="(item, index) in selectedOrder.details" :key="index" 
                    class="py-3 px-4 hover:bg-gray-50 transition-colors flex justify-between">
                  <div class="flex-1 pr-4">
                    <div class="flex items-start">
                      <div class="h-10 w-10 flex-shrink-0 bg-orange-100 rounded-full flex items-center justify-center text-orange-600">
                        <span class="text-xs font-semibold">{{ item.pizza?.size || 'N/A' }}</span>
                      </div>
                      <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">
                          {{ item.pizza?.pizza_type?.name || 'Unknown Pizza' }}
                        </p>
                        <p class="text-xs text-gray-500 mt-0.5 italic line-clamp-2">
                          {{ item.pizza?.pizza_type?.ingredients || 'No ingredients information' }}
                        </p>
                        <span class="inline-flex mt-1 items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                          {{ item.pizza?.pizza_type?.category || 'N/A' }}
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="text-right flex flex-col justify-between">
                    <div>
                      <p class="text-sm font-medium text-gray-900">
                        x{{ item.quantity }} 
                      </p>
                      <p class="text-xs text-gray-500">
                        ${{ item.pizza?.price || 0 }} each
                      </p>
                    </div>
                    <p class="text-sm font-semibold text-green-600">
                      ${{ (item.quantity * (item.pizza?.price || 0)).toFixed(2) }}
                    </p>
                  </div>
                </li>
                <li v-if="!selectedOrder.details?.length" class="py-4 px-4 text-center text-sm text-gray-500">
                  No items found for this order
                </li>
              </ul>
            </div>
          </div>
          
          <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <div class="flex justify-between items-center">
              <p class="text-sm font-medium text-gray-900">Subtotal</p>
              <p class="text-sm font-medium text-gray-900">
                ${{ calculateOrderTotal(selectedOrder).toFixed(2) }}
              </p>
            </div>
            <div class="flex justify-between items-center mt-2">
              <p class="text-xs text-gray-500">Tax (8%)</p>
              <p class="text-xs text-gray-500">
                ${{ (calculateOrderTotal(selectedOrder) * 0.08).toFixed(2) }}
              </p>
            </div>
            <div class="flex justify-between items-center mt-2 text-xs text-gray-500">
              <p>Delivery Fee</p>
              <p>$3.99</p>
            </div>
            <div class="border-t border-gray-200 mt-3 pt-3 flex justify-between items-center">
              <p class="text-base font-bold text-gray-900">Total</p>
              <p class="text-base font-bold text-gray-900">
                ${{ (calculateOrderTotal(selectedOrder) * 1.08 + 3.99).toFixed(2) }}
              </p>
            </div>
          </div>
          
          <div class="mt-5 flex justify-center">
            <div class="text-center">
              <p class="text-xs text-gray-500 mb-1">Order Tracking Code</p>
              <div class="bg-gray-100 px-4 py-2 rounded font-mono text-sm">
                PZA-{{ selectedOrder.id.toString().padStart(5, '0') }}
              </div>
            </div>
          </div>
        </div>
        
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button 
            type="button" 
            @click="selectedOrder = null"
            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
          >
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
  
<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

const orders = ref([]);
const loading = ref(true);
const selectedOrder = ref(null);
const filters = ref({
  startDate: '',
  endDate: '',
});

const pagination = ref({
  next_cursor: null,
  prev_cursor: null,
  total: 0,
  has_more: false
});
const limit = 20;

const cachedOrders = ref({});
const cursorHistory = ref([]);
const currentCursorIndex = ref(0);

const totalOrderValue = ref(0);
const ordersWithDetailsCount = ref(0);

const viewOrderDetails = async (order) => {
  if (order.details) {
    selectedOrder.value = order;
    return;
  }
  
  try {
    const response = await axios.get(`/api/orders/${order.id}`);
    const orderWithDetails = response.data;
    
    const index = orders.value.findIndex(o => o.id === order.id);
    if (index !== -1) {
      orders.value[index] = orderWithDetails;
      
      const orderTotal = calculateOrderTotal(orderWithDetails);
      totalOrderValue.value += orderTotal;
      ordersWithDetailsCount.value++;
    }
    
    selectedOrder.value = orderWithDetails;
  } catch (error) {
    console.error('Failed to fetch order details:', error);
  }
};

const averageOrderValue = computed(() => {
  if (ordersWithDetailsCount.value === 0) {
    return '18.50';
  }
  
  return (totalOrderValue.value / ordersWithDetailsCount.value).toFixed(2);
});

const fetchOrderStatistics = async () => {
  try {
    const response = await axios.get('/api/orders/statistics', { 
      params: {
        start_date: filters.value.startDate || undefined,
        end_date: filters.value.endDate || undefined
      }
    });
    
    if (response.data && response.data.average_order_value) {
      totalOrderValue.value = response.data.total_order_value || 0;
      ordersWithDetailsCount.value = response.data.orders_count || 0;
    }
  } catch (error) {
    console.error('Failed to fetch order statistics:', error);
  }
};

const fetchOrders = async (cursor = null, direction = 'next', forceReload = false) => {
  loading.value = true;
  
  if (!forceReload && cursor !== null && cachedOrders.value[cursor]) {
    console.log('Using cached data for cursor:', cursor);
    orders.value = cachedOrders.value[cursor].data;
    
    pagination.value = {
      next_cursor: cachedOrders.value[cursor].next_cursor,
      prev_cursor: cachedOrders.value[cursor].prev_cursor,
      total: cachedOrders.value[cursor].total,
      has_more: cachedOrders.value[cursor].has_more,
      current_page: cachedOrders.value[cursor].current_page || null,
      total_pages: cachedOrders.value[cursor].total_pages || Math.ceil(cachedOrders.value[cursor].total / limit)
    };
    
    if (direction === 'next' && !cursorHistory.value.includes(cursor)) {
      cursorHistory.value.push(cursor);
      currentCursorIndex.value = cursorHistory.value.length - 1;
    } else if (direction === 'prev') {
      const index = cursorHistory.value.indexOf(cursor);
      if (index !== -1) {
        currentCursorIndex.value = index;
      }
    }
    
    loading.value = false;
    return;
  }
  
  try {
    const params = {
      limit: limit
    };
    
    if (cursor) {
      params.cursor = cursor;
      params.direction = direction;
    }
    
    if (filters.value.startDate) {
      params.start_date = filters.value.startDate;
    }
    
    if (filters.value.endDate) {
      params.end_date = filters.value.endDate;
    }
    
    const response = await axios.get('/api/orders', { params });
    
    cachedOrders.value[cursor || 'initial'] = {
      data: response.data.data,
      next_cursor: response.data.next_cursor,
      prev_cursor: response.data.prev_cursor,
      total: response.data.total,
      has_more: response.data.has_more,
      current_page: response.data.current_page,
      total_pages: response.data.total_pages
    };
    
    if ((direction === 'next' || cursor === null) && 
        !cursorHistory.value.includes(cursor || 'initial')) {
      cursorHistory.value.push(cursor || 'initial');
      currentCursorIndex.value = cursorHistory.value.length - 1;
    }
    
    orders.value = response.data.data;
    
    pagination.value = {
      next_cursor: response.data.next_cursor,
      prev_cursor: response.data.prev_cursor,
      total: response.data.total,
      has_more: response.data.has_more,
      current_page: response.data.current_page || null,
      total_pages: response.data.total_pages || Math.ceil(response.data.total / limit)
    };
    
  } catch (error) {
    console.error('Failed to fetch orders:', error);
  } finally {
    loading.value = false;
  }
};

const goToNextPage = () => {
  if (pagination.value.next_cursor) {
    fetchOrders(pagination.value.next_cursor, 'next');
  }
};

const goToPrevPage = () => {
  // First check if we have previous data in our history
  if (currentCursorIndex.value > 0) {
    // Use cached data from history
    const prevCursor = cursorHistory.value[currentCursorIndex.value - 1];
    currentCursorIndex.value--;
    
    if (cachedOrders.value[prevCursor]) {
      // We have this data cached, use it
      orders.value = cachedOrders.value[prevCursor].data;
      pagination.value = {
        next_cursor: cachedOrders.value[prevCursor].next_cursor,
        prev_cursor: cachedOrders.value[prevCursor].prev_cursor,
        total: cachedOrders.value[prevCursor].total,
        has_more: cachedOrders.value[prevCursor].has_more,
        current_page: cachedOrders.value[prevCursor].current_page,
        total_pages: cachedOrders.value[prevCursor].total_pages
      };
      return;
    }
  }
  
  // If we don't have cached data or we're at the start of history, make an API call
  if (pagination.value.prev_cursor) {
    fetchOrders(pagination.value.prev_cursor, 'prev');
  }
};

const resetFilters = () => {
  filters.value = {
    startDate: '',
    endDate: '',
  };
  
  cachedOrders.value = {};
  cursorHistory.value = [];
  currentCursorIndex.value = 0;
  
  fetchOrders(null, 'next', true);
};

const formatDate = (dateString) => {
  if (!dateString) return 'N/A';
  const date = new Date(dateString);
  return date.toLocaleDateString();
};

const formatTime = (timeString) => {
  if (!timeString) return 'N/A';
  return timeString;
};

const calculateOrderTotal = (order) => {
  if (!order.details || !order.details.length) return 0;
  
  return order.details.reduce((total, item) => {
    const price = item.pizza?.price || 0;
    return total + (price * item.quantity);
  }, 0);
};

onMounted(() => {
  fetchOrders();
  fetchOrderStatistics();
});
</script>