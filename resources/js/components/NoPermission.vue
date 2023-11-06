<template>
  <div class="error-container mt-4" style="text-align: center;">
    <h1 style="margin-bottom: 20px">Oops!</h1>
    <p>You do not have the required permissions to access this page</p>
    <p>Contact the master account owner if you feel this to be an error.</p>
    <div class="buttons mb-4">
      <a href="javascript:history.go(-1)" class="btn btn-primary btn-lg">
        <i class="fas fa-arrow-circle-left"></i>
        Go Back
      </a>
      <router-link :to="{
        name: 'dashboard',
      }" class="btn btn-default btn-lg">
        <i class="fas fa-home"></i>
        Return Home
      </router-link>
    </div>
  </div>
</template>

<script>

</script>
