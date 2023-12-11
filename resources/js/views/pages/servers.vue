<template>
  <section class="dashboard">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center title-button-wrapper">
        <h2 class="title mb-0">{{ $t('Servers') }}</h2>
        <router-link to="/create-vps-server"
          class="btn btn-dark hover-dark-light">
          <i class="fa fa-shopping-cart"></i> Order now
          </router-link>
      </div>

      <!-- have to replace here with services table componenet -->
      <ServicesTable />
    </div>
  </section>
</template>

<script setup>
import ServicesTable from "./tables/services.vue";
import NoPermission from '@/components/NoPermission.vue';

</script>

<style scoped></style>
