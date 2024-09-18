<template>
    <div class="container mt-4">
      <h1 class="mb-4">List of Buyers</h1>
      <div v-if="buyers.length > 0" class="mt-4">
        <ul class="list-group">
          <li v-for="buyer in buyers" :key="buyer.id" class="list-group-item">
            <h5>{{ buyer.name }}</h5>
            <p><strong>Email:</strong> {{ buyer.email }}</p>
          </li>
        </ul>
      </div>
      <div v-else class="mt-4">
        <p>No buyers found.</p>
      </div>
    </div>
  </template>
  
  <script>
  import api from '../../services/api';
  import { ref, onMounted } from 'vue';
  
  export default {
    name: 'BuyerList',
    setup() {
      const buyers = ref([]);
  
      const fetchBuyers = async () => {
        try {
          const response = await api.get('/buyers');
          buyers.value = response.data;
        } catch (error) {
          console.error('Error fetching buyers:', error);
        }
      };
  
      onMounted(fetchBuyers);
  
      return {
        buyers
      };
    }
  };
  </script>
