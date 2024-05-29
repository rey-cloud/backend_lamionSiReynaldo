<template>
    <div v-if="editProduct">
      <form @submit.prevent="submitUpdate">
        <input v-model="editProduct.name" type="text" placeholder="Product Name" />
        <input v-model="editProduct.description" type="text" placeholder="Product Description" />
        <input v-model="editProduct.price" type="number" placeholder="Price" />
        <button type="submit">Save</button>
        <button @click="cancelUpdate">Cancel</button>
      </form>
    </div>
    <div v-else>
      <p>Loading product details...</p>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { useRoute, useRouter } from 'vue-router'
  
  const products = ref([])
  const editProduct = ref(null)
  const route = useRoute()
  const router = useRouter()
  
  onMounted(() => {
  products.value = JSON.parse(localStorage.getItem('products') || '[]');
  const productId = parseInt(route.params.id, 10);
  const product = products.value.find(p => p.id === productId);
  if (product) {
    editProduct.value = { ...product };
  } else {
    // It's a good idea to handle the case where no product matches the id
    console.error('Product not found!');
    router.push('/products'); // Redirect back or to an error page
  }
});
  
  function submitUpdate() {
    const index = products.value.findIndex(product => product.id === editProduct.value.id)
    if (index !== -1) {
      products.value[index] = { ...editProduct.value }
      localStorage.setItem('products', JSON.stringify(products.value))
      router.push('/products') // Redirect after update
    }
  }
  
  function cancelUpdate() {
    router.push('/products') // Redirect if canceling the update
  }
  </script>
  
  <style scoped>
  /* Style as needed */
  </style>
  