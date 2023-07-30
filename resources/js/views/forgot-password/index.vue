<template>
  <section class="home-hero login">
    <div class="badge reset-success" style="background: crimson" v-show="false">
      <img src="assets/img/reset-success.svg" alt="" /> Wrong email address or
      unregistered user.
    </div>

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
          <h2 class="login-title">Forgot password</h2>

          <form @submit.prevent="submitForgot">
            <div class="login-input-wrapper mb-3">
              <label for="#email">Email Address</label>
              <input
                type="email"
                id="email"
                name="email"
                v-model="email"
                required
                placeholder="email@address.com"
              />
            </div>

            <button type="submit" class="btn-dark w-100 mb-2" :class="{ 'opacity-25': processing }" :disabled="processing">
              Send Reset Email
            </button>

            <div class="text-center">
              <p class="mb-0 mt-3 fs-14">
                <router-link to="/login"
                  >Back <img class="ms-1" src="assets/img/blue-back.svg" alt=""
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
</script>
