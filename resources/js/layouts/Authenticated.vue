<template>
    <div>
      <header class="border-bottom sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container d-flex flex-wrap align-items-center justify-content-between  py-3">
            <a href="/" class="logo-wrapper d-flex align-items-center col-md-2 text-dark text-decoration-none order-lg-1">
              <img class="logo-dark" src="@/assets/img/crazy-rdp-logo.svg" alt="">
              <img class="logo-light" src="@/assets/img/logo-light.svg" alt="">
            </a>
  
            <div class="col-md-4 d-flex align-items-center justify-content-end order-lg-3">
              <!-- Dark Mode/Light Mode Switcher -->
              <div class="form-check form-switch d-inline">
                <input class="form-check-input" type="checkbox" id="modeSwitch">
              </div>
  
              <!-- Nav Action Buttons -->
              <a class="btn-balance btn-login d-lg-block hover-light-dark" href="#">€10.30 <div class="add-balance"><img src="@/assets/img/plus-d.svg" alt=""></div></a>
  
              <div class="profile-area position-relative">
                <img class="profile-img options-toggle" src="@/assets/img/profile.png" alt="">
                <div class="options-toggle-dropdown">
                  <ul>
                    <li class="dropdown-profile-item"><img style="width:28px;height:28px" src="@/assets/img/profile.png" alt="">Udodov228</li>
                    <li style="border-bottom:unset !important"><a href="#"><img style="filter: brightness(2.5);" src="@/assets/img/settings.svg" alt="">Settings</a></li>
                    <li><a href="#"><img style="filter: brightness(2.5);" src="@/assets/img/messages.svg" alt="">Support Tickets</a></li>
                    <li>
                       
                        <a class="" :class="{ 'opacity-25': processing }" :disabled="processing"
                                   href="javascript:void(0)" @click="logout"><img src="@/assets/img/signout.svg" style="margin-right: 15px !important;margin-left: 3px;" alt="">Sign out</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
  
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
  
            <div class="collapse navbar-collapse col-12 col-md-6 col-sm-5 justify-content-center order-lg-2" id="navbarNav">
              <ul class="navbar-nav justify-content-center mb-md-0">
                <li class="nav-item"><a href="#" class="nav-link">Dashboard</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Tickets</a></li>
                <li class="nav-item"><a href="#" class="nav-link active">Servers</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Invoices</a></li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
    </div>
    <router-view></router-view>
  </template>
  
  <script setup>
import { onMounted } from 'vue';
import {computed} from "vue";
import { useStore } from 'vuex';
import useAuth from "@/composables/auth";

const store = useStore();
const user = computed(() => store.state.auth.user)
const {processing, logout} = useAuth();
const handleMoreProductsButton = () => {
  const moreProductsBtn = document.getElementById('more-products-btn');
  const moreProducts = document.getElementById('more-products');
  if (moreProductsBtn && moreProducts) {
    moreProductsBtn.addEventListener('click', () => {
      moreProducts.slideToggle();
    });
  }
};

const handleClipboardIconClick = () => {
  const clipboardIcons = document.querySelectorAll('.icon-clipboard');
  clipboardIcons.forEach(icon => {
    icon.addEventListener('click', () => {
      const element = icon.closest('tr').querySelector('.clipboard-input');
      const text = element.getAttribute('data-copy');
      const tempInput = document.createElement('input');
      document.body.appendChild(tempInput);
      tempInput.value = text;
      tempInput.select();
      document.execCommand('copy');
      document.body.removeChild(tempInput);
      element.style.textDecoration = 'underline';
      setTimeout(() => {
        element.style.textDecoration = 'none';
      }, 1000);
    });
  });
};

const handlePasswordIconClick = () => {
  const passwordIcons = document.querySelectorAll('.icon-password');
  passwordIcons.forEach(icon => {
    icon.addEventListener('click', () => {
      const input = icon.closest('tr').querySelector('input');
      const eyeClosed = document.querySelector('img.eye-closed');
      const eyeOpen = document.querySelector('img.eye-open');
      if (input.getAttribute('type') === 'password') {
        input.setAttribute('type', 'text');
        eyeClosed.style.display = 'none';
        eyeOpen.style.display = 'block';
      } else {
        eyeClosed.style.display = 'block';
        eyeOpen.style.display = 'none';
        input.setAttribute('type', 'password');
      }
    });
  });
};

const handleOptionsToggleClick = () => {
  const optionsToggle = document.querySelectorAll('.options-toggle');
  optionsToggle.forEach(toggle => {
    toggle.addEventListener('click', () => {
      toggle.nextElementSibling.style.display = 'block';
    });
  });
};

const handleDocumentClick = () => {
  document.addEventListener('click', e => {
    const target = e.target;
    const isOptionsToggle = target.closest('.options-toggle');
    const isOptionsToggleDropdown = target.closest('.options-toggle-dropdown');
    if (!(isOptionsToggle || isOptionsToggleDropdown)) {
      const dropdowns = document.querySelectorAll('.options-toggle-dropdown');
      dropdowns.forEach(dropdown => {
        dropdown.style.display = 'none';
      });
    }
  });
};

const handleToggleMoreDetailClick = () => {
  const toggleMoreDetails = document.querySelectorAll('.toggle-more-detail');
  toggleMoreDetails.forEach(toggle => {
    toggle.addEventListener('click', () => {
      toggle.nextElementSibling.slideToggle();
    });
  });
};

const handleDisplayDistributionsClick = () => {
  const displayDistributions = document.querySelectorAll('.display-distributions');
  displayDistributions.forEach(display => {
    display.addEventListener('click', () => {
      const dist = display.getAttribute('data-dist');
      const distTabs = document.querySelectorAll('.dist-tab');
      distTabs.forEach(tab => {
        if (tab.getAttribute('data-dist') === dist) {
          tab.style.display = 'block';
        } else {
          tab.style.display = 'none';
        }
      });
    });
  });
};

const handleSettingsPasswordImageClick = () => {
  const settingsPasswordImages = document.querySelectorAll('.settings-password-img');
  settingsPasswordImages.forEach(image => {
    image.addEventListener('click', () => {
      const input = image.nextElementSibling;
      const eyeClosed = document.querySelector('img.eye-closed');
      const eyeOpen = document.querySelector('img.eye-open');
      if (input.getAttribute('type') === 'password') {
        input.setAttribute('type', 'text');
        eyeClosed.style.display = 'none';
        eyeOpen.style.display = 'block';
      } else {
        eyeClosed.style.display = 'block';
        eyeOpen.style.display = 'none';
        input.setAttribute('type', 'password');
      }
    });
  });
};

onMounted(() => {
  handleMoreProductsButton();
  handleClipboardIconClick();
  handlePasswordIconClick();
  handleOptionsToggleClick();
  handleDocumentClick();
  handleToggleMoreDetailClick();
  handleDisplayDistributionsClick();
  handleSettingsPasswordImageClick();
});
</script>

<style>
    @import url('@/assets/css/style.css');
    @import url('@/assets/css/dark-theme.css');
    @import url('@/assets/css/responsive.css');
</style>
  