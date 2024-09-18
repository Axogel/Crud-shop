<template>
    <div class="container mt-4">
      <h1>{{ isEdit ? 'Edit Order' : 'Create Order' }}</h1>
      <form @submit.prevent="saveOrder">
        <!-- Select para seleccionar un usuario -->
        <div class="mb-3">
          <label for="user_id" class="form-label">User:</label>
          <select v-model="order.user_id" class="form-control" id="user_id" required>
            <option value="" disabled>Select User</option>
            <option v-for="user in users" :key="user.id" :value="user.id">
              {{ user.name }}
            </option>
          </select>
        </div>
  
        <div class="mb-3">
          <label for="amount" class="form-label">Amount:</label>
          <input v-model="order.amount" type="number" class="form-control" id="amount" required />
        </div>
  
        <!-- Select para seleccionar productos y definir la cantidad -->
        <div class="mb-3">
          <label class="form-label">Products:</label>
          <div v-for="(product, index) in order.products" :key="index" class="mb-2 d-flex align-items-center">
            <select v-model="product.id" class="form-control me-2" required>
              <option value="" disabled>Select Product</option>
              <option v-for="prod in products" :key="prod.id" :value="prod.id">
                {{ prod.name }} - ${{ prod.price }}
              </option>
            </select>
            <input v-model="product.quantity" type="number" class="form-control me-2" placeholder="Quantity" required />
            <button class="btn btn-danger" @click="removeProduct(index)">Remove</button>
          </div>
          <button class="btn btn-primary mt-2" @click="addProduct">Add Product</button>
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
    name: 'OrderForm',
    setup() {
      const route = useRoute();
      const router = useRouter();
      const isEdit = route.params.id !== undefined;
  
      const order = ref({
        user_id: '',
        amount: '',
        products: [{ id: '', quantity: 1 }]
      });
  
      const users = ref([]);
      const products = ref([]);
  
      onMounted(async () => {
        if (isEdit) {
          try {
            const response = await api.get(`/orders/${route.params.id}`);
            order.value = response.data;
          } catch (error) {
            console.error('Error fetching order:', error);
          }
        }
  
        try {
          const responseUsers = await api.get('/users');
          users.value = responseUsers.data;
        } catch (error) {
          console.error('Error fetching users:', error);
        }
  
        try {
          const responseProducts = await api.get('/products');
          products.value = responseProducts.data;
        } catch (error) {
          console.error('Error fetching products:', error);
        }
      });
  
      const saveOrder = async () => {
        try {
          if (isEdit) {
            await api.put(`/orders/${route.params.id}`, order.value);
          } else {
            await api.post('/orders', order.value);
          }
          router.push('/');
        } catch (error) {
          console.error('Error saving order:', error);
        }
      };
  
      const addProduct = () => {
        order.value.products.push({ id: '', quantity: 1 });
      };
  
      const removeProduct = (index) => {
        order.value.products.splice(index, 1);
      };
  
      return {
        order,
        saveOrder,
        addProduct,
        removeProduct,
        isEdit,
        users,
        products
      };
    }
  };
  </script>

  