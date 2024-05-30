<template>
  <div class="w-1/2 p-6 bg-gray-800 rounded-lg ring-1 ring-gray-700">
    <div v-if="state.products" class="">
      <div class="flex justify-center">
        <!-- Adjust the width of the image -->
        <img :src="state.products.photo" alt="Product Photo" class="w-6/7 h-5/6" />
      </div>
      <div class="my-3 text-4xl text-gray-100 ">{{ state.products.name }}</div>
      <div class="my-3 text-lg text-gray-400">{{ state.products.description }}</div>
      <div class="my-3 text-xl text-gray-100">Quantity: {{ state.products.quantity }}</div>
      <div class="my-3 text-xl text-gray-100">Price: {{ state.products.price }}</div>
      <div class="mt-auto mb-3">
        <button class="w-full px-2 py-2 font-bold text-gray-100 transition-colors duration-300 ease-in-out bg-indigo-600 rounded hover:bg-indigo-500 hover:text-gray-100">Update</button>
      </div>
    </div>
    <div v-else>
      <p>Loading product details...</p>
    </div>
  </div>
</template>


<script setup>
  import { reactive, onMounted } from 'vue'
  import { useRouter } from 'vue-router'

  const router = useRouter()

  const state = reactive({
    id: null,
    products: null,
    errors: null
  })

  async function fetchProductDetails(id) {
    const params = {
      Authorization: "Bearer " + localStorage.getItem('_token'),
      Accept: "application/json"
    }

    try {
      const response = await $fetch(`http://127.0.0.1:8000/api/products/${id}`, {
        headers: params
      })

      state.products = response.data
    } catch (error) {
      state.errors = error.response
      console.error('Error:', error)

      // Navigate to login page if not logged in
      router.push('/')
    }
  }

  onMounted(() => {
    state.id = router.currentRoute.value.params.id
    fetchProductDetails(state.id);
  })
</script>
