<template>
  <section class="dashboard">
    <div class="container">
      <div
        class="d-flex justify-content-between align-items-center title-button-wrapper"
      >
        <h2 class="title mb-0">{{ $t('Servers') }}</h2>
        <button
          type="submit"
          class="btn btn-dark btn-chevron chevron-dark hover-dark-light options-toggle dropdown-toggle"
          data-bs-toggle="dropdown"
        >
          
          {{ $t('Create_Server') }}
        </button>
  
        <div class="options-toggle-dropdown create-server dropdown-menu dropdown-menu-end">
          <ul>
              <li>
                  <router-link to="/create-vps-server">{{ $t('Create_VPS_Server') }}</router-link>
              </li>
          </ul>
        </div>
      </div>

      <!-- have to replace here with services table componenet -->
      <ServicesTable />
    </div>
  </section>
</template>

<script setup>
import ServicesTable from "./tables/services.vue";


</script>

<style scoped>
</style>
