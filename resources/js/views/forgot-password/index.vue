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

          <form>
            <div class="login-input-wrapper mb-3">
              <label for="#email">Email Address</label>
              <input
                type="email"
                id="email"
                name="email"
                required
                placeholder="email@address.com"
              />
            </div>

            <button type="submit" class="btn-dark w-100 mb-2">
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
</script>
