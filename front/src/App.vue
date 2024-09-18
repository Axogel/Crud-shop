<template>
  <div id="app">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">MyApp</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav">
          <li class="nav-item">
            <router-link class="nav-link" to="/">Order List</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/products">Product List</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/users">User List</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/buyers">Buyers List</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/create-order">Create Order</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/create-product">Create Product</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/create-user">Create User</router-link>
          </li>
        </ul>
      </div>
    </nav>
    <div class="container mt-4">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {
  name: 'App',
};
</script>
