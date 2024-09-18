<template>
    <div class="container mt-4">
      <h1>{{ isEdit ? 'Edit Product' : 'Create Product' }}</h1>
      <form @submit.prevent="saveProduct">
        <div class="mb-3">
          <label for="name" class="form-label">Name:</label>
          <input v-model="product.name" type="text" class="form-control" id="name" required />
        </div>
        <div class="mb-3">
          <label for="description" class="form-label">Description:</label>
          <textarea v-model="product.description" class="form-control" id="description" required></textarea>
        </div>
        <div class="mb-3">
          <label for="price" class="form-label">Price:</label>
          <input v-model="product.price" type="number" step="0.01" class="form-control" id="price" required />
        </div>
        <button type="submit" class="btn btn-success">Save</button>
      </form>
    </div>
  </template>
  
  <script>
  import api from '../../services/api';
  import { ref, onMounted } from 'vue';
  import { useRoute, useRouter } from 'vue-router';
  
  export default {
    name: 'ProductForm',
    setup() {
      const route = useRoute();
      const router = useRouter();
      const isEdit = route.params.id !== undefined;
      const product = ref({
        name: '',
        description: '',
        price: ''
      });
  
      onMounted(async () => {
        if (isEdit) {
          try {
            const response = await api.get(`/products/${route.params.id}`);
            product.value = response.data;
          } catch (error) {
            console.error('Error fetching product:', error);
          }
        }
      });
  
      const saveProduct = async () => {
        try {
          if (isEdit) {
            await api.put(`/products/${route.params.id}`, product.value);
          } else {
            await api.post('/products', product.value);
          }
          router.push('/products');
        } catch (error) {
          console.error('Error saving product:', error);
        }
      };
  
      return {
        product,
        saveProduct,
        isEdit
      };
    }
  };
  </script>

  