<template>
  <section class="home-hero login">
    <div class="badge reset-success" v-show="false">
      <img src="assets/img/reset-success.svg" alt="" /> {{ $t('success_register') }}
    </div>
    

    <div class="login-wrapper pb-0 w-100">
      <div class="bg-dots bg-dots-left"></div>
      <div class="bg-dots bg-dots-right"></div>

      <div class="mt-5 text-center login-card-wrapper">
        <div class="card-item login-card">
          <div class="d-flex justify-content-center mb-3 mt-1">
            <img class="logo-dark" src="assets/img/crazy-rdp-logo.svg" alt="" />
            <img class="logo-light" src="assets/img/logo-light.svg" alt="" />
          </div>
          <h2 class="login-title">{{ $t('Login_Account') }}</h2>

          <form @submit.prevent="submitLogin">
              
                <div class="login-input-wrapper mb-3">
                    <label for="#email">{{ $t('Email_Address') }}</label>
                    <input
                        v-model="loginForm.email"
                        id="email"
                        type="email"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="email@address.com"
                    />
                    <!-- Validation Errors -->
                    <div class="text-danger mt-1">
                        <div v-for="message in validationErrors?.email">
                        {{ message }}
                        </div>
                    </div>
                </div>
                <!-- Password -->
                <div class="login-input-wrapper mb-4">
                    <label for="#password">{{ $t('Password') }}</label>
                    <!-- <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••••"> -->
                    <input
                        v-model="loginForm.password"
                        id="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••••"
                    />
                    <!-- Validation Errors -->
                    <div class="text-danger-600 mt-1">
                        <div v-for="message in validationErrors?.password">
                        {{ message }}
                        </div>
                    </div>
                </div>

                <!-- Remember me -->
                <div class="form-check" style="display: none;">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    name="remember"
                    v-model="loginForm.remember"
                    id="flexCheckIndeterminate"
                  />
                  <label class="form-check-label" for="flexCheckIndeterminate">
                    {{ $t("remember_me") }}
                  </label>
                </div>

                <button class="btn-dark w-100 mb-2" :class="{ 'opacity-25': processing }" type="submit" :disabled="processing">{{ $t("login") }}</button>
              
            </form>

            <router-link to="/register" style="color: black">
              <button class="btn-light w-100 mb-3">{{ $t('Register_account') }}</button>
            </router-link>

            <div class="text-center">
              <router-link class="fs-14" to="/forgot-password">
                {{ $t('forgot_password') }}
              </router-link>
            </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import useAuth from "@/composables/auth";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
const $toast = useToast();

const { loginForm, validationErrors, processing, submitLogin } = useAuth();
</script>
