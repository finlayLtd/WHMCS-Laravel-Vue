<template>
  <section class="dashboard">
    <div class="container">
      <h2 class="title">{{ $t('Create_Server') }}</h2>
      <!-- new design on Choose a OS -->
      <div style="margin-top: 50px;">
        <div class="px-4 choose-os-div">
            <h2 class="choose-os-header">{{ $t('Choose_a_OS') }}</h2>
            <hr class="server-seprater">
            <div>
                <div class="choose-server-row">
                    <div class="single-os-div" :class="selected_os == index ? 'active-os-div' : ''"
                        v-for="(singleOs, index) in oslist" :key="index" @click="clickOSGroup(index)" v-show="ucfirst(index) != 'Others'">
                        <div>
                            <img :src="'assets/img/' + index + '-logo.png'" class="" alt="Os">
                            <p class="os-name">{{ ucfirst(index) }}</p>
                        </div>
                        <div class="p-0 dropdown">
                            <button class="os-drop-down-btn dropdown-toggle" id="dropdownMenuLink"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <div>
                                    <p v-if="selected_os_name && selected_os == index">{{ formattedOsName(selected_os_name) }}</p>
                                    <p v-else>{{ $t('Choose_a_OS_Version') }}</p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="6" viewBox="0 0 8 6"
                                        fill="none">
                                        <path d="M0.800003 0.833328L4 4.16666L7.2 0.833328" stroke="#171E26"
                                            stroke-width="1.2" />
                                    </svg>
                                </div>
                            </button>
                            <ul class="dropdown-menu border border-1 p-1" aria-labelledby="dropdownMenuLink">
                                <li 
                                  v-for="(os, osid) in oslist[selected_os]" 
                                  :key="osid" 
                                  :osid="osid" 
                                  :os-name-iso="os.name" 
                                  :config-id="os.config_id"
                                  @click="clickVersion(osid, os)"
                                >
                                  <a class="dropdown-item rounded"
                                  >
                                      {{ formattedOsName(os.name)  }}
                                  </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>

      <div style="margin: 30px 0;">
          <div class="px-4 choose-os-div">
              <h2 class="choose-os-header">Choose a Datecenter region</h2>
              <hr class="server-seprater">
              <div>
                  <div class="choose-server-row">
                    <template v-if="products.length > 0">

                      <div class="single-region-div" :class="selected_group_id == index ? 'active-os-div' : ''"
                          v-for="(singleOrigin, index) in product_group" :key="index" @click="selected_group_id = index">
                          <div>
                              <img :src="index == 2
                                ? 'assets/img/flag-nl.png'
                                : 'assets/img/flag-en.png'
                                " style="width: 28px" alt="" />
                              <p class="os-name" v-if="index == 2">{{ $t('Netherlands') }}</p>
                              <p class="os-name" v-else>{{ $t('USA') }}</p>
                              <!-- <img src="/assets/img/us.svg" class="" alt="Os"> -->
                          </div>
                      </div>
                    </template>
                  </div>
              </div>
          </div>
      </div>

      <div v-show="selected_group_id">
          <div class="px-4 choose-os-div pb-0">
              <h2 class="choose-os-header">Choose a Datecenter region</h2>
              <div v-if="products.length > 0">
                <div v-for="(group, key) in product_group" :key="key">
                  <div v-if="selected_group_id == key" class="mb-2">
                    <Table :data="products.filter((p) => p.gid == key)" :headings="tableHeader" :current_plan="current_plan">
                      <template #head()="scope">
                          123
                        </template>
                        <template #name="{ tdata }">
                          <div class="availability available">
                            <span class="greenDot" v-if="tdata.stocklevel != 0"></span>
                            <span class="redDot" v-else></span>
                            <span class="text">{{ tdata.name }}</span>
                          </div>
                        </template>
                        <template #memory="{ tdata }">
                            <p>{{ tdata.server_info[1] }}</p>
                        </template>
                        <template #vcpus="{ tdata }">
                            <p>{{ tdata.server_info[0] }}</p>
                        </template>
                        <template #bandwidth="{ tdata }">
                            <p>{{ tdata.server_info[3] }}</p>
                        </template>
                        <template #storage="{ tdata }">
                            <p>{{ tdata.server_info[2] }}</p>
                        </template>
                        <template #con="{ tdata }">
                            <p>{{ tdata.server_info[4] }}</p>
                        </template>
                        <template #mprice="{ tdata }">
                            <p v-if="current_plan == 'monthly'">€{{ tdata.pricing.EUR.monthly }}</p>
                            <p v-if="current_plan == 'quarterly'">€{{ tdata.pricing.EUR.quarterly }}</p>
                            <p v-if="current_plan == 'semiannually'">€{{ tdata.pricing.EUR.semiannually }}</p>
                            <p v-if="current_plan == 'annually'">€{{ tdata.pricing.EUR.annually }}</p>
                        </template>
                        <template #isSelecterd="{ tdata }">
                            <div class="choose-btn-selected" v-if="selected_product && selected_product.pid == tdata.pid">
                                <img src="/assets/img/check.svg" alt="check">
                                <p>Selected</p>
                            </div>
                            <div :class="(tdata.stocklevel == 0)?' choose-btn disabled-choose':'choose-btn'" @click="selectProduct(tdata)" v-else>
                                <p>Choose</p>
                            </div>
                        </template>
                      </Table>
                  </div>
                </div>
              </div>

          </div>
      </div>

      <div class="container" style="margin-top: 30px;">

        <div class="row">
            <div class="col-12 col-lg-3 ps-lg-0">
                <div class="con-div mb-4" v-if="selected_product">
                    <h2 class="choose-os-header">Choose Billing Cycle</h2>
                    <hr class="server-seprater">
                    <select name="number_of_ips" id="number_of_ips" class="form-select" v-model="current_plan"
                      style="margin-right: 10px; margin-bottom: 10px; width: auto;">
                      <option v-for="item in plan_expected" :key="item" :value="item">
                          <template v-if="item == 'monthly'">€{{ selected_product.pricing.EUR.monthly }}&nbsp;EUR {{ item }}</template>
                          <template v-if="item == 'quarterly'">€{{ selected_product.pricing.EUR.quarterly }}&nbsp;EUR {{ item }}</template>
                          <template v-if="item == 'semiannually'">€{{ selected_product.pricing.EUR.semiannually }}&nbsp;EUR {{ item }}</template>
                          <template v-if="item == 'annually'">€{{ selected_product.pricing.EUR.annually }}&nbsp;EUR {{ item }}</template>
                      </option>
                    </select>
                </div>

                <div class="con-div">
                    <h2 class="choose-os-header">{{ $t('Number_of_IPs') }}</h2>
                    <hr class="server-seprater">
                    <select name="number_of_ips" id="number_of_ips" class="form-select" v-model="selected_number_of_ips"
                      style="margin-right: 10px; margin-bottom: 10px; width: auto;">
                      <option v-for="number in 60" :key="number" :value="number">
                        {{ number }} <span v-if="number > 1"> €{{ ((number - 1) * 2.5).toFixed(2) }}EUR</span>
                      </option>
                    </select>
                </div>
            </div>

            <div class="col-12 col-lg-9 pe-lg-0 config-2">
                <div class="con-div">
                    <h2 class="choose-os-header">Configure Server</h2>
                    <hr class="server-seprater">

                    <div>
                        <label for="hname" class="form-label form-label-vps">{{ $t('VPS_Hostname') }}</label>
                        <div class="form-filds">
                            <input class="form-control" type="text" v-model="hostname" id="hostname" name="hostname">
                            <p class="randome-btn" @click="hostname = randomizehostname()">{{ $t('Random') }}</p>
                        </div>
                    </div>
                    <div style="margin-top: 20px;">
                        <label for="hname" class="form-label form-label-vps">{{ $t('VPS_Password') }}</label>
                        <div class="form-filds">
                            <input class="form-control" type="text" id="password" name="password" required disabled v-model="hostpassword">
                            <p class="randome-btn" @click="hostpassword = randomizePassword()">{{ $t('Random') }}</p>
                        </div>
                    </div>

                    <div class="progress mt-4" id="passwordStrengthBar">
                      <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                        aria-valuemax="100" :style="hostpassword ? 'width: 100%' : 'width: 0%'">
                        <span class="rating">{{ $t('Password_Rating') }}: 100%</span>
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
  

                    <div class="d-flex justify-content-end">
                        <button class="btn create-server-btn" data-bs-toggle="modal" data-bs-target="#exampleModal"
                            @click="clickCreate()">Create Server</button>

                        <div class="modal modal-ticket" v-if="modelOpen">
                            <div class="model-child">
                                <div class="d-flex align-items-center justify-content-between model-header">
                                    <p class="model-header-text">{{ selected_product ? selected_product.name : "" }}</p>
                                    <p @click="modelOpen = false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 14 14" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5.58632 7.00173L0 12.5889L1.41432 14.003L7.00042 8.41605L12.5869 14.0035L14.0013 12.5894L8.41453 7.00173L14.0013 1.4141L12.5869 0L7.00042 5.5874L1.41432 0.000423431L0 1.41453L5.58632 7.00173Z"
                                                fill="white" />
                                        </svg>
                                    </p>
                                </div>

                                <div class="d-flex align-items-center justify-content-between model-body-li">
                                    <p class="model-body-key capitalize">{{ current_plan }}</p>
                                    <p class="model-body-value" v-if="current_plan == 'monthly'">€{{ selected_product ? selected_product.pricing.EUR.monthly : "" }}</p>
                                    <p class="model-body-value" v-if="current_plan == 'quarterly'">€{{ selected_product ? selected_product.pricing.EUR.quarterly : "" }}</p>
                                    <p class="model-body-value" v-if="current_plan == 'semiannually'">€{{ selected_product ? selected_product.pricing.EUR.semiannually : "" }}</p>
                                    <p class="model-body-value" v-if="current_plan == 'annually'">€{{ selected_product ? selected_product.pricing.EUR.annually : "" }}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between model-body-li">
                                    <p class="model-body-key">Datacenter</p>
                                    <p class="model-body-value">
                                      <div v-for="(group, key) in product_group" :key="key" v-show="selected_group_id == key">
                                            <span v-if="key == 2">&nbsp;{{ $t('Netherlands') }}</span>
                                            <span v-else>&nbsp;{{ $t('USA') }}</span>
                                      </div>
                                    </p>
                                </div>
                                <!-- <div class="d-flex align-items-center justify-content-between model-body-li">
                                    <p class="model-body-key">Quantity</p>
                                    <p class="model-body-value">1 VPS</p>
                                </div> -->
                                <div class="d-flex align-items-center justify-content-between model-body-li">
                                    <div class="d-flex align-items-center justify-content-start">
                                        <img src="/assets/img/Ubuntu.svg" alt="os">
                                        <p class="model-body-key ms-2">OS</p>
                                    </div>
                                    <p class="model-body-value">{{ selected_os_name ? selected_os_name : "" }}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between model-body-li">
                                    <div class="d-flex align-items-center justify-content-start">
                                        <img src="/assets/img/cable.svg" alt="os">
                                        <p class="model-body-key ms-2">IPs</p>
                                    </div>
                                    <p class="model-body-value">{{ selected_number_of_ips }}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between model-body-li">
                                    <p class="model-body-key">Host Name</p>
                                    <p class="model-body-value">{{ hostname }}</p>
                                </div>
                                <div style="margin: 24px 0;">
                                    <div class="payment-head-div">
                                        <p class="paymet-head">Payment method</p>
                                    </div>
                                </div>

                                <div class="px-4 my-3">
                                  <div v-for="(payment_method, key) in payment_methods" :key="key">
                                    <input type="radio"  name="paymentMethod" v-model="paymentmethod"
                                      :value="payment_method.module" :checked="key == 0" />
                                    <label class="method-text" :for="'paymentMethod' + key">&nbsp;{{ payment_method.displayname }}</label>
                                  </div>

                                  <!-- added newly to implement apply credit -->
                                  <div>
                                    <input type="radio" name="paymentMethod" v-model="paymentmethod"
                                      value="credit" />
                                    <label class="method-text" for="paymentMethod">&nbsp;{{ $t('Account_Funds') }} ({{ $t('available') }} €{{
                                      user.credit }})</label>
                                  </div>
                                </div>
                      
                                <div class="checkout-btn" id="continue-order">
                                    <button class="btn w-100" @click="clickCheckout()" :disabled = 'creating_order'>{{ $t('CheckOut') }}</button>
                                </div>
                                
                            </div>
                        </div>
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
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { useRouter } from 'vue-router';
import NoPermission from '@/components/NoPermission.vue';
import Table from './components/Table.vue'
useAuth().getUser();

const modelOpen = ref(false);
const current_plan = ref('monthly');
const plan_expected = ref([
  'monthly',
  'quarterly',
  'semiannually',
  'annually',
]);
const tableHeader = ref([
    {
        name: "Name",
        slotName: "name",
    },
    {
        name: "vCPUs",
        slotName: "vcpus",
    },
    {
        name: "Memory",
        slotName: "memory",
    },
    {
      name: "Storage",
      slotName: "storage",
    },
    {
        name: "Bandwidth",
        slotName: "bandwidth",
    },
    {
        name: "Connection",
        slotName: "con",
    },
    {
        name: "Price",
        slotName: "mprice",
    },
    {
        name: "",
        slotName: "isSelecterd",
    },
])

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
const selected_number_of_ips = ref(1);
const hostname = ref("");
const hostpassword = ref("");
const paymentmethod = ref("cryptomusgateway");
const creating_order = ref(false);

const params = ref({
  client_id: user.value.client_id,
});

function clickVersion(osid, os) {
  selected_osid.value = osid;
  selected_os_name.value = os.name;
  selected_configid.value = os.config_id;
}

function clickOSGroup(index) {
  if(selected_os.value != index){
    selected_os.value = index;
    selected_osid.value = null; 
    selected_os_name.value = null;
  }
}

function clickCheckout() {
  creating_order.value = true;
  if (paymentmethod.value == 'credit' && selected_product.value.pricing.EUR.monthly > user.value.credit) {
    openModal.value = false;
    $toast.error("Please choose the OS you want to use on your VPS.");
    return;
  }
  showLoader(true);
  openModal.value = false;
  commonApi
    .runPostApi("/create-vps", {
      hostname: hostname.value,
      pwd: hostpassword.value,
      paymentMethod: paymentmethod.value,
      current_plan: current_plan.value,
      product_id: selected_product.value.pid,
      config_id: selected_configid.value,
      number_of_ips: selected_number_of_ips.value,
    })
    .then((res) => {
      creating_order.value = false;
      showLoader(false);
      if (res.data.result == "success") {
        let id = res.data.order_id;
        openModal.value = false;
        $toast.success("Successfully created vps.");
        router.push({ name: 'overview', params: { id: id , tab : 'overview', domain: hostname.value } })
      }
      else {
        $toast.error(res.data.result);
      }
    })
    .catch((e) => {
      creating_order.value = false;
      showLoader(false);
      console.log(e);
    });
  return;
}

function clickCreate() {
  if (selected_osid.value == null) {
    $toast.error("Please choose the OS you want to use on your VPS.");
    return;
  }
  if (selected_os.value == null) {
    $toast.error("Please choose the OS you want to use on your VPS.");
    return;
  }
  if (selected_product.value == null) {
    $toast.error("Please choose the VPS you want.");
    return;
  }
  if (hostpassword.value == "") {
    $toast.error("Password strength must be greater than 100");
    return;
  }
  if (hostpassword.value == "") {
    $toast.error("Please input hostname.");
    return;
  }
  // openModal.value = true;
  modelOpen.value = true;
  return;
}

function selectProduct(product) {
  if (product.stocklevel != 0) selected_product.value = product;
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
    })
    .catch((e) => {
      showLoader(false);
      console.log(e);
    });
};

function randomizePassword() {
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
    } else if (/[0-9]/.test(randomChar)) { // check if the character is a number
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

function randomizehostname() {
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
  return hostname;
}


getCreateVpsServerData();

function formattedOsName(str) {
  // Replace dashes with spaces
  let formatted = str.replace(/-/g, " ");
  
  // Capitalize the first letter
  formatted = formatted.charAt(0).toUpperCase() + formatted.slice(1);
  
  return formatted;
};

function ucfirst(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

useAuth().getUser();

</script>
  
<style scoped>
.v-toast {
  z-index: 9999 !important;
}

.single-os-div .dropdown-toggle::after {
  display: none;
}

.availability {
  display: flex;
  align-items: center;
}

.greenDot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background-color: green;
  margin-right: 5px;
}

.redDot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background-color: red;
  margin-right: 5px;
}

.text {
  white-space: nowrap;
}

.randome-btn{
  cursor: pointer;
}

.disabled-choose{
  background: rgb(200, 200, 200);
  color: white;
}

.capitalize {
  text-transform: capitalize;
}
</style>
