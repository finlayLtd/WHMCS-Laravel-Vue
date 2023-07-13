<template>
  <!-- <div class="container">
        <div class="row justify-content-center my-5">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent">{{ $t('register') }}</div>
                    <div class="card-body">
                        <form @submit.prevent="submitRegister">
                            <div class="">
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ $t('name') }}</label>
                                    <input v-model="registerForm.name" id="name" type="text" class="form-control" autofocus>
                                    <div class="text-danger mt-1">
                                        <div v-for="message in validationErrors?.name">
                                            {{ message }}
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ $t('email') }}</label>
                                    <input v-model="registerForm.email" id="email" type="email" class="form-control" autocomplete="username">
                                    <div class="text-danger mt-1">
                                        <div v-for="message in validationErrors?.email">
                                            {{ message }}
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">
                                        {{ $t('password') }}
                                    </label>
                                    <input v-model="registerForm.password" id="password" type="password" class="form-control" autocomplete="current-password">
                                    <div class="text-danger-600 mt-1">
                                        <div v-for="message in validationErrors?.password">
                                            {{ message }}
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">
                                        {{ $t('confirm_password') }}
                                    </label>
                                    <input v-model="registerForm.password_confirmation" id="password_confirmation" type="password" class="form-control" autocomplete="current-password">
                                    <div class="text-danger-600 mt-1">
                                        <div v-for="message in validationErrors?.password_confirmation">
                                            {{ message }}
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <button class="btn btn-primary" :class="{ 'opacity-25': processing }" :disabled="processing">
                                        {{ $t('register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
  <section class="home-hero login">
    <!-- alert messges -->
    <div class="badge reset-success" style="background: crimson" v-show="false">
      <img src="assets/img/reset-success.svg" alt="" /> Error message
    </div>

    <div class="register-wrapper pb-0 w-100">
      <div class="bg-dots bg-dots-left"></div>
      <div class="bg-dots bg-dots-right"></div>

      <div class="mt-5 text-center login-card-wrapper">
        <div class="card-item login-card" style="max-width: 450px">
          <div
            style="margin-top: -20px"
            class="d-flex justify-content-center mb-3"
          >
            <img class="logo-dark" src="assets/img/crazy-rdp-logo.svg" alt="" />
            <img class="logo-light" src="assets/img/logo-light.svg" alt="" />
          </div>
          <h2 class="login-title">Register Account</h2>

          <form @submit.prevent="submitRegister">
            <div class="login-input-wrapper mb-3">
              <label for="#firstname">First Name</label>

              <div class="col-md-6">
                <input
                  id="firstname"
                  type="text"
                  name="firstname"
                  v-model="registerForm.name"
                  required
                  autocomplete="firstname"
                  autofocus
                />
              </div>
            </div>

            <div class="login-input-wrapper mb-3">
              <label for="#lastname">Last Name</label>

              <input
                id="lastname"
                type="text"
                name="lastname"
                required
                autocomplete="lastname"
                autofocus
              />
            </div>

            <div class="login-input-wrapper mb-3">
              <label for="#email">Email Address</label>
              <input
                id="email"
                type="email"
                name="email"
                v-model="registerForm.email"
                required
                autocomplete="email"
                placeholder="email@address.com"
              />
            </div>

            <div class="login-input-wrapper mb-3">
              <label for="#password">Password</label>
              <div class="col-md-6">
                <input
                  id="password"
                  type="password"
                  name="password"
                  v-model="registerForm.password"
                  required
                  autocomplete="new-password"
                />
              </div>
            </div>

            <div class="progress" id="passwordStrengthBar">
              <div
                class="progress-bar progress-bar-success"
                role="progressbar"
                aria-valuenow="0"
                aria-valuemin="0"
                aria-valuemax="100"
                style="width: 0%"
              >
                <span class="sr-only">Password Rating: 0%</span>
              </div>
            </div>

            <div class="alert alert-info" style="text-align: left">
              <strong>Tips for a good password</strong><br />Use both upper and
              lowercase characters<br />Include at least one symbol (# $ ! %
              &amp; etc...)<br />Don't use dictionary words
            </div>

            <div class="checkbox-item-wrapper mb-4">
              <input
                class="form-check-input"
                checked=""
                type="checkbox"
                id="inStockCheckbox"
              />
              <label class="form-check-label checked" for="inStockCheckbox"
                >I agree to the User Agreement, and I have read the Privacy
                Policy.</label
              >
            </div>

            <button
              id="register-btn"
              type="submit"
              class="btn-dark w-100 mb-2"
              :class="{ 'opacity-25': processing }" :disabled="processing"
            >
              Register account
            </button>

            <div class="text-center">
              <p class="mb-0 mt-3 fs-14">
                Already have an account?
                <router-link to="/login">Log in</router-link>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import useAuth from "@/composables/auth";

const { registerForm, validationErrors, processing, submitRegister } =
  useAuth();
</script>
