<template>
    <div class="flex items-center justify-center my-10 scrollbar-hide">
      <div class="flex items-center max-w-lg p-6 mx-auto space-x-4 bg-gray-800 shadow-md ring-1 shadow-gray-700 ring-gray-700 rounded-xl">
        <div class="flex flex-col">
          <label class="self-center pb-6 text-lg font-medium text-gray-100">Add Product</label>
          <input type="text" placeholder="Name" class="p-2 mb-4 border-2 border-gray-200 rounded-lg textb input hover:border-gray-700" v-model="state.data.name" />
          <textarea placeholder="Description" class="p-2 mb-4 border-2 border-gray-200 rounded-lg input hover:border-gray-700" v-model="state.data.description"></textarea>
          <input type="number" placeholder="Quantity" class="p-2 mb-4 border-2 border-gray-200 rounded-lg input hover:border-gray-700" v-model="state.data.quantity" />
          <input type="number" placeholder="Price" class="p-2 mb-4 border-2 border-gray-200 rounded-lg input hover:border-gray-700" v-model="state.data.price" />
          <button @click="handleSubmit" class="btn bg-[#0072BC] hover:bg-[#1B5D88] text-white p-2 rounded-lg">Submit Product</button>
          <nuxt-link to="../products" class="bg-[#0072BC] hover:bg-[#1B5D88] text-white p-2 mt-3 rounded-lg flex justify-center">Go back</nuxt-link>
        </div>
      </div>
    </div>
  </template>
<script setup>
  import { reactive } from 'vue'
  import { useRouter } from 'vue-router'

  const router = useRouter()

  const state = reactive({
    errors: null,
    data: {
      name: null,
      description: null,
      quantity: null,
      price: null
    }
  })

  async function handleSubmit() {
    try {
      const response = await fetch('http://127.0.0.1:8000/api/products', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          Authorization: "Bearer " + localStorage.getItem('_token')
        },
        body: JSON.stringify(state.data)
      })

      if (!response.ok) {
        throw new Error('Failed to create product')
      }

      // Assuming successful creation, you can handle response accordingly
      alert("Product successfully created!")
      console.log('Product created:', response.data)

      // Clear the form data
      state.data.name = null
      state.data.description = null
      state.data.quantity = null
      state.data.price = null

    } catch (error) {
      state.errors = error.message
      console.error('Error creating product:', error)
    }
  }
</script>


