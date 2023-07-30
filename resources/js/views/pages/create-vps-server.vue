<template>
  <section class="dashboard">
    <div class="container">
      <h2 class="title">Create Server</h2>

      <div class="sub-section">
        <h3 class="sub-title">Choose a OS</h3>
        <div class="row server-item-wrapper">
            <div
              v-for="(os, key) in oslist"
              :class=" selected_os == key ? 'server-item display-distributions selected-os' : 'server-item display-distributions'"
              :data-dist="key"
              @click="selected_os = key, selected_osid=null"
              v-show="ucfirst(key) != 'Others'"
              :key="key"
            >
              <img :src="'assets/img/' + key + '-logo.png'" />
              <span>{{ ucfirst(key) }}</span>
            </div>
        </div>
      </div>

      <div class="sub-section">
        <h3 class="sub-title">Choose a OS Version</h3>
        <div
          v-for="(kind, index) in os_kind"
          :key="index"
          :data-dist="kind"
          v-show="selected_os == kind"
        >
          <div
            class="row server-item-wrapper os-version-wrapper flex-column align-items-start"
          >
            <div
              v-for="(os, osid) in oslist[kind]"
              :key="osid"
              class=""
              :class="selected_osid == osid ? 'datacenter-item system-item selected-os' : 'datacenter-item system-item'"
              :osid="osid"
              @click="selected_osid = osid, selected_os_name = os.name, selected_configid = os.config_id"
              :os-name-iso="os.name"
              :config-id="os.config_id"
            >
              <img :src="'assets/img/' + kind + '-logo.png'" />
              <span>{{ os.name }}</span>
            </div>
          </div>
        </div>
      </div>

      <div class="sub-section">

        <!-- server list -->

        <h3 class="sub-title">Choose a Datacenter region</h3>

        <div v-if="products.length > 0">
          <div v-for="(group, key) in product_group" :key="key">
            <div class="row" @click="selected_group_id = key">
              <div class="image-wrapper mb-2" style="font-size: 20px" >
                <img
                  :src="
                    key == 2
                      ? 'assets/img/flag-nl.png'
                      : 'assets/img/flag-en.png'
                  "
                  style="width: 28px"
                  alt=""
                />
                <span v-if="key == 2">&nbsp;Netherlands</span>
                <span v-else>&nbsp;USA</span>
              </div>
              <div
                v-for="product in products.filter((p) => p.gid == key)"
                :key="product.pid"
                class="col-md-3 m-1 mb-4"
                @click="selectProduct(product)"
              >
                <div
                  :class="selected_product && selected_product.pid == product.pid ? 'card-item data-region-card p-4 plan-item selected-plan' : 'card-item data-region-card p-4 plan-item'"
                  style="cursor: pointer"
                  :product-id="product.pid"
                >
                  <div class="server-name mb-4 d-flex justify-content-between">
                    <span class="name">{{ product.name }}</span>
                    <span v-if="product.stockcontrol">
                      <span
                        :class="[
                          product.stocklevel != 0
                            ? 'stockTitle'
                            : 'stockUnavailable',
                        ]"
                      >
                        {{ product.stocklevel }} Available
                      </span>
                    </span>
                  </div>
                  <div class="server-price mb-4" style="background: none">
                    <span class="price"
                      >€<span class="price-value">{{
                        product.pricing.EUR.monthly
                      }}</span>
                      <span class="month">/ month</span>
                    </span>
                  </div>
                  <div class="">
                    <ul class="server-features">
                      <li>
                        <img src="assets/img/cpu.png" alt="" />{{
                          product.server_info[0]
                        }}
                      </li>
                      <li>
                        <img src="assets/img/ram.png" alt="" />{{
                          product.server_info[1]
                        }}
                      </li>
                      <li>
                        <img src="assets/img/hard-disk.png" alt="" />{{
                          product.server_info[2]
                        }}
                      </li>
                      <li>
                        <img src="assets/img/speedometer.png" alt="" />{{
                          product.server_info[3]
                        }}
                      </li>
                      <li>
                        <img src="assets/img/cable.png" alt="" />{{
                          product.server_info[4]
                        }}
                      </li>
                    </ul>
                  </div>
                  <div class="more-details-wrapper mt-3">
                    <div class="more-details-content">
                      <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Asperiores ullam repellendus aspernatur placeat rem,
                        molestiae veritatis porro, facilis quo, repudiandae odio
                        quia debitis iste nemo assumenda omnis? Quo,
                        dignissimos, ducimus!
                      </p>
                    </div>
                    <a
                      class="btn btn-light btn-chevron d-lg-block hover-light-dark toggle-more-detail"
                      >More Details</a
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- server list block end -->
      </div>

      <div class="sub-section">
        <h3 class="sub-title">Configure Server</h3>
        <div class="row">
          <div class="configure-server-form">
            <div class="mb-3">
              <label for="email" class="form-label">VPS Hostname</label>
              <div style="display: flex">
                <input
                  type="text"
                  class="form-control"
                  placeholder="hostname"
                  id="hostname"
                  name="hostname"
                  v-model="hostname"
                />
                <button
                  type="button"
                  class="btn btn-link"
                  style="padding: 10px"
                  id="randomizeButton"
                  @click="hostname = randomizehostname()"
                >
                  Random
                </button>
              </div>
            </div>
            <div class="mb-4">
              <label for="password" class="form-label">VPS Password</label>
              <div style="display: flex" class="mb-4">
                <input
                  type="text"
                  class="form-control"
                  placeholder="••••••••••"
                  id="password"
                  name="password"
                  required
                  disabled
                  v-model="hostpassword"
                />
                <button
                  type="button"
                  class="btn btn-link"
                  style="padding: 10px"
                  id="randomizeButton_password"
                  @click="hostpassword = randomizePassword()"
                >
                  Random
                </button>
              </div>
              <div class="progress" id="passwordStrengthBar">
                <div
                  class="progress-bar progress-bar-success"
                  role="progressbar"
                  aria-valuenow="100"
                  aria-valuemin="0"
                  aria-valuemax="100"
                  :style="hostpassword?'width: 100%':'width: 0%'"
                >
                  <span class="rating">Password Rating: 100%</span>
                </div>
              </div>
              <div
                class="alert alert-info"
                style="text-align: left; position: inherit"
              >
                <strong>Tips for a good password</strong>
                <br />Use both upper and lowercase characters <br />Include at
                least one symbol (only ! and @) <br />Don't use dictionary words
                and special characters
              </div>
            </div>
            <div class="mb-3 text-end">
              <button
                id="create-btn"
                type="submit"
                class="btn btn-dark hover-dark-light"
                @click="clickCreate()"
                
              >
                Create Server
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- modal -->
    <div class="modal modal-ticket" v-if="openModal">
      <div class="modal-inner">
        <div class="modal-close" @click="openModal = false">
          <img class="close-dark" src="assets/img/close.svg" alt="" />
          <img class="close-light" src="assets/img/close-light.svg" alt="" />
        </div>
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title">
              <h2>Review & Checkout</h2>
            </div>
          </div>
          <div class="modal-main">
            <div class="vps-info mb-2">
              <div class="vps-info-review card">
                <h6 class="sub-title">VPS info</h6>
                <hr />
                <div class="vps-name">
                  {{ selected_product ? selected_product.name : "" }}
                </div>
                <div class="vps-price">
                  €{{ selected_product ? selected_product.pricing.EUR.monthly : "" }}/month
                </div>
                <div class="vps-groupname">
                  <div v-for="(group, key) in product_group" :key="key" v-show="selected_group_id == key">
                    <div class="row">
                      <div class="image-wrapper mb-2" style="font-size: 20px" >
                        <img
                          :src="
                            key == 2
                              ? 'assets/img/flag-nl.png'
                              : 'assets/img/flag-en.png'
                          "
                          style="width: 28px"
                          alt=""
                        />
                        <span v-if="key == 2">&nbsp;Netherlands</span>
                        <span v-else>&nbsp;USA</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="vps-hostname">
                  Host Name: {{ hostname }}
                </div>
                <div class="vps-ipnum">
                  Number of IPs: 1
                </div>
                <div class="vps-os">
                  {{ selected_os_name?selected_os_name:"" }}
                </div>
              </div>
            </div>

            <div class="user-info mt-2 mb-2">
              <div class="user-info-review card">
                <h6 class="sub-title">User info</h6>
                <hr />
                <div class="user-name">Name: {{ user.name }}</div>
                <div class="user-email">Email: {{ user.email }}</div>
                <div class="user-currency-code">Currency: EUR</div>
              </div>
            </div>

            <div class="payment-info mt-2">
              <div class="payment-info-review card">
                <h6 class="sub-title">Payment Method</h6>
                <hr />

                <div
                  v-for="(payment_method, key) in payment_methods"
                  :key="key"
                  class="form-check"
                >
                  <input
                    type="radio"
                    class="form-check-input paymentMethod"
                    name="paymentMethod"
                    v-model="paymentmethod"
                    :value="payment_method.module"
                    :checked="key == 0"
                  />
                  <label
                    class="form-check-label"
                    :for="'paymentMethod' + key"
                    >{{ payment_method.displayname }}</label
                  >
                </div>

                <!-- added newly to implement apply credit -->
                <div class="form-check">
                  <input
                    type="radio"
                    class="form-check-input paymentMethod"
                    name="paymentMethod"
                    v-model="paymentmethod"
                    value="credit"
                  />
                  <label class="form-check-label" for="paymentMethod"
                    >Account Funds (available €{{ user.credit }})</label
                  >
                </div>
              </div>
            </div>

            <button
              class="btn-dark d-block w-100 mt-5"
              id="continue-order"
              @click="clickCheckout()"
            >
              CheckOut
            </button>
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
import { useRouter } from 'vue-router';

const router = useRouter();
const $toast = useToast({
      toastOptions: {
        zIndex: 99999, // set a high z-index value
      },
    });

const commonApi = commonApis();
const openModal = ref(false);
const store = useStore();
const user = computed(() => store.state.auth.user);

const products = ref([]);
const product_group = ref(null);
const oslist = ref(null);
const os_kind = ref([]);
const payment_methods = ref([]);

// selected Values
const selected_os = ref("windows");
const selected_osid = ref(null);
const selected_configid = ref(null);
const selected_product = ref(null);
const selected_os_name = ref(null);
const selected_group_id = ref(null);
const hostname = ref("");
const hostpassword = ref("");
const paymentmethod = ref("cryptomusgateway")

const params = ref({
  client_id: user.value.client_id,
});

function clickCheckout(){
  if(paymentmethod.value == 'credit' && selected_product.value.pricing.EUR.monthly > user.value.credit) {
    openModal.value = false;
    $toast.error("Please choose the OS you want to use on your VPS.");
    return;
  }
  showLoader(true);
  commonApi
    .runPostApi("/create-vps",{
      hostname: hostname.value,
      pwd: hostpassword.value,
      paymentMethod: paymentmethod.value,
      product_id: selected_product.value.pid,
      config_id: selected_configid.value,
    })
    .then((res) => {
      showLoader(false);
      if (res.data.result == "success") {
        let id = res.data.order_id;
        openModal.value = false;
        $toast.success("Successfully created vps.");
        router.push({name: 'overview', params: {id: id}})
      }
      else{
        $toast.error(res.data.result);
      }
    })
    .catch((e) => {
      showLoader(false);
      console.log(e);
    });
  return;
}

function clickCreate(){
  if(selected_osid.value == null) {
    $toast.error("Please choose the OS you want to use on your VPS.");
    return;
  }
  if(selected_os.value == null) {
    $toast.error("Please choose the OS you want to use on your VPS.");
    return;
  }
  if(selected_product.value == null) {
    $toast.error("Please choose the VPS you want.");
    return;
  }
  if(hostpassword.value == "") {
    $toast.error("Password strength must be greater than 100");
    return;
  }
  if(hostpassword.value == "") {
    $toast.error("Please input hostname.");
    return;
  }
  openModal.value = true;
  return;
}

function selectProduct(product){
  if(product.stocklevel != 0) selected_product.value = product;
  else {
    $toast.error("Out of stock!");
  }
}

const getCreateVpsServerData = () => {
  showLoader(true);
  commonApi
    .runGetApi("/create-vps-server", params.value)
    .then((res) => {
      showLoader(false);
      products.value = res.data.products;
      product_group.value = res.data.product_group;
      oslist.value = res.data.oslist;
      os_kind.value = res.data.os_kind;
      payment_methods.value = res.data.payment_methods;
      console.log(res.data);
    })
    .catch((e) => {
      showLoader(false);
      console.log(e);
    });
};

function randomizePassword(){
  var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@';
  var length = 12;
  var result = '';
  var uppercaseCount = 0;
  var specialCharCount = 0;
  var numberCount = 0; // add a counter for numbers
  for (var i = 0; i < length; i++) {
    var randomIndex = Math.floor(Math.random() * chars.length);
    var randomChar = chars.charAt(randomIndex);
    if (/[A-Z]/.test(randomChar)) {
    uppercaseCount++;
    } else if (/[\!\@]/.test(randomChar)) {
    specialCharCount++;
    }else if (/[0-9]/.test(randomChar)) { // check if the character is a number
    numberCount++;
    }
    result += randomChar;
  }
  if (uppercaseCount < 3 || specialCharCount < 2 || numberCount < 2) {
    return randomizePassword();
  }

  // Copy the generated hostname to the clipboard
  var copyTextarea = document.createElement('textarea');
  copyTextarea.value = result;
  document.body.appendChild(copyTextarea);
  copyTextarea.select();
  document.execCommand('copy');
  document.body.removeChild(copyTextarea);

  $toast.success("Copied password to clipboard");
  // showToast('Success', 'Copied hostname to clipboard', 'success');

  return result;
}

function randomizehostname(){
  var hostname = "";
  var possibleChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  for (var i = 0; i < 12; i++) {
    hostname += possibleChars.charAt(Math.floor(Math.random() * possibleChars.length));
  }
  // Copy the generated hostname to the clipboard
  var copyTextarea = document.createElement('textarea');
  copyTextarea.value = hostname;
  document.body.appendChild(copyTextarea);
  copyTextarea.select();
  document.execCommand('copy');
  document.body.removeChild(copyTextarea);

  $toast.success("Copied hostname to clipboard");
  console.log('Copied hostname to clipboard');
  return hostname;
}

getCreateVpsServerData();

function ucfirst(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}
</script>
  
  <style scoped>
  .v-toast{
    z-index: 9999 !important;
  }
</style>
