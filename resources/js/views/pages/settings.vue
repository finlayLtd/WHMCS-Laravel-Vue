<template>
  <section class="overview">
    <div class="container">
      <div
        class="d-flex flex-column justify-content-start align-items-start title-button-wrapper"
      >
        <div class="overview-header">
          <h2 class="title mb-0">{{ $t('Settings') }}</h2>
        </div>
      </div>

      <div class="sub-section overview-tab">
        <div class="row justify-content-between align-items-center">
          <div class="row mb-2 mb-lg-5 pe-0">
            <div class="col-md-12 d-flex justify-content-start pe-0 flex-wrap">
              <!-- <ul
                style="overflow-x: unset"
                class="nav nav-pills mb-3 mb-md-0 order-1 order-md-2 mb-lg-0 flex-nowrap"
                id="pills-tab"
                role="tablist"
              >
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link active"
                    id="pills-overview-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-overview"
                    type="button"
                    role="tab"
                    aria-controls="pills-overview"
                    aria-selected="true"
                  >
                    Profile
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="pills-analytics-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-analytics"
                    type="button"
                    role="tab"
                    aria-controls="pills-analytics"
                    aria-selected="false"
                  >
                    Security
                  </button>
                </li>
              </ul> -->
              <ul
                style="overflow-x: unset"
                class="nav nav-pills mb-3 mb-md-0 order-1 order-md-2 mb-lg-0 flex-nowrap"
                id="pills-tab"
                role="tablist"
              >
                <li class="nav-item" role="presentation">
                  <!-- <a href="{{ url('/settings') }}"> -->
                  <button
                    class="nav-link active"
                    id="pills-overview-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-overview"
                    type="button"
                    role="tab"
                    aria-controls="pills-overview"
                    aria-selected="true"
                  >
                  {{ $t('Your_Profile') }}
                  </button>
                  <!-- </a> -->
                </li>
                <li class="nav-item" role="presentation">
                  <!-- <a href="{{ url('/settings_password') }}"> -->
                  <button
                    class="nav-link"
                    id="pills-analytics-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-analytics"
                    type="button"
                    role="tab"
                    aria-controls="pills-analytics"
                    aria-selected="false"
                  >
                  {{ $t('Change_Password') }}
                  </button>
                  <!-- </a> -->
                </li>
                <li class="nav-item" role="presentation">
                  <!-- <a href="{{ url('/settings_userManage') }}"> -->
                  <button
                    class="nav-link"
                    id="pills-userManagement-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-userManagement"
                    type="button"
                    role="tab"
                    aria-controls="pills-userManagement"
                    aria-selected="false"
                  >
                  {{ $t('User_Management') }}
                  </button>
                  <!-- </a> -->
                </li>
                <li class="nav-item" role="presentation">
                  <!-- <a href="{{ url('/settings_emailHistory') }}"> -->
                  <button
                    class="nav-link"
                    id="pills-emails-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-emails"
                    type="button"
                    role="tab"
                    aria-controls="pills-emails"
                    aria-selected="false"
                  >
                  {{ $t('Email_History') }}
                  </button>
                  <!-- </a> -->
                </li>
              </ul>
            </div>
          </div>

          <div class="tab-content settings-tab-content" id="pills-tabContent">
            <!--overview-->
            <div
              class="tab-pane fade show active"
              id="pills-overview"
              role="tabpanel"
              aria-labelledby="pills-overview-tab"
            >
              <div class="tab-inner mb-3">
                <div class="row">
                  <h3 class="title mb-4">{{ $t('Your_Profile') }}</h3>
                </div>
                <div class="divider"></div>
                <!-- @if(in_array('profile', Auth::user()->permissions)) -->
                <div class="row px-2 pt-4 px-lg-4 pt-lg-4">
                  <div class="col-12 col-lg-6 tab-inner py-0 p-mb-0">
                    <p class="fs-13-5">{{ $t('Email') }}</p>
                    <div class="overview-input mb-4">
                      <div class="d-inline">
                        <input
                          type="text"
                          id="disabled_email"
                          name="disabled_email"
                          placeholder="Email"
                          disabled
                          v-model="clientDetails.email"
                        />
                      </div>
                    </div>
                    <p class="fs-13-5">{{ $t('First_Name') }}</p>
                    <div class="overview-input mb-4">
                      <div class="d-inline">
                        <input
                          type="text"
                          id="firstname"
                          name="firstname"
                          placeholder="First Name"
                          required
                          v-model="clientDetails.firstname"
                        />
                      </div>
                    </div>

                    <p class="fs-13-5">{{ $t('Last_Name') }}</p>
                    <div class="overview-input mb-4">
                      <input
                        type="text"
                        id="lastname"
                        name="lastname"
                        placeholder="Last Name"
                        required
                        v-model="clientDetails.lastname"
                      />
                      <!-- value="{{ Auth::user()->lastname }}" -->
                    </div>
                    <div class="overview-button-wrapper pt-0">
                      <button
                        @click="
                          change_name(
                            clientDetails.firstname,
                            clientDetails.lastname
                          )
                        "
                        class="btn-dark px-4 me-2 hover-dark-light"
                      >
                      {{ $t('Change_name') }}
                      </button>
                    </div>
                  </div>
                </div>
                <!-- @else @include('component.no-permission-go-back') @endif -->
              </div>
            </div>

            <!--password-->
            <div
              class="tab-pane fade"
              id="pills-analytics"
              role="tabpanel"
              aria-labelledby="pills-analytics-tab"
            >
              <div class="tab-inner mb-3">
                <div class="row">
                  <h3 class="title mb-4">{{ $t('Change_Password') }}</h3>
                </div>
                <div class="divider"></div>
                <!-- @if(in_array('profile', Auth::user()->permissions)) -->
                <div class="row px-2 pt-4 px-lg-4 pt-lg-4">
                  <form class="form-horizontal using-password-strength">
                    <div id="currentpwBox" class="form-group">
                      <label for="currentpw" class="col-sm-4 control-label"
                        >{{ $t('Current_Password') }}</label
                      >
                      <div class="col-sm-5" style="position: relative">
                        <input
                          type="password"
                          class="form-control"
                          name="currentpw"
                          id="currentpw"
                          autocomplete="off"
                        />
                        <img
                          src="assets/img/eye.svg"
                          class="settings-password-img icon-password eye-closed"
                        />
                        <img
                          src="assets/img/eye-open.svg"
                          class="settings-password-img icon-password eye-open"
                          style="display: none"
                        />
                        <br />
                      </div>
                    </div>
                    <div
                      id="newPassword1"
                      class="form-group has-feedback has-success"
                    >
                      <label
                        for="inputNewPassword1"
                        class="col-sm-4 control-label"
                        >{{ $t('New_Password') }}</label
                      >
                      <div class="col-sm-5" style="position: relative">
                        <input
                          type="password"
                          class="form-control"
                          name="newpw"
                          id="inputNewPassword1"
                          autocomplete="off"
                        />
                        <img
                          src="assets/img/eye.svg"
                          class="settings-password-img icon-password eye-closed"
                        />
                        <img
                          src="assets/img/eye-open.svg"
                          class="settings-password-img icon-password eye-open"
                          style="display: none"
                        />
                        <br />

                        <div class="progress" id="passwordStrengthBar">
                          <div
                            class="progress-bar progress-bar-success"
                            role="progressbar"
                            aria-valuenow="0"
                            aria-valuemin="0"
                            aria-valuemax="100"
                            style="width: 0%"
                          >
                            <span class="sr-only">{{ $t('Password_Rating') }}: 0%</span>
                          </div>
                        </div>

                        <!-- <div class="alert alert-info">
                          <strong>{{ __("messages.tips") }}</strong
                          ><br />{{ __("messages.tips_content1") }}<br />{{
                            __("messages.tips_content4")
                          }}<br />{{ __("messages.tips_content3") }}
                        </div> -->
                      </div>
                    </div>
                    <div
                      id="newPassword2"
                      class="form-group has-feedback has-success"
                    >
                      <label
                        for="inputNewPassword2"
                        class="col-sm-4 control-label"
                        >{{ $t('Confirm_New_Password') }}</label
                      >
                      <div class="col-sm-5" style="position: relative">
                        <input
                          type="password"
                          class="form-control"
                          name="confirmpw"
                          id="inputNewPassword2"
                          autocomplete="off"
                        />
                        <img
                          src="assets/img/eye.svg"
                          class="settings-password-img icon-password eye-closed"
                        />
                        <img
                          src="assets/img/eye-open.svg"
                          class="settings-password-img icon-password eye-open"
                          style="display: none"
                        />
                        <div id="inputNewPassword2Msg"></div>
                      </div>
                    </div>
                    <div class="overview-button-wrapper pt-0 mt-4">
                      <div class="col-sm-5">
                        <button
                          id="submitButton"
                          class="btn-dark px-4 me-2 hover-dark-light"
                          disabled="disabled"
                        >
                        {{ $t('Save_changes') }}
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- @else @include('component.no-permission-go-back') @endif -->
              </div>
            </div>

            <!-- userManagement -->
            <div
              class="tab-pane fade"
              id="pills-userManagement"
              role="tabpanel"
              aria-labelledby="pills-userManagement-tab"
            >
              <!-- @if(Auth::user()->originUserData['email'] == Auth::user()->email) -->
              <div class="tab-inner mb-3">
                <div class="row">
                  <h3 class="title mb-4">
                    {{ $t('User_Management') }} ({{ users_list.length }}
                    {{ users_list.length === 1 ? "User" : "Users" }} {{ $t('found') }})
                  </h3>
                </div>
                <div class="divider"></div>
                <div class="row px-2 pt-4 px-lg-4 pt-lg-4">
                  <div class="w-100 mb-5 support-table">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">{{ $t('Email_Address') }} / {{ $t('Last_Login') }}</th>
                          <th scope="col">{{ $t('Actions') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="item in users_list" :key="item.id">
                          <td>
                            {{ item.email }}
                            <span class="badge bg-info" v-if="item.is_owner"
                              >{{ $t('Owner') }}</span
                            >
                            <br />
                          </td>
                          <td>
                            <router-link
                              v-if="item.is_owner == false"
                              :to="{
                                name: 'manageUser-detail',
                                params: { id: item.id, email: item.email },
                              }"
                            >
                              <button
                                class="btn btn-dark btn-sm btn-manage-permissions managePermissionBtn"
                                :disabled="item.is_owner"
                                style="margin-right: 5px"
                              >
                              {{ $t('Manage_Permissions') }}
                              </button>
                            </router-link>

                            <button
                              v-else
                              class="btn btn-dark btn-sm btn-manage-permissions managePermissionBtn"
                              :disabled="item.is_owner"
                              style="margin-right: 5px"
                            >
                            {{ $t('Manage_Permissions') }}
                            </button>

                            <button
                              class="btn btn-danger btn-sm btn-remove-user"
                              :disabled="item.is_owner"
                              @click="removeAccess(item.id)"
                            >
                            {{ $t('Remove_Access') }}
                            </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row">
                  <h3 class="title mb-4">{{ $t('Invite_New_User') }}</h3>
                </div>
                <div class="divider"></div>
                <div class="row px-2 pt-4 px-lg-4 pt-lg-4">
                  <p>
                    {{ $t('invite_desc') }}
                    
                  </p>
                  <div class="mb-4">
                    <!-- method="POST" action="{{ route('invite_user') }}" -->
                    <div>
                      <input
                        type="email"
                        id="invite_email"
                        name="invite_email"
                        placeholder="Email address to send invite"
                        required
                        class="form-control"
                        v-model="invite_email"
                      />
                    </div>
                    <div class="form-group selectBoxes mt-4">
                      <label class="radio-inline" style="padding-right: 20px">
                        <input
                          type="radio"
                          name="permissions"
                          value="all"
                          checked="checked"
                          @click="selectAllPermissions()"
                        />
                        {{ $t('All_Permissions') }}
                      </label>
                      <label class="radio-inline">
                        <input
                          type="radio"
                          name="permissions"
                          value="choose"
                          @click="permissionListVisible = true"
                        />
                        {{ $t('Choose_Permissions') }}
                      </label>
                      <div
                        class="well"
                        id="invitePermissions"
                        v-show="permissionListVisible"
                      >
                        <label class="checkbox-inline">
                          <input
                            type="checkbox"
                            name="profile"
                            v-model="profile"
                          />
                          
                          {{ $t('permission_detail_1') }}
                        </label>
                        <br />
                        <label class="checkbox-inline">
                          <input
                            type="checkbox"
                            name="contacts"
                            v-model="contacts"
                          />
                          {{ $t('permission_detail_2') }}
                        </label>
                        <br />
                        <label class="checkbox-inline">
                          <input
                            type="checkbox"
                            name="products"
                            v-model="products"
                          />
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
                          <input
                            type="checkbox"
                            name="domains"
                            v-model="domains"
                          />
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
                          <input
                            type="checkbox"
                            name="invoices"
                            v-model="invoices"
                          />
                          {{ $t('permission_detail_8') }}
                        </label>
                        <br />
                        <label class="checkbox-inline">
                          <input
                            type="checkbox"
                            name="quotes"
                            v-model="quotes"
                          />
                          {{ $t('permission_detail_9') }}
                        </label>
                        <br />
                        <label class="checkbox-inline">
                          <input
                            type="checkbox"
                            name="tickets"
                            v-model="tickets"
                          />
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
                          <input
                            type="checkbox"
                            name="emails"
                            v-model="emails"
                          />
                          {{ $t('permission_detail_12') }}
                        </label>
                        <br />
                        <label class="checkbox-inline">
                          <input
                            type="checkbox"
                            name="orders"
                            v-model="orders"
                          />
                          {{ $t('permission_detail_13') }}
                        </label>
                        <br />
                      </div>
                    </div>
                    <button
                      @click="sendInvite()"
                      class="btn btn-dark mt-4"
                      :disabled="invite_email == ''"
                    >
                    {{ $t('Send_Invite') }}
                    </button>

                    <!-- <form
                      id="remove-user-form"
                      method="POST"
                      action="{{ route('remove_access') }}"
                    >
                      @csrf
                      <input
                        type="hidden"
                        id="remove-user-id"
                        name="user_id"
                        value=""
                      />
                    </form> -->
                  </div>
                </div>
              </div>
              <!-- @else @include('component.no-permission-go-back') @endif -->
            </div>

            <!-- email history -->
            <div
              class="tab-pane fade"
              id="pills-emails"
              role="tabpanel"
              aria-labelledby="pills-emails-tab"
            >
              <div class="tab-inner mb-3">
                <div class="row">
                  <h3 class="title mb-4">{{ $t('Email_History') }}</h3>
                </div>
                <div class="divider"></div>
                <!-- @if(in_array('emails', Auth::user()->permissions)) -->
                <div class="row px-2 pt-4 px-lg-4 pt-lg-4">
                  <div class="w-100 mb-5 support-table">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">{{ $t('ID') }}</th>
                          <th scope="col">{{ $t('Date_Sent') }}</th>
                          <th scope="col">{{ $t('Message subject') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- @foreach($emails as $email) -->
                        <tr v-if="!emailsList || emailsList.length === 0">
                          <td colspan="3" style="text-align: center">
                            <h5 style="margin-top: 20px">{{ $t('No_emails') }}</h5>
                          </td>
                        </tr>
                        <tr v-else v-for="email in emailsList" :key="email.id">
                          <td>#{{ email.id }}</td>
                          <td>{{ formatDate(email.date) }}</td>
                          <td class="date-cell">{{ email.subject }}</td>
                        </tr>
                        <!-- @endforeach -->
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- @else @include('component.no-permission-go-back') @endif -->
              </div>
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
// toast
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
const $toast = useToast();

const commonApi = commonApis();
const store = useStore();
const user = computed(() => store.state.auth.user);
const emailsList = ref([]);
const users_list = ref([]);
const clientDetails = ref({});
const permissionListVisible = ref(false);
const invite_email = ref("");

// permission values
const profile = ref(true);
const contacts = ref(true);
const products = ref(true);
const manageproducts = ref(true);
const productsso = ref(true);
const domains = ref(true);
const managedomains = ref(true);
const invoices = ref(true);
const quotes = ref(true);
const tickets = ref(true);
const affiliates = ref(true);
const emails = ref(true);
const orders = ref(true);

// const status = ref([]);
const params = ref({
  client_id: user.value.client_id,
  orderby: "",
  order: "",
});

const selectAllPermissions = () => {
  permissionListVisible.value = false;
  profile.value = true;
  contacts.value = true;
  products.value = true;
  manageproducts.value = true;
  productsso.value = true;
  domains.value = true;
  managedomains.value = true;
  invoices.value = true;
  quotes.value = true;
  tickets.value = true;
  affiliates.value = true;
  emails.value = true;
  orders.value = true;
};

const change_name = (firstname, lastname) => {
  showLoader(true);

  commonApi
    .runPostApi("/change_name", {
      client_id: user.value.client_id,
      firstname: firstname,
      lastname: lastname,
    })
    .then((res) => {
      showLoader(false);
      if (res.data.result == "success") {
        useAuth().getUser();
        $toast.success("Successfully changed your profile!");
      } else $toast.warning("Cannot connect to whmcs api.");
      //
    })
    .catch((e) => {
      showLoader(false);
      console.log(e);
    });
};

const getSettingsData = () => {
  showLoader(true);
  commonApi
    .runGetApi("/get-profileData", params.value)
    .then((res) => {
      showLoader(false);
      emailsList.value = res.data.emails;
      users_list.value = res.data.users_list;
      clientDetails.value = res.data.clientDetails;
    })
    .catch((e) => {
      showLoader(false);
      console.log(e);
    });
};

const removeAccess = (id) => {
  showLoader(true);

  commonApi
    .runPostApi("/remove_access", {
      user_id: id,
    })
    .then((res) => {
      showLoader(false);
      if (res.data.result == "success") {
        users_list.value = res.data.users_list;
        $toast.success("Successfully removed user");
      } else $toast.warning("Cannot connect to whmcs api.");
    })
    .catch((e) => {
      showLoader(false);
      console.log(e);
    });
};

const sendInvite = () => {
  showLoader(true);

  commonApi
    .runPostApi("/invite_user", {
      invite_email: invite_email.value,
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
        $toast.success("Successfully sent invite to the email address");
      } else $toast.warning("Cannot connect to whmcs api.");
      //
    })
    .catch((e) => {
      showLoader(false);
      console.log(e);
    });
};

getSettingsData();

function formatDate(date) {
  return new Date(date).toISOString().slice(0, 10);
}
</script>

<style scoped>
</style>
