<template>
  <header class="border-bottom sticky-top" v-show="isAuthLayout == false">
    <nav class="navbar navbar-expand-lg navbar-light">
      <div
        class="container d-flex flex-wrap align-items-center justify-content-between py-3"
      >
        <!-- <a
            href="/"
            class="logo-wrapper d-flex align-items-center col-md-2 text-dark text-decoration-none order-lg-1"
          > -->
        <router-link
          class="logo-wrapper d-flex align-items-center col-md-2 text-dark text-decoration-none order-lg-1"
          to="/dashboard"
        >
          <img class="logo-dark"  src="/assets/img/crazy-rdp-logo.svg" alt="" />
          <img class="logo-light" src="/assets/img/logo-light.svg" alt="" />
          <!-- <img class="status-arrow" :src="require('@//assets/img/status-arrow.svg')" alt="" /> -->
        </router-link>

        <!-- </a> -->

        <div
          class="col-md-4 d-flex align-items-center justify-content-end order-lg-3"
        >
          <div class="profile-area position-relative">
            <div
              class="options-toggle dropdown-toggle lang-div"
              style="margin-right: 24px; cursor: pointer"
              data-bs-toggle="dropdown"
            >
              <span
                class="ip2location-flag-16 flag-round flag-us"
                style="margin: 10px 0px -3px 5px"
                id="language-flag"
              ></span>
              <small id="language-code" style="user-select: none">&nbsp;EN</small>
            </div>
            <div
              class="options-toggle-dropdown dropdown-menu dropdown-menu-end"
            >
              <ul>
                <li style="cursor: pointer">
                  <span
                    class="ip2location-flag-16 flag-round flag-us"
                    style="margin: 10px 0px -3px 5px"
                  ></span>
                  <b style="line-height: 36px; margin-left: 5px; color: black"
                    >English</b
                  >
                </li>
                <li style="cursor: pointer">
                  <span
                    class="ip2location-flag-16 flag-round flag-ru"
                    style="margin: 10px 0px -3px 5px"
                  ></span>
                  <b style="line-height: 36px; margin-left: 5px; color: black"
                    >русский</b
                  >
                </li>
                <li style="cursor: pointer">
                  <span
                    class="ip2location-flag-16 flag-round flag-cn"
                    style="margin: 10px 0px -3px 5px"
                  ></span>
                  <b style="line-height: 36px; margin-left: 5px; color: black"
                    >中文</b
                  >
                </li>
              </ul>
            </div>
          </div>

          <!-- Dark Mode/Light Mode Switcher-->
          <div class="form-check form-switch d-inline">
            <input
              class="form-check-input"
              type="checkbox"
              id="modeSwitch"
              @click="toggleSortingItems"
            />
          </div>

          <!--Nav Action Buttons-->

          <router-link
            class="btn-balance btn-login d-lg-block hover-light-dark"
            to="/balance"
          >
            <span v-if="user.credit != null && user.credit != undefined">€{{ user.credit.toFixed(2) }}</span>
            
            <div class="add-balance">
              <img src="/assets/img/plus-d.svg" alt="" />
            </div>
          </router-link>

          <div class="profile-area position-relative">
            <img
              class="profile-img options-toggle dropdown-toggle"
              src="/assets/img/profile.png"
              alt=""
              data-bs-toggle="dropdown"
            />
            <div
              class="options-toggle-dropdown dropdown-menu dropdown-menu-end"
            >
              <ul class="">
                <li class="dropdown-profile-item">
                  <img
                    style="width: 28px; height: 28px"
                    src="/assets/img/profile.png"
                    alt=""
                  />{{ user.name }}
                </li>

                <li style="border-bottom: unset !important">
                  <router-link to="/settings">
                    <img
                      style="filter: brightness(2.5)"
                      src="/assets/img/settings.svg"
                      alt=""
                    />Settings
                  </router-link>
                </li>
                <li>
                  <router-link to="/support-ticket">
                    <img
                      style="filter: brightness(2.5)"
                      src="/assets/img/messages.svg"
                      alt=""
                    />Support Tickets</router-link
                  >
                </li>
                <li>
                  <a href="javascript:void(0)" @click="logout">
                    <img
                      src="/assets/img/signout.svg"
                      style="margin-right: 15px !important; margin-left: 3px"
                      alt=""
                    />Sign out</a
                  >
                </li>
              </ul>
            </div>
          </div>
        </div>

        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div
          class="collapse navbar-collapse col-12 col-md-6 col-sm-5 justify-content-center order-lg-2"
          id="navbarNav"
        >
          <ul class="navbar-nav justify-content-center mb-md-0">
            <li class="nav-item">
              <router-link class="nav-link" to="/dashboard"
                >Dashboard</router-link
              >
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/support-ticket">
                Tickets
              </router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/servers">
                Servers
              </router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/balance">
                Invoices
              </router-link>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <!-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
          <div class="container">
              <router-link to="/" class="navbar-brand">Laravel Vue Stater</router-link>
              <a class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
              </a>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav mt-2 mt-lg-0 me-auto mb-2 mb-lg-0">
                      <LocaleSwitcher />
                  </ul>
                  <ul class="navbar-nav mt-2 mt-lg-0 ms-auto">
                      <template v-if="!user?.name">
                          <li class="nav-item">
                              <router-link to="/" class="nav-link" aria-current="page">{{ $t('home') }}</router-link>r5555777776er77ery7err4
                          </li>
                          <li class="nav-item">
                              <router-link :to="{ name : 'balance'}" class="nav-link">Balance</router-link>
                          </li>
                          <li class="nav-item">
                              <router-link class="nav-link" to="/login"
                              >{{ $t('login') }}</router-link
                              >
                          </li>
                          <li class="nav-item">
                              <router-link class="nav-link" to="/register">{{ $t('register') }}</router-link>
                          </li>
                      </template>
                      <li v-if="user?.name" class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              {{ user.name }}
                          </a>
                          <ul class="dropdown-menu dropdown-menu-end">
                              <li><router-link class="dropdown-item" to="/admin">Admin</router-link></li>
                              <li><router-link to="/admin/posts" class="dropdown-item">Post</router-link></li>
                              <li><hr class="dropdown-divider"></li>
                              <li><a class="dropdown-item" href="javascript:void(0)" @click="logout">Logout</a></li>
                          </ul>
                      </li>
                  </ul>
              </div>
          </div>
      </nav> -->
</template>
  
<script setup>
import { useStore } from "vuex";
import useAuth from "@/composables/auth";
import { computed, onMounted, ref, onBeforeUnmount } from "vue";
// import LocaleSwitcher from "../components/LocaleSwitcher.vue";
import { useI18n } from 'vue-i18n'
import { loadMessages } from '@/plugins/i18n'

const i18n = useI18n({useScope: "global"});





const props = defineProps({
  isAuthLayout: {
    type: Boolean,
    default: false,
  },
});

const store = useStore();
const user = computed(() => store.getters["auth/user"]);
const { processing, logout } = useAuth();
const SET_IS_LOGIN_PAGE = ref(false);

const locale = computed(() => store.getters["lang/locale"])
const locales = computed(() => store.getters["lang/locales"])

function setLocale(locale) {
    if (i18n.locale !== locale) {
        loadMessages(locale)
        store.dispatch('lang/setLocale', { locale })
    }
}

const switchTheme = (event) => {
  if (event.target.checked) {
    document.documentElement.setAttribute("data-theme", "dark");
    localStorage.setItem("theme", "dark");
  } else {
    document.documentElement.setAttribute("data-theme", "light");
    localStorage.setItem("theme", "light");
  }
};

onMounted(() => {
  const toggleSwitch = document.querySelector("#modeSwitch");
  toggleSwitch.addEventListener("change", switchTheme, false);
  console.log(locale.value);
  console.log(locales.value);
});
</script>

<style scoped>
.lang-div::after {
  display: none; /* hide the ::after pseudo-element */
}
</style>
  