<template>
  <div class="sub-section server-list-tab vl-parent">
    <loading v-model:active="isLoading" :is-full-page="false" />
    <div class="d-flex justify-content-between align-items-center title-button-wrapper"></div>
    <div class="row justify-content-between align-items-center">
      <div class="row mb-5 pe-0">
        <h3 class="col-md-3 sub-title">{{ $t('services_title') }}</h3>

        <div class="col-md-9 d-flex justify-content-end pe-0 flex-wrap">
          <div class="sort-servers order-2 order-md-1">
            <div id="toggleButton" class="sort-item-active btn-chevron chevron-dark" @click="sortBy = !sortBy">
              <span>{{ $t('Sort_by_name') }}</span>
            </div>
            <div class="sorting-items" v-if="sortBy">
              <ul>
                <li @click="setOrder('regdate', 'desc')">{{ $t('Created_date') }}</li>
                <li @click="setOrder('nextduedate', 'asc')">{{ $t('Expiration_date') }}</li>

              </ul>
            </div>
          </div>

          <ul class="nav nav-pills four-pills mb-3 mb-md-0 order-1 order-md-2 mb-lg-0 flex-nowrap" id="pills-tab"
            role="tablist">
            <li v-for="state in states" :key="state" class="nav-item" role="presentation">
              <button v-if="state_order?.[state] && state != 'Fraud'"
                :class="['nav-link', state === 'Active' ? 'active' : '']" :id="'pills-' + state + '-tab'"
                data-bs-toggle="pill" :data-bs-target="'#pills-' + state" type="button" role="tab"
                :aria-controls="'pills-' + state" :aria-selected="state === 'Active'" @click="clickState(state)">
                {{ $t(state) }}
              </button>
            </li>
          </ul>

        </div>
      </div>
      <template v-if="user && user.permissions.split(',').includes('products')">
        <div class="tab-content" id="pills-tabContent">
          <div v-for="state in states" :key="state"
            :class="['tab-pane', { 'fade': state !== 'Active' }, { 'show active': state === 'Active' }]"
            :id="'pills-' + state" role="tabpanel" :aria-labelledby="'pills-' + state + '-tab'">
            <div class="row mb-5">
              <div v-if="state_order?.[state]" v-for="order in paginatedServers(state) " :key="order.orderid"
                class="col-12 col-lg-4 col-md-6 col-sm-12">
                <div class="card-item p-4 mb-4">
                  <div class="server-list-item">
                    <div class="server-list-item-wrapper">
                      <div class="image-wrapper">
                        <img :src="'assets/img/' + order.sys_log + '-logo.png'" alt="">
                      </div>
                      <div class="list-item-detail">
                        <h2 class="list-name">{{ order.name }}</h2>
                        <h3 class="detail">{{ order.configoptions.configoption[1].value }}</h3>
                        <div v-if="state !== 'Cancelled'" class="server-list-options">
                          <div class="options-toggle dropdown-toggle hideIcon"
                            style="padding-right: 10px; padding-left: 10px;" data-bs-toggle="dropdown"></div>
                          <div class="options-toggle-dropdown dropdown-menu dropdown-menu-end">
                            <ul>
                              <li>
                                <router-link
                                  class="logo-wrapper d-flex align-items-center col-md-2 text-dark text-decoration-none order-lg-1"
                                  :to="{ name: 'overview', params: { id: order.orderid } }">
                                  {{ $t('Launch_Control_Panel') }}
                                </router-link>
                              </li>
                              <li>
                                <router-link
                                  class="logo-wrapper d-flex align-items-center col-md-2 text-dark text-decoration-none order-lg-1"
                                  to="/balance">
                                  {{ $t('View_Invoices') }}
                                </router-link>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div v-if="state === 'Active'" class="server-list-item">
                    <div class="server-list-item-wrapper">
                      <div class="image-wrapper">
                        <img class="dark-img-filter" src="assets/img/cloud-connection.png" alt="">
                      </div>
                      <div class="list-item-detail">
                        <div style="display: flex; justify-content: space-between;">
                          <!-- main ip address -->
                          <h2 class="list-name">
                            {{ order.dedicatedip }}
                            <div class="server-list-options"
                              style="z-index: 999; top: 0px !important; position: inherit; display: inline-block;"
                              v-if="order.assignedips">
                              <div class="options-toggle dropdown-toggle hideIcon" style="padding-right: 10px; padding-left: 10px; background: none;
                                
                            " data-bs-toggle="dropdown">
                                <span class="badge bg-dark">
                                  {{ count_ips(order.assignedips) }}
                                </span>
                              </div>
                              <div class="options-toggle-dropdown dropdown-menu dropdown-menu-end" style="padding: 10px !important;
                                box-shadow: 2px 3px 2px rgb(200,200,200)" v-html="formattedText(order.assignedips)">
                              </div>
                            </div>
                          </h2>

                        </div>

                        <h3 class="detail">{{ $t('Created_at') }} {{ order.regdate }}</h3>
                        <h3 class="detail" style="margin-top:5px;">{{ $t('Due_date_at') }} &nbsp;{{ order.nextduedate }}
                        </h3>
                      </div>
                      <div v-if="state === 'Active'" class="server-list-options">
                        <button class="active-badge"><span class="active-dot"></span>{{ $t('Active') }}</button>
                      </div>
                    </div>
                  </div>
                  <div class="server-list-item">
                    <div class="server-list-item-wrapper">
                      <div class="image-wrapper">
                        <img :src="'assets/img/' + order.flag + '.png'" alt="">
                      </div>
                      <div class="list-item-detail">
                        <h2 class="list-name">{{ order.groupname }}</h2>
                        <h3 class="detail">{{ $t('Hostname') }} : {{ order.domain }}</h3>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div v-if="state === 'Active' && (!state_order?.[state] || state_order?.[state]?.length === 0)">
                <h5 style="margin-top: 20px; text-align: center;">{{ $t('No_Active_Product') }} </h5>
              </div>
            </div>
          </div>
        </div>
      </template>

      <template v-else>
        <NoPermission />
      </template>

    </div>
    <div class="w-100 server-list-pagination">
      <Pagination :currentPage="params.page" :totalPages="totalFilterPages" @page-changed="onPageChanged" />
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref, onBeforeUnmount } from "vue";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
import { useStore } from 'vuex';
import { commonApis } from '@/apis/commonApis';
import { showLoader } from '@/plugins/loading.js';
// toast
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import Pagination from '@/components/Pagination.vue';
import NoPermission from '@/components/NoPermission.vue';

const totalPages = ref(0);
const perPage_servers = 9;


function paginatedServers(state) {
  let tempArray = state_order.value;
  const startIndex = (params.value.page - 1) * perPage_servers;
  const endIndex = startIndex + perPage_servers;
  return tempArray[state].slice(startIndex, endIndex);
}

const formattedText = (text) => {
  return text.replace(/\n/g, "<br>");
}

const count_ips = (text) => {
  if(text == null || text == '') return 0;
  return text.split('\n').length;
}

const $toast = useToast();
const sortBy = ref(false);
const store = useStore();
const user = computed(() => store.state.auth.user)
const commonApi = commonApis()
const servers = ref([]);
const states = ref([]);
const state_order = ref([]);
const params = ref(
  { 'client_id': user.value.client_id, orderby: '', order: '', page: 1 }
)
const isLoading = ref(false);
const totalFilterPages = ref(1);

function onPageChanged(page) {
  params.value.page = page;
}

const clickState = (state) => {
  let tempArray = state_order.value;
  totalFilterPages.value = Math.ceil(tempArray[state].length / perPage_servers);
}

const getServersData = () => {
  // showLoader(true);
  isLoading.value = true;
  commonApi.runGetApi('/servers', params.value).then((res) => {
    isLoading.value = false;
    sortBy.value = false;
    servers.value = res.data.products;
    states.value = res.data.states;
    state_order.value = res.data.state_order;
    let tempArray = state_order.value;
    totalFilterPages.value = Math.ceil(tempArray['Active'].length / perPage_servers);

  }).catch((e) => {
    console.log(e);
    isLoading.value = false;

  })
}

function setOrder(orderBy, order) {
  params.value.orderby = orderBy
  getServersData()
}

getServersData()

</script>

<style scoped>
.hide-icon::after {
  display: none !important;
}

.dropdown-toggle:empty::after {
  display: none !important;
}
</style>
