<template>
  <section class="home-hero login">

    <div class="login-wrapper pb-0 w-100">
      <div class="bg-dots bg-dots-left"></div>
      <div class="bg-dots bg-dots-right"></div>

      <div class="mt-5 text-center login-card-wrapper">
        <div class="card-item login-card">
          <div
            style="margin-top: -20px"
            class="d-flex justify-content-center mb-3"
          >
            <img class="logo-dark" src="assets/img/crazy-rdp-logo.svg" alt="" />
            <img class="logo-light" src="assets/img/logo-light.svg" alt="" />
          </div>
          <h2 class="login-title">{{ $t('Forgot_password') }}</h2>

          <form @submit.prevent="submitForgot">
            <div class="login-input-wrapper mb-3">
              <label for="#email">{{ $t('Email_Address') }}</label>
              <input
                type="email"
                id="email"
                name="email"
                v-model="email"
                required
                placeholder="email@address.com"
              />
            </div>

            <!-- <div :class="(inputValue!='' && captcha_success== false)?'login-input-wrapper mb-4 redBorder':'login-input-wrapper mb-4'">
              <label for="#captcha">Captcha code</label>
              <input v-model="inputValue" id="captcha" type="text" required/>
            </div>

            <div class="mb-4">
              <VueClientRecaptcha
                :value="inputValue"
                @getCode="getCaptchaCode"
                @isValid="checkValidCaptcha"
              />
            </div> -->

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
              <button type="submit" class="btn-dark w-100 mb-2" :class="{ 'opacity-25': processing }" :disabled="processing || captcha_success == false">
                {{ $t('sent_reset') }}
              </button>
            </div>

            

            <div class="text-center">
              <p class="mb-0 mt-3 fs-14">
                <router-link to="/login"
                  >{{ $t('Back') }} <img class="ms-1" src="assets/img/blue-back.svg" alt=""
                /></router-link>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed, onMounted, ref, onBeforeUnmount } from "vue";
import { useRouter } from "vue-router";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { showLoader } from "@/plugins/loading.js";
// import VueClientRecaptcha from 'vue-client-recaptcha'
import VueHcaptcha from '@hcaptcha/vue3-hcaptcha';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
const gCaptchaLoaded = ref(true);

const $toast = useToast();

const processing = ref(false);
const router = useRouter();
const email = ref("");

const submitForgot = async () => {
  if (processing.value) return;
  processing.value = true;
  showLoader(true);
  await axios
    .post("api/whmcs/forgot-password", {
      email: email.value,
    })
    .then((res) => {
      if (res) {
        if (res.status == 200) {
          showLoader(false);
          if (res.data.data == "success") {
            //
            $toast.success("Successfully sent forgot password request!");
            router.push({ name: "auth.login" });
          } else {
            $toast.warning("Email is not valid!");
          }
        } else {
          showLoader(false);
          console.log(res.data);
        }
      }
    })
    .catch(function (error) {
      console.log(error);
    })
    .finally(() => (processing.value = false));
};

const inputValue = ref('');
const captcha_success = ref(false);

const verify = (token, eKey) => {
  captcha_success.value = true;
};

const rendered = () => {
  gCaptchaLoaded.value = false;
};
// const getCaptchaCode = (value) => {
//   /* you can access captcha code */
//   console.log(value);
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

