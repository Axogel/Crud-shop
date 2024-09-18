<template>
    <div class="container mt-4">
      <h1 class="mb-4">User List</h1>
      <div class="mb-3">
        <button class="btn btn-primary" @click="showCreateUser">Create New User</button>
      </div>
      <div class="list-group">
        <div v-for="user in users" :key="user.id" class="list-group-item mb-3">
          <h5 class="mb-1">{{ user.name }}</h5>
          <p class="mb-1"><strong>Email:</strong> {{ user.email }}</p>
          <div class="mt-3">
            <button class="btn btn-warning me-2" @click="editUser(user.id)">Edit</button>
            <button class="btn btn-danger" @click="deleteUser(user.id)">Delete</button>
            <button class="btn btn-info mx-2" @click="showProducts(user.id)">Show Products</button>
          </div>
        </div>
      </div>
  
      <!-- Modal -->
      <div class="modal fade" id="productsModal" tabindex="-1" aria-labelledby="productsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="productsModalLabel">Products for User {{ selectedUser.name }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <ul class="list-group">
                <li v-for="product in products" :key="product.id" class="list-group-item">
                  {{ product.name }} - Quantity: {{ product.pivot.quantity }}
                </li>
              </ul>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
<script>
import api from '../../services/api';

export default {
  name: 'UserList',
  data() {
    return {
      users: [],
      selectedUser: {},
      products: [],
    };
  },
  created() {
    this.fetchUsers();
  },
  methods: {
    async fetchUsers() {
      try {
        const response = await api.get('/users');
        this.users = response.data;
      } catch (error) {
        console.error('Error fetching users:', error);
      }
    },
    async deleteUser(id) {
      try {
        await api.delete(`/users/${id}`);
        this.fetchUsers(); // Refresh the list
      } catch (error) {
        console.error('Error deleting user:', error);
      }
    },
    editUser(id) {
      this.$router.push(`/edit-user/${id}`);
    },
    showCreateUser() {
      this.$router.push('/create-user');
    },
    async showProducts(userId) {
      try {
        this.selectedUser = this.users.find(user => user.id === userId);
        const response = await api.get(`/users/${userId}/products`);
        this.products = response.data;
        // Show the modal
        const modal = new bootstrap.Modal(document.getElementById('productsModal'));
        modal.show();
      } catch (error) {
        console.error('Error fetching products:', error);
      }
    }
  }
};
</script>
