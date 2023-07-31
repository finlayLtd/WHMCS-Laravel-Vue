<template>
  <section class="dashboard">
    <div class="container">
      <div class="title-button-wrapper ticket-detail">
        <router-link to="/settings">
          <img class="status-arrow" src="/assets/img/status-arrow.svg" alt="" />
        </router-link>
        <h3 class="ticket-status-title color-in-work">{{ $t('Manage_Permissions') }}</h3>
        <h2 class="title mb-0 mt-2">{{ route.params.email }}</h2>
      </div>
      <div class="sub-section server-list-tab">
        <div class="row justify-content-between align-items-center">
          <div class="row mb-5 pe-0">
            <div class="col-12">
              <!-- <form method="POST" action="{{ route('edit_user_permissions') }}"> -->
              <div class="card-item p-4 mb-4 support-item flex-column">
                <h3>{{ $t('Permissions') }}</h3>
                <br />
                <!-- <input type="hidden" name="user_id" value="{{ $user_id }}"> -->
                <div class="well" id="invitePermissions">
                  <label class="checkbox-inline">
                    <input type="checkbox" name="profile" v-model="profile" />
                    {{ $t('permission_detail_1') }}
                    
                  </label>
                  <br />
                  <label class="checkbox-inline">
                    <input type="checkbox" name="contacts" v-model="contacts" />
                    {{ $t('permission_detail_2') }}
                  </label>
                  <br />
                  <label class="checkbox-inline">
                    <input type="checkbox" name="products" v-model="products" />
                    {{ $t('permission_detail_3') }}
                  </label>
                  <br />
                  <label class="checkbox-inline">
                    <input
                      type="checkbox"
                      name="manageproducts"
                      v-model="manageproducts"
                    />
                    {{ $t('permission_detail_4') }}
                    
                  </label>
                  <br />
                  <label class="checkbox-inline">
                    <input
                      type="checkbox"
                      name="productsso"
                      v-model="productsso"
                    />
                    {{ $t('permission_detail_5') }}
                    
                  </label>
                  <br />
                  <label class="checkbox-inline">
                    <input type="checkbox" name="domains" v-model="domains" />
                    {{ $t('permission_detail_6') }}
                    
                  </label>
                  <br />
                  <label class="checkbox-inline">
                    <input
                      type="checkbox"
                      name="managedomains"
                      v-model="managedomains"
                    />
                    {{ $t('permission_detail_7') }}
                    
                  </label>
                  <br />
                  <label class="checkbox-inline">
                    <input type="checkbox" name="invoices" v-model="invoices" />
                    {{ $t('permission_detail_8') }}
                    
                  </label>
                  <br />
                  <label class="checkbox-inline">
                    <input type="checkbox" name="quotes" v-model="quotes" />
                    {{ $t('permission_detail_9') }}
                    
                  </label>
                  <br />
                  <label class="checkbox-inline">
                    <input type="checkbox" name="tickets" v-model="tickets" />
                    {{ $t('permission_detail_10') }}
                    
                  </label>
                  <br />
                  <label class="checkbox-inline">
                    <input
                      type="checkbox"
                      name="affiliates"
                      v-model="affiliates"
                    />
                    {{ $t('permission_detail_11') }}
                    
                  </label>
                  <br />
                  <label class="checkbox-inline">
                    <input type="checkbox" name="emails" v-model="emails" />
                    {{ $t('permission_detail_12') }}
                    
                  </label>
                  <br />
                  <label class="checkbox-inline">
                    <input type="checkbox" name="orders" v-model="orders" />
                    {{ $t('permission_detail_13') }}
                    
                  </label>
                  <br />
                </div>
                <button class="btn btn-dark mt-4" @click="saveChanges()">
                  {{ $t('Save_Changes') }}
                </button>
              </div>
              <!-- </form> -->
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
import { useRoute } from "vue-router";
import useAuth from "@/composables/auth";
import { showLoader } from "@/plugins/loading.js";
// toast
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
const $toast = useToast();

const route = useRoute();

const commonApi = commonApis();
const store = useStore();
const user = computed(() => store.state.auth.user);

// permission values
const profile = ref(false);
const contacts = ref(false);
const products = ref(false);
const manageproducts = ref(false);
const productsso = ref(false);
const domains = ref(false);
const managedomains = ref(false);
const invoices = ref(false);
const quotes = ref(false);
const tickets = ref(false);
const affiliates = ref(false);
const emails = ref(false);
const orders = ref(false);

const permissions = ref([]);

const params = ref({
  client_id: user.value.client_id,
  orderby: "",
  order: "",
});

function formatDate(date) {
  return new Date(date).toISOString().slice(0, 10);
}

const getPermissions = () => {
  showLoader(true);

  commonApi
    .runPostApi("/get_permission_detail_per_ser", {
      user_id: route.params.id,
    })
    .then((res) => {
      showLoader(false);
      permissions.value = res.data.permissions;
      resetPermissionStaets();
    })
    .catch((e) => {
      showLoader(false);
      console.log(e);
    });
};

const resetPermissionStaets = () => {
  permissions.value.forEach((item) => {
    if (item === "profile") {
      profile.value = true;
    } else if (item === "contacts") {
      contacts.value = true;
    } else if (item === "products") {
      products.value = true;
    } else if (item === "manageproducts") {
      manageproducts.value = true;
    } else if (item === "productsso") {
      productsso.value = true;
    } else if (item === "domains") {
      domains.value = true;
    } else if (item === "managedomains") {
      managedomains.value = true;
    } else if (item === "invoices") {
      invoices.value = true;
    } else if (item === "quotes") {
      quotes.value = true;
    } else if (item === "tickets") {
      tickets.value = true;
    } else if (item === "affiliates") {
      affiliates.value = true;
    } else if (item === "emails") {
      emails.value = true;
    } else if (item === "orders") {
      orders.value = true;
    }
  });
};

getPermissions();

const saveChanges = () => {
  showLoader(true);

  commonApi
    .runPostApi("/edit_user_permissions", {
      user_id: route.params.id,
      profile: profile.value,
      contacts: contacts.value,
      products: products.value,
      manageproducts: manageproducts.value,
      productsso: productsso.value,
      domains: domains.value,
      managedomains: managedomains.value,
      invoices: invoices.value,
      quotes: quotes.value,
      tickets: tickets.value,
      affiliates: affiliates.value,
      emails: emails.value,
      orders: orders.value,
    })
    .then((res) => {
      showLoader(false);
      if (res.data.result == "success") {
        $toast.success("Successfully edited permissions!");
      } else $toast.warning("Cannot connect to whmcs api!");
      //
    })
    .catch((e) => {
      showLoader(false);
      console.log(e);
    });
};
</script>

<style scoped>
</style>
