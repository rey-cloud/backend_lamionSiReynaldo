<template>
    <div class="scrollbar-hide">
      <div class="flex items-center justify-center bg-gray-100">
        <div class="container px-4 mx-auto">
          <div class="flex items-center py-10">
            <div>
              <h1 class="text-3xl font-bold text-gray-800">Product List</h1>
            </div>
            <div class="flex justify-end grow">
              <nuxt-link to="/products/create" class="px-4 py-2 font-bold text-white transition-colors duration-300 ease-in-out bg-blue-500 rounded hover:bg-blue-700">Add Product</nuxt-link>
            </div>
          </div>
          <div v-if="state.products.length">
            <div v-for="product in state.products" :key="product.id" class="flex justify-between p-4 bg-white rounded-lg shadow-lg">
              <div>
                <img :src="product.photo" alt="Product Image" class="object-cover w-32 rounded max-h-16">
              </div>
              <div class="flex items-center w-full ml-4">
                <h2 class="flex-shrink-0 text-xl font-bold">{{ product.name }}</h2>
                <p class="flex-shrink-0 text-gray-600">{{ product.description }}</p>
                <div class="flex-shrink-0 text-gray-700">Quantity: {{ product.quantity }}</div>
                <div class="flex-shrink-0 text-gray-700">Price: ${{ product.price }}</div>
                <div class="flex items-center justify-end flex-shrink-0">
                  <button @click="updateProduct(product.id)" class="bg-[#fff019] hover:bg-[#fffab8] text-[#1B5D88] font-bold py-2 px-4 mx-1 rounded transition-colors duration-300 ease-in-out">Update</button>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="min-h-screen text-center text-gray-700 text-7xl">
            <p>Loading...</p>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { reactive, onMounted } from 'vue'
  import { useRouter } from 'vue-router'
  
  const router = useRouter()
  
  const state = reactive({
    products: [],
    errors: null
  })
  
  async function fetchProducts() {
    const params = {
      Authorization: "Bearer " + localStorage.getItem('_token'),
      Accept: "application/json"
    }
  
    try {
      const response = await $fetch('http://127.0.0.1:8000/api/products', {
        method: 'GET',
        headers: params
      })
  
      state.products = response.data
      console.log(response.data)
    } catch (error) {
      state.errors = error.response
      console.log(error.response)
      console.log('error', error)
  
      // Navigate to login page if not logged in
      router.push('/')
    }
  }
  
  onMounted(() => {
    fetchProducts()
  })
  </script>
  
