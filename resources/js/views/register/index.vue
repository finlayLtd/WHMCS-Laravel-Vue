<template>
  <section class="home-hero login">

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
          <h2 class="login-title">{{ $t('Register_account') }}</h2>

          <form @submit.prevent="submitRegister">
            <div class="login-input-wrapper mb-3">
              <label for="#firstname">{{ $t('First_Name') }}</label>

              <div class="col-md-6">
                <input
                  id="firstname"
                  type="text"
                  name="firstname"
                  v-model="firstname"
                  required
                  autocomplete="firstname"
                  autofocus
                />
              </div>
            </div>

            <div class="login-input-wrapper mb-3">
              <label for="#lastname">{{ $t('Last_Name') }}</label>

              <input
                id="lastname"
                type="text"
                v-model="lastname"
                name="lastname"
                required
                autocomplete="lastname"
                autofocus
              />
            </div>

            <div class="login-input-wrapper mb-3">
              <label for="#email">{{ $t('Email_Address') }}</label>
              <input
                id="email"
                type="email"
                name="email"
                v-model="email"
                required
                autocomplete="email"
                placeholder="email@address.com"
              />
            </div>

            <div class="login-input-wrapper mb-3" style="position: relative;">
              <label for="#password">{{ $t('Password') }}</label>
              <div class="col-md-6">
                <input
                  id="password"
                  :type="(show1) ? 'text' : 'password'"
                  name="password"
                  v-model="password"
                  required
                  autocomplete="new-password"
                />

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
              </div>
            </div>

            <div class="progress" id="passwordStrengthBar">
              <div
                class="progress-bar progress-bar-success"
                role="progressbar"
                aria-valuenow="0"
                            aria-valuemin="0"
                            aria-valuemax="100"
                            :style="'width: '+passwordStrength+'%'"
              >
                <span class="rating">{{ $t('Password_Rating') }}: {{ passwordStrength }}%</span>
              </div>
            </div>

            <div class="alert alert-info" style="text-align: left">
              <strong>{{ $t('tips_title') }}
              </strong><br />
              {{ $t('tips_content1') }}
              <br />
              {{ $t('tips_content2') }}
              <br />{{ $t('tips_content3') }}
            </div>

            <div class="checkbox-item-wrapper mb-4">
              <input
                class="form-check-input"
                checked=""
                type="checkbox"
                id="inStockCheckbox"
              />
              <label class="form-check-label checked" for="inStockCheckbox"
                >{{ $t('Agree_Policy') }}</label
              >
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
              <button
                id="register-btn"
                type="submit"
                class="btn-dark w-100 mb-2"
                :class="{ 'opacity-25': processing }"
                :disabled="processing || password == '' || passwordStrength < 80 | captcha_success == false"
              >
                {{ $t('Register_account') }}
              </button>
            </div>

            <div class="text-center">
              <p class="mb-0 mt-3 fs-14">
                {{ $t('already_have') }}
                <router-link to="/login">{{  $t('log_in') }}</router-link>
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

const router = useRouter();
const firstname = ref("");
const lastname = ref("");
const email = ref("");
const password = ref("");
const processing = ref(false);
const show1 = ref(false);
const submitRegister = async () => {
  if (processing.value) return;
  processing.value = true;
  showLoader(true);
  await axios
    .post("/register", {
      firstname: firstname.value,
      lastname: lastname.value,
      email: email.value,
      password: password.value,
    })
    .then((res) => {
      showLoader(false);
      if (res) {
        if (res.status == 200) {
          if (res.data.data == "success") {
            $toast.success("Successfully registered!");
            router.push({ name: "auth.login" });
          } else {
            $toast.warning(res.data.message);
          }
        } else {
          console.log(res.data);
        }
      }
    })
    .catch(function (error) {
      console.log(error);
      showLoader(false);
    })
    .finally(() => (processing.value = false, showLoader(false)));
};

const passwordStrength = computed(() => {
  var pwStrengthErrorThreshold = 50;
  var pwStrengthWarningThreshold = 75;

  var pw = password.value;

  // Check if the password contains any disallowed special symbols
  if (/[^A-Za-z0-9!@#]/.test(pw)) {
    // Set password strength to 0 if disallowed special symbols are found
    return 10;
  }

  var pwlength = (pw.length);
  if (pwlength > 7) pwlength = 5;
  else pwlength = 2;

  var numnumeric = pw.replace(/[0-9]/g, "");
  var numeric = (pw.length - numnumeric.length);
  if (numeric > 3) numeric = 3;

  // Update the regular expression to only match "!" and "@"
  var symbols = pw.replace(/[!@#]/g, "");
  var numsymbols = (pw.length - symbols.length);
  if (numsymbols > 3) numsymbols = 3;

  var numupper = pw.replace(/[A-Z]/g, "");
  var upper = (pw.length - numupper.length);
  if (upper > 3) upper = 3;
  var pwstrength = ((pwlength * 10) - 20) + (numeric * 10) + (numsymbols * 15) + (upper * 10);
  if (pwstrength < 0) pwstrength = 0;
  if (pwstrength > 100) pwstrength = 100;

  return pwstrength;
});

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