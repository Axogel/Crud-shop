<template>
    <div class="container mt-4">
      <h1 class="mb-4">Order List</h1>
      <div class="mb-3">
        <button class="btn btn-primary" @click="showCreateOrder">Create New Order</button>
      </div>
      <div class="list-group">
        <div v-for="order in orders" :key="order.id" class="list-group-item mb-3">
          <h5 class="mb-1">Order #{{ order.id }}</h5>
          <p class="mb-1"><strong>User:</strong> {{ order.user.name }}</p>
          <p class="mb-1"><strong>Amount:</strong> ${{ order.amount.toFixed(2) }}</p>
          <ul class="list-group">
            <li v-for="product in order.products" :key="product.id" class="list-group-item">
              {{ product.name }} - Quantity: {{ product.pivot.quantity }}
            </li>
          </ul>
          <div class="mt-3">
            <button class="btn btn-warning me-2" @click="editOrder(order.id)">Edit</button>
            <button class="btn btn-danger" @click="deleteOrder(order.id)">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </template>

<script>
import api from '../../services/api';

export default {
    name: 'OrderList',
    data() {
        return {
            orders: [],
        };
    },
    created() {
        this.fetchOrders();
    },
    methods: {
        async fetchOrders() {
            try {
                const response = await api.get('/orders');
                this.orders = response.data;
            } catch (error) {
                console.error('Error fetching orders:', error);
            }
        },
        async deleteOrder(id) {
            try {
                await api.delete(`/orders/${id}`);
                this.fetchOrders(); // Refresh the list
            } catch (error) {
                console.error('Error deleting order:', error);
            }
        },
        editOrder(id) {
            this.$router.push(`/edit-order/${id}`);
        },
        showCreateOrder() {
            this.$router.push('/create-order');
        }
    }
};
</script>
