<template>
  <section class="home-hero login">
    <div class="login-wrapper pb-0 w-100">
      <div class="bg-dots bg-dots-left"></div>
      <div class="bg-dots bg-dots-right"></div>

      <div class="mt-5 text-center login-card-wrapper">
        <div class="card-item login-card">
          <div class="d-flex justify-content-center mb-3 mt-1">
            <img class="logo-dark" src="assets/img/crazy-rdp-logo.svg" alt="" />
            <img class="logo-light" src="assets/img/logo-light.svg" alt="" />
          </div>

          <form @submit.prevent="trySubmit()">

            <div class="login-input-wrapper mb-3">
              <label for="#email">{{ $t('Email_Address') }}</label>
              <input v-model="loginForm.email" id="email" type="email" required autofocus autocomplete="email"
                placeholder="email@address.com" />
              <!-- Validation Errors -->
              <div class="text-danger mt-1">
                <div v-for="message in validationErrors?.email">
                  {{ message }}
                </div>
              </div>
            </div>
            <!-- Password -->
            <div class="login-input-wrapper mb-4" style="position: relative;">
              <label for="#password">{{ $t('Password') }}</label>
              <input v-model="loginForm.password" id="password" :type="(show1) ? 'text' : 'password'" required autocomplete="current-password"
                placeholder="••••••••••" />
                <p 
                  style="position: absolute;
                    top: 50%;
                    right: 8px;
                    cursor: pointer;
                    transform: translate(-25%, -50%);"
                >
                    <img src="/assets/img/eye-open.svg" class="icon-password eye-open" v-if="show1"
                      @click="show1 = !show1" />
                    <img src="/assets/img/eye.svg" class="icon-password eye-closed" v-else @click="show1 = !show1" />
                </p>
              <!-- Validation Errors -->
              <div class="text-danger-600 mt-1">
                <div v-for="message in validationErrors?.password">
                  {{ message }}
                </div>
              </div>
            </div>

            <!-- <div :class="(inputValue!='' && captcha_success== false)?'login-input-wrapper mb-4 redBorder vl-parent':'login-input-wrapper mb-4 vl-parent'">
              
              <label for="#captcha">Captcha code</label>
              <input v-model="inputValue" id="captcha" type="text" required/>
            </div> -->

            <!-- <div class="mb-4">
              <VueClientRecaptcha
                :key="captcha_key"
                :value="inputValue"
                @getCode="getCaptchaCode"
                @isValid="checkValidCaptcha"
              />
            </div> -->

            

            <!-- Remember me -->
            <div class="form-check" style="display: none;">
              <input class="form-check-input" type="checkbox" name="remember" v-model="loginForm.remember"
                id="flexCheckIndeterminate" />
              <label class="form-check-label" for="flexCheckIndeterminate">
                {{ $t("remember_me") }}
              </label>
            </div>

            <div class="vl-parent">
              <loading v-model:active="gCaptchaLoaded" :is-full-page="false" />
              <div class="mb-4" style="height: 78px;" v-show="gCaptchaLoaded">

              </div>
              <div class="mb-4">
                <vue-hcaptcha 
                  sitekey="8b633f54-60ab-4ca1-b34f-c329f9eb60b9"
                  @verify = "verify"
                  @rendered = "rendered"
                >
                </vue-hcaptcha>
              </div>
              <button class="btn-dark w-100 mb-2" :class="{ 'opacity-25': processing }" type="submit"
              :disabled="processing || captcha_success == false">{{ $t("login") }}</button>
            </div>
            

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
import { commonApis } from "@/apis/commonApis";
import { ref } from "vue";
// import VueClientRecaptcha from 'vue-client-recaptcha'

import VueHcaptcha from '@hcaptcha/vue3-hcaptcha';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
const gCaptchaLoaded = ref(true);

const captcha_key = ref(1);
const $toast = useToast();
const show1 = ref(false);
const { loginForm, validationErrors, processing, submitLogin } = useAuth();
// const commonApi = commonApis();

const inputValue = ref('');
const captcha_success = ref(false);

const trySubmit = () => {
  captcha_key.value = captcha_key.value + 1;
  inputValue.value = '';
  submitLogin();
};

const verify = (token, eKey) => {
  captcha_success.value = true;
};

const rendered = () => {
  gCaptchaLoaded.value = false;
};

// const getCaptchaCode = (value) => {
//   /* you can access captcha code */
//   console.log('get captcha code');
// };

// const checkValidCaptcha = (value) => {
//   /* expected return boolean if your value and captcha code are same return True otherwise return False */
//   captcha_success.value = value;
// };

</script>
<style>
.vue_client_recaptcha{display:flex;justify-content:center;flex-direction:row}.vue_client_recaptcha_icon{text-align:center;padding:10px;cursor:pointer;display:flex;align-items:center;justify-content:center;background-color:#eee;transition:background-color .3s ease-in-out}.vue_client_recaptcha_icon:hover{background-color:#ccc}.vue_client_recaptcha .captcha_canvas{background:#eee;padding:10px 0}
.redBorder{
  border: 1px solid red;
}
</style>
