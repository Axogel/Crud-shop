<template>
    <div class="container mt-4">
      <h1>{{ isEdit ? 'Edit User' : 'Create User' }}</h1>
      <form @submit.prevent="saveUser">
        <div class="mb-3">
          <label for="name" class="form-label">Name:</label>
          <input v-model="user.name" type="text" class="form-control" id="name" required />
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email:</label>
          <input v-model="user.email" type="email" class="form-control" id="email" required />
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password:</label>
          <input v-model="user.password" type="password" class="form-control" id="password" required />
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
    name: 'UserForm',
    setup() {
      const route = useRoute();
      const router = useRouter();
      const isEdit = route.params.id !== undefined;
      const user = ref({
        name: '',
        email: '',
        password: ''
      });
  
      onMounted(async () => {
        if (isEdit) {
          try {
            const response = await api.get(`/users/${route.params.id}`);
            user.value = response.data;
          } catch (error) {
            console.error('Error fetching user:', error);
          }
        }
      });
  
      const saveUser = async () => {
        try {
          if (isEdit) {
            await api.put(`/users/${route.params.id}`, user.value);
          } else {
            await api.post('/users', user.value);
          }
          router.push('/users');
        } catch (error) {
          console.error('Error saving user:', error);
        }
      };
  
      return {
        user,
        saveUser,
        isEdit
      };
    }
  };
  </script>
 