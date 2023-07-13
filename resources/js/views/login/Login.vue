<template>
    <section class="home-hero login">
      
      <div class="login-wrapper pb-0 w-100">
        <div class="bg-dots bg-dots-left"></div>
        <div class="bg-dots bg-dots-right"></div>
        <div class="mt-5 text-center login-card-wrapper">
          <div class="card-item login-card">
            <div style="margin-top: -20px;" class="d-flex justify-content-center mb-3">
              <img class="logo-dark" src="@/assets/img/crazy-rdp-logo.svg" alt="">
              <img class="logo-light" src="@/assets/img/logo-light.svg" alt="">
            </div>
            <h2 class="login-title">Login Account</h2>
            <form @submit.prevent="submitLogin">
              <div class="login-input-wrapper ">
                <label for="email" >Email</label>
                <input v-model="loginForm.email" id="email" type="email"  required autofocus autocomplete="username">
                
              </div>
              <!-- Validation Errors -->
              <div class="text-start text-danger mb-3 mt-1">
                    <div v-for="message in validationErrors?.email">
                        {{ message }}
                    </div>
                </div>
              <div class="login-input-wrapper ">
                <label for="password" >
                    Password
                </label>
                <input v-model="loginForm.password" id="password" type="password"  required autocomplete="current-password">
                
              </div>
              <!-- Validation Errors -->
              <div class="text-start text-danger-600 mb-4 mt-1">
                    <div v-for="message in validationErrors?.password">
                        {{ message }}
                    </div>
                </div>
              <button class="btn-dark w-100 mb-2" :class="{ 'opacity-25': processing }" :disabled="processing">Login</button>
              
            </form>
            <router-link to="/register">
              <button class="btn-light w-100 mb-3">
                Register account
              </button>
            </router-link>
            <router-link to="/forgot-password">
              <div class="text-center">
                Forgot password?
              </div>
            </router-link>
          </div>
        </div>
      </div>
    </section>
  </template>

<script setup>

import useAuth from '@/composables/auth'

const { loginForm, validationErrors, processing, submitLogin } = useAuth();

</script>
<style>
    @import url('@/assets/css/style.css');
    @import url('@/assets/css/dark-theme.css');
    @import url('@/assets/css/responsive.css');
</style>