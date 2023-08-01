<template>
  <header class="border-bottom sticky-top" v-show="isAuthLayout == false">
    <nav class="navbar navbar-expand-lg navbar-light">
      <div
        class="container d-flex flex-wrap align-items-center justify-content-between py-3"
      >
        <router-link
          class="logo-wrapper d-flex align-items-center col-md-2 text-dark text-decoration-none order-lg-1"
          to="/dashboard"
        >
          <img class="logo-dark"  src="/assets/img/crazy-rdp-logo.svg" alt="" />
          <img class="logo-light" src="/assets/img/logo-light.svg" alt="" />
        </router-link>

        <div
          class="col-md-4 d-flex align-items-center justify-content-end order-lg-3"
        >
          <div class="profile-area position-relative d-mobile-none">
            <div
              class="options-toggle dropdown-toggle lang-div"
              style="margin-right: 24px; cursor: pointer"
              data-bs-toggle="dropdown"
            >
              <span class="ip2location-flag-16 flag-round flag-ru"
                style="margin: 10px 0px -3px 5px"
                id="language-flag" v-if="locale == 'ru'">
              </span>
              <span class="ip2location-flag-16 flag-round flag-cn"
                style="margin: 10px 0px -3px 5px"
                id="language-flag" v-else-if="locales[locale] == '中文'">
              </span>
              <span class="ip2location-flag-16 flag-round flag-us"
                style="margin: 10px 0px -3px 5px"
                id="language-flag" v-else>
              </span>
              <small  id="language-code" style="user-select: none">&nbsp;
                <span v-if="locale == 'ru'">RU</span>
                <span v-else-if="locales[locale] == '中文'">CN</span>
                <span v-else>EN</span>
              </small>
            </div>
            <div
              class="options-toggle-dropdown dropdown-menu dropdown-menu-end"
            >
              <ul>
                <li style="cursor: pointer" @click.prevent="setLocale('en')">
                  <span
                    class="ip2location-flag-16 flag-round flag-us"
                    style="margin: 10px 0px -3px 5px"
                  ></span>
                  <b style="line-height: 36px; margin-left: 5px; color: black"
                    >English</b
                  >
                </li>
                <li style="cursor: pointer" @click.prevent="setLocale('ru')">
                  <span
                    class="ip2location-flag-16 flag-round flag-ru"
                    style="margin: 10px 0px -3px 5px"
                  ></span>
                  <b style="line-height: 36px; margin-left: 5px; color: black"
                    >русский</b
                  >
                </li>
                <li style="cursor: pointer" @click.prevent="setLocale('zh-CN')">
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
                    />{{$t('settings_nav')}}
                  </router-link>
                </li>
                <li style="border-bottom: unset !important">
                  <router-link to="/switch-account">
                    <img
                      style="filter: brightness(2.5); width: 18px;"
                      src="/assets/img/switch_account.png"
                      alt=""
                    />{{$t('Switch_Account')}}
                  </router-link>
                </li>
                <li>
                  <router-link to="/support-ticket">
                    <img
                      style="filter: brightness(2.5)"
                      src="/assets/img/messages.svg"
                      alt=""
                    />{{$t('support_tickets_nav')}}</router-link
                  >
                </li>
                <li>
                  <a href="javascript:void(0)" @click="logout">
                    <img
                      src="/assets/img/signout.svg"
                      style="margin-right: 15px !important; margin-left: 3px"
                      alt=""
                    />{{$t('logout_nav')}}</a
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
                >{{$t('dashboard_nav')}}</router-link
              >
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/support-ticket">
                {{$t('tickets_nav')}}
              </router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/servers">
                {{$t('servers_nav')}}
              </router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/balance">
                {{$t('invoices_nav')}}
              </router-link>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  
</template>
  
<script setup>
import { useStore } from "vuex";
import useAuth from "@/composables/auth";
import { computed, onMounted, ref, onBeforeUnmount } from "vue";
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
    store.dispatch('theme/setTheme', { theme: "dark" })
  } else {
    document.documentElement.setAttribute("data-theme", "light");
    localStorage.setItem("theme", "light");
    store.dispatch('theme/setTheme', { theme: "light" })
  }
};

onMounted(() => {
  const toggleSwitch = document.querySelector("#modeSwitch");
  toggleSwitch.addEventListener("change", switchTheme, false);
});
</script>

<style scoped>
.lang-div::after {
  display: none; /* hide the ::after pseudo-element */
}



@media screen and (max-width: 767px) {
    .d-mobile-none {
      display: none;
      /* Your styles here */
    }
  }
</style>
  