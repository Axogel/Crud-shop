<template>
    <div class="container mt-4">
      <h1 class="mb-4">Product List</h1>
      <div class="mb-3">
        <button class="btn btn-primary" @click="showCreateProduct">Create New Product</button>
      </div>
      <div class="list-group">
        <div v-for="product in products" :key="product.id" class="list-group-item mb-3">
          <h5 class="mb-1">{{ product.name }}</h5>
          <p class="mb-1"><strong>Description:</strong> {{ product.description }}</p>
          <p class="mb-1"><strong>Price:</strong> ${{ product.price }}</p>
          <div class="mt-3">
            <button class="btn btn-warning me-2" @click="editProduct(product.id)">Edit</button>
            <button class="btn btn-danger" @click="deleteProduct(product.id)">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import api from '../../services/api';
  
  export default {
    name: 'ProductList',
    data() {
      return {
        products: [],
      };
    },
    created() {
      this.fetchProducts();
    },
    methods: {
      async fetchProducts() {
        try {
          const response = await api.get('/products');
          console.log('la respuesta', response)
          this.products = response.data;
          console.log(this.products, 'yo te busco')
        } catch (error) {
          console.error('Error fetching products:', error);
        }
      },
      async deleteProduct(id) {
        try {
          await api.delete(`/products/${id}`);
          this.fetchProducts(); // Refresh the list
        } catch (error) {
          console.error('Error deleting product:', error);
        }
      },
      editProduct(id) {
        this.$router.push(`/edit-product/${id}`);
      },
      showCreateProduct() {
        this.$router.push('/create-product');
      }
    }
  };
  </script>

  