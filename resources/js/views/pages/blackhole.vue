<template>
  <section class="dashboard">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center title-button-wrapper">
        <h2 class="title mb-0">Realtime blackhole check</h2>
        <router-link to="/create-vps-server"
          class="btn btn-dark hover-dark-light">
          <i class="fa fa-shopping-cart"></i> Order now
          </router-link>
      </div>

      <div class="mb-3">
          
          <div class="row px-2 pt-4 px-lg-4 pt-lg-4">
            <div class="col-12 col-lg-6 tab-inner py-0 p-mb-0 vl-parent">
              <loading v-model:active="gCaptchaLoaded" :is-full-page="false" />
              <p class="fs-13-5">Enter the IP address below to check</p>
              <div class="overview-input mb-4">
                <div class="d-inline mb-2">
                  <input type="text" id="current_ip" name="current_ip" placeholder="133.33.33.77"
                    v-model="current_ip" />
                  <button @click="checkBlackhole()" class="btn-dark px-4 me-2 hover-dark-light checkBtn" :disabled="current_ip.length == 0 || captcha_success == false">
                    Submit
                  </button>
                </div>
                <div class="mt-2 mb-2">
                  <vue-hcaptcha 
                    sitekey="8b633f54-60ab-4ca1-b34f-c329f9eb60b9"
                    ref="captchaRef"
                    @verify = "verify"
                    @rendered = "rendered"
                  >
                  </vue-hcaptcha>
                </div>
              </div>
              <!-- Output text area -->
              <div>
                <p>
                  {{ output_result }}
                </p>
              </div>
              
            </div>
          </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { computed, onMounted, ref, onBeforeUnmount, watch } from "vue";
import { commonApis } from "@/apis/commonApis";
import { useStore } from "vuex";
import useAuth from "@/composables/auth";
import { showLoader } from "@/plugins/loading.js";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

import VueHcaptcha from '@hcaptcha/vue3-hcaptcha';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
const gCaptchaLoaded = ref(true);
const captcha_success = ref(false);
const captchaRef = ref(null);
const verify = (token, eKey) => {
  captcha_success.value = true;
};

const rendered = () => {
  gCaptchaLoaded.value = false;
};

useAuth().getUser();
const $toast = useToast();

const commonApi = commonApis();
const store = useStore();
const user = computed(() => store.state.auth.user);
const current_ip = ref('');
const output_result = ref('');

const checkBlackhole = () => {
  showLoader(true);
  output_result.value = '';
  commonApi
    .runPostApi("/blackhole/check", {
      ip: current_ip.value,
    })
    .then((res) => {
      showLoader(false);
      captchaRef.value.reset();
      captcha_success.value = false;
      if (res.data.result == "success") {
        output_result.value = res.data.message;
      } else $toast.warning("Cannot connect to laravel backend api.");
    })
    .catch((e) => {
      showLoader(false);
      captchaRef.value.reset();
      captcha_success.value = false;
      $toast.warning(e);
    });
};

useAuth().getUser();
</script>

<style scoped>
.checkBtn{
  cursor: pointer; 
  margin-left: 20px;
  border: none;
  box-shadow: none;
}
</style>
