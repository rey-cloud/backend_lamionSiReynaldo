<template>
    <div class="flex items-center justify-center h-screen scrollbar-hide">
        <div class="flex items-center max-w-lg p-6 mx-auto space-x-4 bg-white shadow-md rounded-xl">
            <div class="flex flex-col">
                <label class="text-lg font-medium">Add Product</label>
                <input v-model="product.name" type="text" placeholder="Name" class="input border-2 border-gray-200 hover:border-[#1B5D88] p-2 rounded-lg mb-4" />
                <textarea v-model="product.description" placeholder="Description" class="input border-2 border-gray-200 hover:border-[#1B5D88] p-2 rounded-lg mb-4"></textarea>
            
                <div class="border-2 border-dashed border-gray-200 hover:border-[#1B5D88] p-5 cursor-pointer h-48 flex justify-center items-center overflow-hidden rounded-lg mb-4" @click="triggerFileInput" @dragover.prevent @dragenter.prevent @drop.prevent="handleDrop">
                    <template v-if="product.photo">
                        <img :src="product.photo" alt="Product Image" class="object-cover max-w-full max-h-full">
                    </template>
                    <template v-else>Drag and drop photo here or click to select</template>
                    <input type="file" @change="handleFileUpload" class="hidden" ref="fileInput">
                </div>
    
                <input v-model.number="product.quantity" type="number" placeholder="Quantity" class="input border-2 border-gray-200 hover:border-[#1B5D88] p-2 rounded-lg mb-4" />
                <input v-model.number="product.price" type="number" placeholder="Price" class="input border-2 border-gray-200 hover:border-[#1B5D88] p-2 rounded-lg mb-4" />
                <button @click="submitProduct" class="btn bg-[#0072BC] hover:bg-[#1B5D88] text-white p-2 rounded-lg">Submit Product</button>
                <nuxt-link to="../products"  class="bg-[#0072BC] hover:bg-[#1B5D88] text-white p-2 mt-3 rounded-lg flex justify-center">Go back</nuxt-link>
            </div>
        </div>
    </div>
</template>
  

<script>
export default {
    data() {
        return {
            product: {
            name: '',
            description: '',
            photo: '',
            quantity: '',
            price: '',
            },
        };
    },
methods: {
    triggerFileInput() {
      this.$refs.fileInput.click();
    },
    handleDrop(event) {
      const files = event.dataTransfer.files;
      if (files.length > 0) {
        this.readFile(files[0]);
      }
    },
    handleFileUpload() {
      const file = this.$refs.fileInput.files[0];
      if (file) {
        this.readFile(file);
      }
    },
    readFile(file) {
      if (!file.type.startsWith('image/')) {
        alert('Please upload an image file.');
        return;
      }
      const reader = new FileReader();
      reader.onload = (e) => {
        this.product.photo = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    submitProduct() {
      let products = JSON.parse(localStorage.getItem('products') || '[]');
      let newProduct = {
        ...this.product,
        id: Date.now()
      };
      products.push(newProduct);
      localStorage.setItem('products', JSON.stringify(products));
      console.log("Product added:", this.product);
      alert('Product added successfully!');
      this.resetForm();
    },
    resetForm() {
      this.product = { name: '', description: '', photo: '', quantity: '', price: '' };
    }
  },
};
</script>

<style scoped>
.hidden {
  display: none;
}
</style>