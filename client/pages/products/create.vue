<template>
  <div class="flex items-center justify-center my-10 scrollbar-hide">
    <div class="flex items-center max-w-lg p-6 mx-auto space-x-4 bg-gray-800 shadow-md ring-1 shadow-gray-700 ring-gray-700 rounded-xl">
      <div class="flex flex-col">
        <label class="self-center pb-6 text-lg font-medium text-gray-100">Add Product</label>
        <input type="text" placeholder="Name" class="p-2 mb-4 border-2 border-gray-200 rounded-lg textb input hover:border-gray-700" v-model="state.data.name" />
        <textarea placeholder="Description" class="p-2 mb-4 border-2 border-gray-200 rounded-lg input hover:border-gray-700" v-model="state.data.description"></textarea>
        <input type="number" placeholder="Quantity" class="p-2 mb-4 border-2 border-gray-200 rounded-lg input hover:border-gray-700" v-model="state.data.quantity" />
        <input type="number" placeholder="Price" class="p-2 mb-4 border-2 border-gray-200 rounded-lg input hover:border-gray-700" v-model="state.data.price" />

        <!-- Integration of file upload -->
        <form @submit.prevent="handleFormSubmit">
          <input
            type="file"
            multiple
            @change="handleFileChange"
            class="p-2 mb-4 border-2 border-gray-200 rounded-lg input hover:border-gray-700"
          />
          <button type="submit" class="btn bg-[#0072BC] hover:bg-[#1B5D88] text-white p-2 rounded-lg">Submit Product</button>
        </form>
        <!-- End of file upload integration -->

        <nuxt-link to="../products" class="bg-[#0072BC] hover:bg-[#1B5D88] text-white p-2 mt-3 rounded-lg flex justify-center">Go back</nuxt-link>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'

const files = ref<FileList | null>(null)
const uploadedFilePaths = ref<string[]>([])

function handleFileChange(e: Event) {
  files.value = (e.target as HTMLInputElement).files
}

async function handleFormSubmit() {
  await handleFileSubmit()
  await handleSubmit()
}

async function handleFileSubmit() {
  const fd = new FormData()

  if (files.value) {
    Array.from(files.value).forEach((file: File, index: number) => {
      fd.append(`file${index}`, file)
    })
  }
  const data = await fetch('/api/file', {
    method: 'POST',
    body: fd
  }).then(res => res.json())
  uploadedFilePaths.value = data
}

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

    alert("Product successfully created!")
    console.log('Product created:', await response.json())

    state.data.name = null
    state.data.description = null
    state.data.quantity = null
    state.data.price = null

  } catch (error: any) {
    state.errors = error.message
    console.error('Error creating product:', error)
  }
}

</script>

<style scoped lang="css"></style>